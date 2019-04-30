<?php
namespace common\models;

use Yii;
use common\models\OrganizationSection;
use common\models\UsersTokenLog;
use common\models\Usersinorganization;
use common\models\UsersInRole;

class Users extends \yii\db\ActiveRecord
{
    public $errors;

    private $c;

    public static function tableName()
    {
        return 'Users';
    }

    // CREAR UN NUEVO usuario
    public function create($d){ //[Modificar] Hay que aplicar transacciones
      $usr = new Users();
      $usr->FirstName = $d->personal_info->FirstName;
      $usr->LastName  = $d->personal_info->LastName;
      $usr->email     = $d->personal_info->email;
      $usr->created   = date('Y-m-d H-i-s');
      $usr->updated   = date('Y-m-d H-i-s');

      if (!$usr->save(false)) { return false; }

      $uio = new Usersinorganization();
      $uio->OrganizationId = $d->organization;
      $uio->UserId         = $usr->id;
      if (!$uio->save(false)) { return false; }

      for($c=0;$c<count($d->Rol_list);$c++){
        if($d->Rol_list[$c]->v){
          $r = new UsersInRole();
          $r->RoleId = $d->Rol_list[$c]->cod;
          $r->UserId = $usr->id;
          $r->save(false);
        }
      }

      return $uio->save(false);
    }

    //editar
    public function edit($d){ // [Modificar] hay que aplicar transacciones de yii
      $usr = Users::findOne(['id'=>$d->id]);
      $usr->FirstName = $d->personal_info->FirstName;
      $usr->LastName  = $d->personal_info->LastName;
      $usr->email     = $d->personal_info->email;
      $usr->created   = date('Y-m-d H-i-s');
      $usr->updated   = date('Y-m-d H-i-s');

      //se actualiza la contraseña en caso de que se hay especificado una nueva
      if ($d->Pass != ''){
        if ($d->Pass != $d->RPass) { return false; }
        $usr->password = password_hash($d->Pass, PASSWORD_DEFAULT);
      }

      if (!$usr->save(false)) { return false; }

      Usersinorganization::deleteAll(['UserId' => $d->id]);
      $uio = new Usersinorganization();
      $uio->OrganizationId = $d->organization;
      $uio->UserId         = $usr->id;
      if (!$uio->save(false)) { return false; }

      //se borran los registros de users inrole
      UsersInRole::deleteAll(['UserId' => $d->id]);
      for($c=0;$c<count($d->Rol_list);$c++){
        if($d->Rol_list[$c]->v){
          $r = new UsersInRole();
          $r->RoleId = $d->Rol_list[$c]->cod;
          $r->UserId = $usr->id;
          $r->save(false);
        }

      }

      return true;
    }

    public static function getAll(){
      $all = (new \yii\db\Query())
                  ->select('U.id, U.FirstName, U.LastName, U.email, U.disabled_on, O.Name AS Organization ')->distinct()->from( self::tableName().' U' )
                  ->innerJoin('UsersInOrganization UO', 'U.id=UO.UserId')
                  ->innerJoin('Organizations O', 'UO.OrganizationId=O.id')
                  ->all();
      return $all;
    }

    public static function getOneForEdit($id){
      $salida = ['personal_info' => [], 'organization' => [], 'roles' => [], 'id' => $id];

      $salida['personal_info'] = (new \yii\db\Query())
                  ->select('FirstName, LastName, email')->distinct()->from( self::tableName() )
                  ->where(['id' => $id])
                  ->all()[0];

      $salida['organization'] = self::getOrganization($id);

      $salida['roles'] = self::getRoles($id);

      return $salida;
    }

    public static function getRoles($id){
      $all = (new \yii\db\Query())
                  ->select('R.*')->from( 'UsersInRole UR' )
                  ->innerJoin('Roles R', 'UR.RoleId=R.id')
                  ->where(['UserId' => $id])
                  ->all();
      return $all;
    }

    public static function getOrganization($id){
      $all = (new \yii\db\Query())
                  ->select('UO.*, O.name, O.email')->from( 'UsersInOrganization UO' )
                  ->innerJoin('Organizations O', 'UO.OrganizationId=O.id')
                  ->where(['UO.UserId' => $id])
                  ->all();
      return $all[0];
    }

    public static function enable($id){
      $userM = self::findOne(['id'=>$id]);
      if (count($userM)==0){ return false;  }

      $userM->disabled_on = NULL;
      return $userM->save(false);
    }

    public static function disableUser($id){
      $userM = self::findOne(['id'=>$id]);
      if (count($userM)==0){ return false;  }

      $userM->disabled_on = date('Y-m-d H-i-s');
      return $userM->save(false);
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

    // INFORMACIÓN DE LA ORGANIZACIÓN
    public function getOrganizationInfo(){
      $organizations =  (new \yii\db\Query())
                  ->select('O.Code, O.Name, O.id, O.email')->from('Organizations O')
                  ->innerJoin('UsersInOrganization UO', 'O.id=UO.OrganizationId')
                  ->where(['UO.UserId' => $this->id])
                  ->all();
      return $organizations;
    }

    //INICIO DE SESION
    private function newToken(){
      $this->token_datetime = date('Y-m-d H-i-s');
      $this->token = password_hash($this->email.$this->token_datetime, PASSWORD_DEFAULT);

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
