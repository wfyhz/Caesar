<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
	'language'	=>'zh-CN',
    'modules' => [
        'gii'   =>[
            'class' =>'yii\gii\Module',
            'allowedIPs'=>['127.0.0.1','::1','10.101.26.*']
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'backend\models\Authuser',
            'enableAutoLogin' => true,
			'loginUrl'	=>['site/login']
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
		'i18n'	=>[
			'translations'	=>[
				'admin'	=>[
					'class'	=>'yii\i18n\PhpMessageSource',
					'basePath'	=>'@common/languages'
				]
			]
		],
		'authManager'	=>[
			'class' => 'yii\rbac\DbManager',
		]
    ],
    'params' => $params,
	'defaultRoute'	=>'index'
];
