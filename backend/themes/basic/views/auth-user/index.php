<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Administrator List');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="auth-user-index">

	<p>
		<?= Html::a(Yii::t('admin','Add'), ['create'], ['class' => 'btn btn-success']) ?>
	</p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'user_name',
            [
				'attribute'=>'status',
				'value'	=>function($model,$key,$index, $column){
					return \backend\models\AuthUser::statusLabel($model->status);
				}
			],

//            ['class' => 'yii\grid\ActionColumn'],

			[   'class' => 'yii\grid\ActionColumn',
				//'template' => '{view} {delete}',
				'headerOptions' => ['width' => '20%', 'class' => 'activity-view-link',],
				'contentOptions' => ['class' => 'padding-left-5px'],

				'buttons' => [
					'update'	=>function($url, $model, $key){
						return $model->is_super == \backend\models\AuthUser::IS_SUPER_YES ? '' :Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,[
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
						]);
					},
                    'delete'    =>function($url,$model, $key){
                        return $model->is_super == \backend\models\AuthUser::IS_SUPER_YES ? '' :Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,[
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    }
				],


			],

		],
    ]); ?>

</div>
