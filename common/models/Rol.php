<?php
namespace common\models;

use Yii;

class Rol extends \yii\db\ActiveRecord
{
    public $errors;

    public static function tableName()
    {
        return 'Roles';
    }

    // CREACIÓN
    public function create($data){

    }
    // ACTUALIZACION

    // BORRADO

    // CONSULTA
    public static function getAll(){
      $all = (new \yii\db\Query())
                  ->select('code, Name, Description, id')->distinct()->from( self::tableName() )
                  ->all();
      return $all;
    }


    public function rules(){ return []; }
    public function attributeLabels() { return []; }

}
