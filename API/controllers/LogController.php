<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\Users;

use backend\controllers\BaseController;
use backend\components\LogData;

class LogController extends BaseController
{
    public function actionSave()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $post = file_get_contents("php://input");
      $data = json_decode($post);

      $salida = ['error' => ''];

      $userM = Users::findOne(['token'=>$data->token]);

      if (count($userM) != 1){ //si el usuario no existe
        $salida['error'] = 'invalid token';

        $log = new LogData(['categoriaLog' => 'login_error']);
        $log->toLog('token not found: '."\n"
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

      $log = new LogData(['categoriaLog' => $userM->email]);
      $log->toLog('Log operation: '."\n"
          .json_encode([
            'info'   => [
              'ip' => [
                'REMOTE_ADDR'    => (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '',
                'HTTP_CLIENT_IP' => (isset($_SERVER['HTTP_CLIENT_IP']))? $_SERVER['HTTP_CLIENT_IP'] : '',
                'REMOTE_ADDR'    => (isset($_SERVER['REMOTE_ADDR']))? $_SERVER['REMOTE_ADDR'] : '',
              ]
            ],
            'log' => $data->log,
          ]));
      $log->closeLog();

      return $this->JSONOut($salida);
    }
}
