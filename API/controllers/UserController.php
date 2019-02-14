<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\Users;

use backend\controllers\BaseController;

class UserController extends BaseController
{

    /**
     * @inheritdoc
     */
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
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }

    public function actionNew()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $salida = ['error' => '', 'result' => ['success' => false]];

      $post = file_get_contents("php://input");
      $data = json_decode($post);

      if($data == NULL){
        $salida['error'] = 'invalid input data';
        return $this->JSONOut($salida);
      }

      $userM = new Users;
      $userM->new($data);

      if($userM->errors == ''){
        $salida['result']['success'] = true;
      } else {
        $salida['error'] = $userM->errors;
      }

      return $this->JSONOut($salida);
    }

}
