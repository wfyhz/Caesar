<?php

namespace backend\controllers;

use Yii;
use backend\models\AuthUser;
use yii\data\ActiveDataProvider;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Html;

/**
 * AuthUserController implements the CRUD actions for AuthUser model.
 */
class AuthUserController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthUser::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthUser();
		$model->is_super = AuthUser::IS_SUPER_NO;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AuthUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuthUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function actionTestValidate()
	{
		$model = new AuthUser();
		$model->load(Yii::$app->request->post());
		if (Yii::$app->request->isAjax){
			$result = [];
			if($model->load(Yii::$app->request->post()) && $model->save())
			{//成功
				$result = [
					'status'	=>true,
					'data'		=>[
						'msg'	=>'添加成功',
						'model'=>$model
					]
				];
			}
			else
			{
				$r_error = [];
				foreach($model->getErrors() as $attribute => $errors)
				{
					$r_error[Html::getInputId($model, $attribute)] = $errors;
				}

				$result = [
					'status'	=>false,
					'data'		=>[
						'msg'	=>'添加失败',
						'error'=>$r_error
					]
				];
			}
			Yii::$app->response->format = Response::FORMAT_JSON;
			return $result;
		}
	}
}
