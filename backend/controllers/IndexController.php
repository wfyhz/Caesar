<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\LoginForm;
class IndexController extends BaseController
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
						'actions' => ['login', 'error', 'captcha'],
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
					'logout' => ['post'],
				],
			],
		];
	}
	public function actions()
	{
		return [
			'captcha'	=>[
				'class'		=>'yii\captcha\CaptchaAction',
				'maxLength'	=>5,
				'minLength'	=>5
			],
		];
	}
    public function actionIndex()
    {
        echo 'index';
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
			return $this->render('index', [
				'model' => $model,
			]);
		}
	}

}
