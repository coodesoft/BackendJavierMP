<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;

use backend\controllers\BaseController;
use common\models\Users;

class DocumentsController extends BaseController
{
    public function actionSendByEmail()
    {
      $id = 'send-by-email';
      $this->getInputData($id);

      //validamos el token
      if (!isset($this->input['headers']['Authorization'])){ return $this->errorResult( $id, 'token not found' ); }
      $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Authorization'])[1]]);
      if (count($userM) != 1){ return $this->errorResult( $id, 'user not found' ); }

      //validamos el EMail
      if (!isset($this->input['data']->EMail)){ return $this->errorResult( $id, 'Dirección de E-Mail inválida.' ); }
      if (!$this->is_valid_email($this->input['data']->EMail)){ return $this->errorResult( $id, 'Dirección de E-Mail inválida.' ); }

      //obtenemos los documentos documentos
      $documents = [];

      //Se envía el email
      
      $this->salida['error'] = '';
      $this->salida['result']['success'] = true;

      return $this->successResult($id);
    }
}
