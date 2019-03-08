<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;

use backend\controllers\BaseController;
use common\models\Users;

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
    $this->salida['result']['success'] = true;

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
    $this->salida['result']['success'] = true;

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
    $this->salida['result']['success'] = true;

    return $this->successResult($id);
  }
}