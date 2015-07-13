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
						'actions' => ['login', 'error'],
						'allow' => true,
					],
					[
						'actions' => ['logout', 'index','add-rbac'],
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

    public function actionIndex()
    {
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
			return $this->render('index', [
				'model' => $model,
			]);
		}
	}

	/**
	 * 添加rbac数据
	 */
	public  function  actionAddRbac(){
		$auth = Yii::$app->authManager;

		//添加"创建文章"的权限
		$createPost = $auth->createPermission('createPost');
		$createPost->description = 'Create a post';
		$auth->add($createPost);

		//添加"更新文章"的权限
		$updatePost = $auth->createPermission('updatePost');
		$updatePost->description = 'Update post';
		$auth->add($updatePost);

		//创建一个"作者" 角色,并给他"创建文章"的权限
		$author = $auth->createRole('author');
		$auth->add($author);
		$auth->addChild($author, $createPost);

		//添加"admin"角色,给它"更新文章"的权限,"作者"角色
		$admin = $auth->createRole('admin');
		$auth->add($admin);
		$auth->addChild($admin, $updatePost);
		$auth->addChild($admin, $author);

		//给用户指定角色, 1和2 就是用户ID
		$auth->assign($author, 2);
		$auth->assign($admin, 1);


		$rule = new \backend\components\authorRule();
		$auth->add($rule);

		//添加"updateOwnPost"权限,并且和上面的规则关联起来
		$updateOwnPost = $auth->createPermission('updateOwnPost');
		$updateOwnPost->description = 'update own post';
		$updateOwnPost->ruleName = $rule->name;
		$auth->add($updateOwnPost);

		$auth->addChild($updateOwnPost, $updatePost);
		$auth->addChild($author, $updateOwnPost);
	}

}
