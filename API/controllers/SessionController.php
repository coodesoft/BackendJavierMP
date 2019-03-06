<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\Users;

use backend\controllers\BaseController;
use backend\components\LogData;
use common\models\AuthorizedLog;

class SessionController extends BaseController
{
    public function actionNewResetPassToken(){
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $salida = ['error' => ''];

      $post = file_get_contents("php://input");
      $data = json_decode($post);

      if($data == NULL){
        $salida['error'] = 'invalid input data';
        return $this->JSONOut($salida);
      }

      $userM = Users::findOne(['email'=>$data->email]);

      if (count($userM) != 1){ //si el usuario no existe
        $salida['error'] = 'user not found';
        return $this->JSONOut($salida);
      }

      $userM->newResetPassToken();

      \Yii::$app->mail->compose('reset_pass',['link' => $userM->reset_token])
        ->setFrom([\Yii::$app->params['adminEmail'] => 'eBroker'])
        ->setTo($data->email)
        ->setSubject('[eBroker] Recuperar contraseña' )
        ->send();

        $log = new LogData(['categoriaLog' => 'session']);
        $log->toLog('reset pass: '.$data->email."\n"
            .json_encode([
              'info'   => [
                'ip' => [
                  'REMOTE_ADDR'    => (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '',
                  'HTTP_CLIENT_IP' => (isset($_SERVER['HTTP_CLIENT_IP']))? $_SERVER['HTTP_CLIENT_IP'] : '',
                  'REMOTE_ADDR'    => (isset($_SERVER['REMOTE_ADDR']))? $_SERVER['REMOTE_ADDR'] : '',
                ]
              ],
            ]));
        $log->closeLog();

      return $this->JSONOut($salida);
    }

    public function actionLogin()
    {
      $this->getInputData('login');
      $userM = Users::findOne(['email'=>$this->input['data']->email]);

      //si el usuario no existe
      if (count($userM) != 1){ return $this->errorResult( 'login', 'user not found' ); }

      if (!$userM->login($this->input['data']->password)){ return $this->errorResult( 'login', 'bad login' ); }

      $this->salida['result']['success']        = true;
      $this->salida['result']['token']          = 'Bearer '.$userM->token;
      $this->salida['result']['personal_data']  = $userM->getPersonalData();
      $this->salida['result']['UserTypeCode']   = $userM->UserTypeCode;
      $this->salida['result']['functions']      = $userM->getFunctions();
      $this->salida['result']['organization']   = $userM->getOrganizationInfo();
      $this->salida['result']['documents']      = $userM->getDocumentsAuthorized();

      return $this->successResult('login');
    }

    public function actionUpdatePass()
    {
      $this->getInputData('update_pass');

      if (!isset($this->input['headers']['Token'])){ return $this->errorResult( 'update_pass', 'token not found' ); }

      $userM = Users::findOne(['token'=>explode(' ',$this->input['headers']['Token'])[1]]);
      //si el usuario no existe
      if (count($userM) != 1){ return $this->errorResult( 'update_pass', 'user not found' ); }

      if($this->input['data']->npass != $this->input['data']->rpass){
        return $this->errorResult( 'update_pass', 'Las contraseñas no coinciden' );
      }

      if(!$userM->updatePass(['actual'=>$this->input['data']->pass,'nueva'=>$this->input['data']->npass])){
        return $this->errorResult( 'update_pass', $userM->errors );
      }

      $this->salida['result']['success'] = true;
      return $this->successResult('update_pass');
    }

    public function actionLogout()
    {
      $this->getInputData('logout');

      $this->salida = ['error' => '', 'result' => ['success' => true]];

      return $this->successResult( 'get_auth_docs' );
    }

    public function actionIsAuthorized()
    {
      $this->getInputData('authorization');

      //log en base de datos
      $dbLog       = new AuthorizedLog();
      $dbLog->IPv4 = $this->getIPV4();

      $salir = False;
      //validaciones
      if (!isset($this->input['data']->userToken)){ $this->errorResult( 'authorization', 'token not found' ); } else {
        $dbLog->UserToken = $this->input['data']->userToken;
      }

      if (!isset($this->input['data']->functionCode)){ $this->errorResult( 'authorization', 'function code not found' ); } else {
        $dbLog->FunctionCode = $this->input['data']->functionCode;
      }

      if (!isset($this->input['data']->clientRequestData)){ $this->errorResult( 'authorization', 'client data not found' ); } else {
        $dbLog->Params = rawurldecode($this->input['data']->clientRequestData);
      }

      if (!isset($this->input['data']->clientRequestData->method)){ $this->errorResult( 'authorization', 'method not found' ); } else {
        $dbLog->Method = $this->input['data']->clientRequestData->method;
      }
      $dbLog->save();

      if ($salir){
        return $this->salida;
      }

      $userM = Users::findOne(['token' => explode(' ',$this->input['data']->userToken)[1] ]);

      if (count($userM) != 1){ //si el usuario no existe
        return $this->errorResult( 'authorization', 'user_not_found: '.$this->input['data']->userToken );
      }

      $this->salida['result']['success'] = $userM->functionInUser($this->input['data']->functionCode);
      return $this->successResult( 'authorization' );

    }
}
