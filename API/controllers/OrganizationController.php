<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;

use backend\controllers\BaseController;
use common\models\Users;
use common\models\Organizations;

class OrganizationController extends BaseController
{
  public function actionCreate()
  {
    $id = 'crear-organization';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Organizations::create($this->input['data']);

    return $this->successResult($id);
  }

  public function actionEdit()
  {
    $id = 'editar-organization';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Organizations::edit($this->input['data']);

    return $this->successResult($id);
  }

  public function actionDelete()
  {
    $id = 'borrar-organization';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Organizations::disable($this->input['data']->id);

    return $this->successResult($id);
  }

  public function actionEnable()
  {
    $id = 'enable-organization';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['success'] = Organizations::enable($this->input['data']->id);

    return $this->successResult($id);
  }

  public function actionGetAll()
  {
    $id = 'get-all-organization';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['organizations'] = Organizations::getAll();

    return $this->successResult($id);
  }

  public function actionGetOne()
  {
    $id = 'get-one-organization';
    $this->getInputData($id);

    //validamos el token
    if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
    $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
    if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

    $this->salida['error'] = '';
    $this->salida['result']['organization'] = Organizations::getOneForEdit($this->input['data']->id);

    return $this->successResult($id);
  }
}
