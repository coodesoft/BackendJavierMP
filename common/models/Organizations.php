<?php

namespace common\models;

use Yii;
use common\models\Users;

/**
 * This is the model class for table "organizations".
 *
 * @property int $id
 * @property string $Code
 * @property string $Name
 * @property string $Type
 * @property string $Enrollment_code
 * @property string $Created
 * @property string $Updated
 */
class Organizations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Organizations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Created', 'Updated'], 'safe'],
            [['Code'], 'string', 'max' => 10],
            [['Name'], 'string', 'max' => 40],
            [['Type'], 'string', 'max' => 1],
            [['Enrollment_code'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Code' => 'Code',
            'Name' => 'Name',
            'Type' => 'Type',
            'Enrollment_code' => 'Enrollment Code',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }

    public static function getAll(){
      $all = (new \yii\db\Query())
                  ->select('*')->from( self::tableName() )
                  ->all();
      return $all;
    }

    public static function getOneForEdit($id){
      $salida = (new \yii\db\Query())
                  ->select('*')->distinct()->from( self::tableName() )
                  ->where(['id' => $id])
                  ->all()[0];
      return $salida;
    }

    public static function edit($d){
      $org = Organizations::findOne(['id'=>$d->Id]);
      //if (count($org)>0){ return false;  }

      $org->Code  = $d->Code;
      $org->Name  = $d->Name;
      $org->email = $d->Email;
      $org->Updated = date('Y-m-d H-i-s');
      return $org->save(false);
    }

    public static function disable($d){
      $org = Organizations::findOne(['id'=>$d]);
      if (count($org)==0){ return true;  }
      $org->disabled_on = date('Y-m-d H-i-s');
      //si no se pudo guardar
      if (!$org->save(false)){ return false; }

      //se desabilitan todos los usuarios asociados a esa organizacion
      $usrs = (new \yii\db\Query()) //[Modificar] esto tendria que hacerse con una consulta
                  ->select('*')->distinct()->from( 'UsersInOrganization' )
                  ->where(['OrganizationId' => $d])
                  ->all();

      for ($c=0;$c<count($usrs);$c++){
        Users::disableUser($usrs[$c]['UserId']);
      }
      return true;
    }

    public static function enable($d){
      $org = Organizations::findOne(['id'=>$d]);
      if (count($org)==0){ return true;  }
      $org->disabled_on = NULL;
      //si no se pudo guardar
      if (!$org->save(false)){ return false; }

      //se desabilitan todos los usuarios asociados a esa organizacion
      $usrs = (new \yii\db\Query()) //[Modificar] esto tendria que hacerse con una consulta
                  ->select('*')->distinct()->from( 'UsersInOrganization' )
                  ->where(['OrganizationId' => $d])
                  ->all();

      for ($c=0;$c<count($usrs);$c++){
        Users::enable($usrs[$c]['UserId']);
      }
      return true;
    }

    public static function create($d){
      $org = new Organizations();
      $org->Code  = $d->Code;
      $org->Name  = $d->Name;
      $org->email = $d->Email;
      $org->Created = date('Y-m-d H-i-s');
      $org->Updated = date('Y-m-d H-i-s');
      return $org->save(false);
    }
}
