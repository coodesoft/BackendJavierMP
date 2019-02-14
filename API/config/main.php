<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [

    ],
    'components' => [
        'request' => [
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
              '<controller:\w+>/<id:\d+>' => '<controller>/view',
              '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
              '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'mail' => [
          'class' => 'yii\swiftmailer\Mailer',
          'viewPath' => '@backend/mail',
          'useFileTransport' => false,
          'transport' => [
              'class'      => 'Swift_SmtpTransport',
              'host'       => 'smtp.gmail.com',
              'username'   => 'luciano.n.vega@gmail.com',
              'password'   => 'asfasfwegvs',
              'port'       => '587',
              'encryption' => 'tls',
              'streamOptions' => [
                   'ssl' => [
                       'allow_self_signed' => true,
                       'verify_peer' => false,
                       'verify_peer_name' => false,
                   ],
              ],
          ],
        ],
    ],
    'params' => $params,
];
