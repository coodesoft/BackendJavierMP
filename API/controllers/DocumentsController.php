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
      if ( !isset($this->input['data']->DocumentsAvailable ) ){ return $this->errorResult( $id, 'data not found' ); }
      for( $c=0; $c < count($this->input['data']->DocumentsAvailable ); $c++){
        if ($this->input['data']->DocumentsAvailable[$c]->v){
          $url      = 'http://190.2.42.25:8060/Services/api/AP/ImprimirDocumento?';
          $params   = 'seccion=12'.'&Poliza='.$this->input['data']->IDPoliza.'&tipo='.$this->input['data']->DocumentsAvailable[$c]->IDTipo;
          $pe = curl_init();
          curl_setopt($pe, CURLOPT_URL, $url.$params);
          curl_setopt($pe, CURLOPT_CUSTOMREQUEST, "GET");
          curl_setopt($pe, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($pe, CURLOPT_HTTPHEADER, ['Content-Type: content-type: multipart/form-data; boundary=---011000010111000001101001','Authorization: Basic Y3J1enN1aXphOmNydXpzdWl6YQ==']);
          $response = json_decode(curl_exec($pe));
          curl_close($pe);
          $documents[] = ['Nombre' => $response->Nombre, 'Contenido' => $response->Contenido];
        }
      }

      if (count($documents) == 0){ return $this->errorResult( $id, 'No se especificaron documentos a enviar' ); }

      //Se envía el email
      $email = \Yii::$app->mail->compose('send_documents',['nro_pol' => $this->input['data']->IDPoliza])
        ->setFrom([\Yii::$app->params['adminEmail'] => 'eBroker'])
        ->setTo($this->input['data']->EMail)
        ->setSubject('[eBroker] Envío de documentos - póliza n°'.$this->input['data']->IDPoliza );
      for ($c=0; $c<count($documents); $c++){
        $email->attachContent(base64_decode($documents[$c]['Contenido']), ['fileName' => $documents[$c]['Nombre'], 'contentType' => 'application/pdf']);
      }
      $email->send();

      $this->salida['error'] = '';
      $this->salida['result']['success'] = true;

      return $this->successResult($id);
    }
}
