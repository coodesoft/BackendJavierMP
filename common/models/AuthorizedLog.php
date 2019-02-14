<?php
namespace common\models;

use Yii;

class AuthorizedLog{

    public  $Method;
    public  $UserToken;
    public  $FunctionCode;
    public  $IPv4;
    public  $Params;
    private $DateTime;

    public function save(){
      $this->DateTime = date('Y-m-d H-i-s');

      $consulta = Yii::$app->db->createCommand()
                  ->insert('AuthorizedLog',[
                    'Method'       => $this->Method,
                    'UserToken'    => $this->UserToken,
                    'FunctionCode' => $this->FunctionCode,
                    'Params'       => $this->Params,
                    'IPv4'         => $this->IPv4,
                    'DateTime'     => $this->DateTime,
                  ])->execute();
    }
}
