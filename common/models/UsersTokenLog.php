<?php
namespace common\models;

use Yii;

class UsersTokenLog{

    public  $UserID;
    public  $Token;
    private $DateTime;

    public function save(){
      $this->DateTime = date('Y-m-d H-i-s');

      $consulta = Yii::$app->db->createCommand()
                  ->insert('UsersTokenLog',[
                    'IdUser'   => $this->UserID,
                    'Token'    => $this->Token,
                    'DateTime' => $this->DateTime,
                  ])->execute();
    }
}
