<?php
namespace backend\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\base\InlineAction;

use backend\components\LogData;

class BaseController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return array_merge([
            'cors' => [
                'class' => Cors::className(),

                #common rules
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ], parent::behaviors());
    }

    ////////////////////////////////////////////////////////////////////////
    ///// Validacion de EMail
    protected function is_valid_email($str)
    {
      $result = (false !== filter_var($str, FILTER_VALIDATE_EMAIL));

      if ($result)
      {
        list($user, $domain) = explode('@', $str);

        $result = checkdnsrr($domain, 'MX');
      }

      return $result;
    }

    ////////////////////////////////////////////////////////////////////////
    ///// METODOS COMUNES PARA Entrada
    ////////////////////////////////////////////////////////////////////////
    protected $input = ['data' => [], 'headers' => []];

    protected function getInputData($action_cod){
      $post                   = file_get_contents("php://input");
      $this->input['data']    = json_decode($post);
      $this->input['headers'] = getallheaders();

      $this->inputLog($action_cod);
    }

    ////////////////////////////////////////////////////////////////////////
    ///// METODOS COMUNES PARA SALIDA
    ////////////////////////////////////////////////////////////////////////

    protected $salida = ['error' => '', 'result' => ['success' => false]];

    protected function errorResult($action_cod, $e){
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $this->salida['error']             = $e;
      $this->salida['result']['success'] = false;
      $this->errorLog($action_cod, $e);
      return $this->salida;
    }

    protected function successResult($action_cod){
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $this->outputLog($action_cod);
      return $this->salida;
    }

    protected function JSONOut($salida){
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      header('Content-type: application/json;charset=utf-8');
      header('Access-Control-Allow-Origin: *');
      return json_encode($salida);
    }

    ////////////////////////////////////////////////////////////////////////
    ///// METODOS COMUNES PARA Log
    ////////////////////////////////////////////////////////////////////////
    protected function inputLog($categoria){
      $HTC = '';
      if (isset($_SERVER['HTTP_CLIENT_IP'])) { $HTC = $_SERVER['HTTP_CLIENT_IP']; }

      $log = new LogData(['categoriaLog' => 'input_'.$categoria.'_log']);
      $log->toLog('data: '."\n" .'REMOTE_ADDR: '.$this->getIPV4()."\n" .'HTTP_CLIENT_IP: '.$HTC."\n" .'DATA: '.json_encode($this->input));
      $log->closeLog();
    }

    protected function errorLog($categoria, $e){
      $log = new LogData(['categoriaLog' => 'error_'.$categoria.'_log']);
      $log->toLog($e);
      $log->closeLog();
    }

    protected function outputLog($categoria){
      $log = new LogData(['categoriaLog' => 'output_'.$categoria.'_log']);
      $log->toLog(json_encode($this->salida));
      $log->closeLog();
    }

    ////////////////////////////////////////////////////////////////////////
    ///// Conf global
    ////////////////////////////////////////////////////////////////////////

    protected $ipV4 = '';
    protected function getIPV4(){
      if (isset($_SERVER['REMOTE_ADDR']))    { $this->ipV4 = $_SERVER['REMOTE_ADDR'];     }
      return $this->ipV4;
    }

    public function createAction($id)
    {
        if ($id === '') {
            $id = $this->defaultAction;
        }

        $actionMap = $this->actions();
        if (isset($actionMap[$id])) {
            return Yii::createObject($actionMap[$id], [$id, $this]);
        } elseif (preg_match('/^[a-zA-Z0-9\\-_]+$/', $id) && strpos($id, '--') === false && trim($id, '-') === $id) {
            $methodName = 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $id))));
            if (method_exists($this, $methodName)) {
                $method = new \ReflectionMethod($this, $methodName);
                if ($method->isPublic() && $method->getName() === $methodName) {
                    return new InlineAction($id, $this, $methodName);
                }
            }
        }

        return null;
    }
}
