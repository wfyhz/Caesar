<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use backend\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
			// 'captcha'	=>[
			// 	'class'		=>'yii\captcha\CaptchaAction',
			// 	'maxLength'	=>5,
			// 	'minLength'	=>5
			// ],
            'upload' => [
                'class' => 'troy\ImageUpload\UploadAction',
                'successCallback' => [$this, 'successCallback'],
                'beforeStoreCallback' => [$this,'beforeStoreCallback']
            ],
        ];
    }

    public function actionIndex()
    {
        //$this->layout="main2";
        return $this->render('index');
    }

    public function actionLogin()
    {
		$this->layout = false;
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login2', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function successCallback($store,$file)
    {
    }
    public function beforeStoreCallback($file)
    {
    }
}
