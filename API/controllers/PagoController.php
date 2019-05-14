<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;

use backend\controllers\BaseController;
use common\models\Pago;
use common\models\Users;
use common\models\MercadoPagoModel;

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

      //Creamos un nuevo pago
      $pago              = new Pago();
      $pago->id_creator  = $userM->id;
      $pago->amount      = $this->input['data']->monto;
      $pago->description = $this->input['data']->descripcion;
      $pago->email       = $this->input['data']->email;

      //Si hay errores los reportamos
      if( !$pago->create() ){ return $this->errorResult( $id,$pago->errors ); }

      //caso contrario proseguimos
      $this->salida['error'] = '';
      $this->salida['result']['id_pago'] = $pago->id;
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

      $MP = new MercadoPagoModel();
      $MP->setMP();

      $payment = new \MercadoPago\Payment();

      $payment->transaction_amount = $this->input['data']->monto;
      $payment->token              = $this->input['data']->token;
      $payment->description        = $this->input['data']->descripcion;
      $payment->installments       = 1;
      $payment->payment_method_id  = $this->input['data']->paymentMethodId;
      $payment->payer = [
        "email" => $this->input['data']->email
      ];
      $payment->save();

      $pago                = Pago::findOne(['id'=>$this->input['data']->id]);
      $pago->status        = $payment->status;
      $pago->preference_id = $payment->id;
      $pago->save(false);

      if ($payment->status != 'approved') { return $this->errorResult( $id, 'Pago rechazado' ); }

      $this->salida['error'] = '';
      $this->salida['result']['id_pago'] = $this->input['data']->id;
      $this->salida['result']['success'] = true;

      return $this->successResult($id);
    }
}
