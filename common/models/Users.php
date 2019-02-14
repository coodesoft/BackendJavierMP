<?php
namespace common\models;

use Yii;
use common\models\UsersInRole;
use common\models\Usersinorganization;
use common\models\OrganizationSection;
use common\models\UsersTokenLog;

class Users extends \yii\db\ActiveRecord
{
    public $errors;

    private $c;

    public static function tableName()
    {
        return 'Users';
    }

    // CREAR UN NUEVO usuario
    public function create($data){

    }
    // ACTUALIZACION DE CONTRASEÑA
    public function updatePass($p){
      if (!password_verify($p['actual'],$this->password)){
        $this->errors .= 'Contraseña actual incorrecta';
        return false;
      }

      $this->password = password_hash($p['nueva'], PASSWORD_DEFAULT);
      return $this->save(false);
    }

    // RESETEO DE CONTRASEÑA
    public function setPassword($pass){
      $this->password = password_hash($pass, PASSWORD_DEFAULT);
      $this->save(false);
    }

    public static function findByPasswordResetToken($t){
      return Users::findOne(['reset_token'=>$t]);
    }

    public function removePasswordResetToken(){
      $this->reset_token = "";
      $this->save(false);
    }

    public function newResetPassToken(){
      $this->reset_date  = date('Y-m-d H-i-s');
      $this->reset_token = password_hash($this->email.$this->reset_date, PASSWORD_DEFAULT);

      $userM = Users::findOne(['reset_token'=>$this->reset_token]);
      if (count($userM)>0){
        $this->c ++;
        return $this->newResetPassToken();
      }

      if ($this->c > 10){
        $this->errors .= ' error 1-u';
        return false;
      }

      if ($this->save()){
        return true;
      }
    }

    // DOCUMENTOS ACCESIBLES
    public function getDocumentsAuthorized(){
      $documents = (new \yii\db\Query())
                  ->select('D.*, OT.cod as ObjectTypeCode')->distinct()->from('DocumentTypes D')
                  ->innerJoin('ObjectType OT', 'D.ObjectTypeId=OT.id')
                  ->innerJoin('DocumentsPerProfile DP', 'D.id=DP.IdDocument')
                  ->innerJoin('Profiles P', 'DP.IdProfile=P.id')
                  ->innerJoin('UsersInProfile UP', 'P.id=UP.idProfile')
                  ->where(['UP.idUser' => $this->id])
                  ->all();
      return $documents;
    }

    //INICIO DE SESION
    private function newToken(){
      $this->token_datetime = date('Y-m-d H-i-s');
      $this->token = password_hash($this->email.$this->token_datetime, PASSWORD_DEFAULT); //'Y3J1enN1aXphOmNydXpzdWl6YQ==';

      $userM = Users::findOne(['token'=>$this->token]);
      if (count($userM)>0){
        $this->c ++;
        return $this->newResetPassToken();
      }

      if ($this->c > 10){
        $this->errors .= ' error 2-u';
        return false;
      }

      if ($this->save(false)){
        return true;
      }
    }

    public function getPersonalData(){
      return [
        'FirstName' => $this->FirstName,
        'LastName'  => $this->LastName,
      ];
    }

    public function login($pass){
      if ($this->password == null)
        return false;

      if (password_verify($pass,$this->password)){
        $this->newToken();

        $TokenLog         = new UsersTokenLog;
        $TokenLog->UserID = $this->id;
        $TokenLog->Token  = $this->token;
        $TokenLog->save();

        return true;
      }

      return false;
    }

    public function getFunctions(){
      $functions = (new \yii\db\Query())
                  ->select('F.*')->distinct()->from('Functions F')
                  ->innerJoin('FunctionsInRole FR', 'F.id=FR.FunctionId')
                  ->innerJoin('UsersInRole UIR', 'FR.RoleId=UIR.RoleId')
                  ->where(['UIR.UserId' => $this->id])
                  ->all();

      $salida = [];
      foreach ($functions as $k => $v) {
        array_push($salida,['code' => $v['Code']]);
      }
      return $salida;
    }

    public function functionInUser($code){
      $functions = $this->getFunctions();

      foreach ($functions as $k => $v) {
        if($v['code']==$code){
          return true;
        }
      }
      return false;
    }

    public function getOrganization(){
      $salida = [];
      return $salida;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated', 'disabled_on', 'pw_expiration_date'], 'safe'],
            [['created_by'], 'integer'],
            [['FirstName', 'LastName'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'FirstName'          => 'First Name',
            'LastName'           => 'Last Name',
            'email'              => 'Email',
            'password'           => 'Password',
            'created'            => 'Created',
            'updated'            => 'Updated',
            'created_by'         => 'Created By',
            'disabled_on'        => 'Disabled On',
            'pw_expiration_date' => 'Pw Expiration Date',
            'token'              => 'Token',
        ];
    }

    public function getUsersinroles()
    {
        return $this->hasMany(UsersInRole::className(), ['UserId' => 'id']);
    }

}
