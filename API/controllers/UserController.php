<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\Users;

use backend\controllers\BaseController;

class UserController extends BaseController
{
  public funtion actionCrear()
  {
    $id = 'crear-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }



    $this->salida['error'] = '';
    $this->salida['result']['success'] = true;

    return $this->successResult($id);
  }

  public funtion actionEditar()
  {
    $id = 'editar-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }



    $this->salida['error'] = '';
    $this->salida['result']['success'] = true;

    return $this->successResult($id);
  }

  public funtion actionBorrar()
  {
    $id = 'borrar-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }



    $this->salida['error'] = '';
    $this->salida['result']['success'] = true;

    return $this->successResult($id);
  }
}
