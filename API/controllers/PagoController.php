<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;

use backend\controllers\BaseController;
use common\models\Users;

class PagoController extends BaseController
{
    public function actionNuevo()
    {
      $id = 'nuevo-pago';
      $this->getInputData($id);

      //validamos el token
      if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
      $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
      if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }


      $this->salida['error'] = '';
      $this->salida['result']['success'] = true;

      return $this->successResult($id);
    }

    public function actionProcesar()
    {
      $id = 'procesar-pagos';
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
