<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\Users;

use backend\controllers\BaseController;

class UserController extends BaseController
{
  public function actionCreate()
  {
    $id = 'crear-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Users::create($this->input['data']);

    return $this->successResult($id);
  }

  public function actionEdit()
  {
    $id = 'editar-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Users::edit($this->input['data']);

    return $this->successResult($id);
  }

  public function actionDelete()
  {
    $id = 'borrar-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    if ($userM->id == $this->input['data']->id) { return $this->errorResult( $id, 'No se puede desabilitar el usuario actual' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Users::disableUser($this->input['data']->id);

    return $this->successResult($id);
  }

  public function actionEnable()
  {
    $id = 'enable-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Users::enable($this->input['data']->id);

    return $this->successResult($id);
  }

  public function actionGetAll()
  {
    $id = 'get-all-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['users'] = Users::getAll();

    return $this->successResult($id);
  }

  public function actionGetOne()
  {
    $id = 'get-one-usuario';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['user'] = Users::getOneForEdit($this->input['data']->id);

    return $this->successResult($id);
  }
}
