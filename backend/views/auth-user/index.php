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
        <?php //Html::a('Create Auth User', ['create'], ['class' => 'btn btn-success','id'=>'modalButton','onclick'=>'authUser.add(this);return false']) ?>
    </p>
	<p>
		<?= Html::a(Yii::t('admin','Create'), ['create'], ['class' => 'btn btn-success','id'=>'modalButton']) ?>
	</p>

	<!--引入模态对话框 -->
	<?php
	\yii\bootstrap\Modal::begin([
		'header' => '<h2>'.Html::encode($this->title) .'</h2>',
		'id'=>'modal',
		'size'=>'modal-lg',
	]);
	echo '<div id="modalContent"> </div>';

	\yii\bootstrap\Modal::end()
	?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_name',
            'password',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
			/**
			[   'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {delete}',
				'headerOptions' => ['width' => '20%', 'class' => 'activity-view-link',],
				'contentOptions' => ['class' => 'padding-left-5px'],

				'buttons' => [
					'view' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
							'id' => 'activity-view-link',
							'title' => Yii::t('yii', 'View'),
							'data-toggle' => 'modal',
							'data-target' => '#activity-modal',
							'data-id' => $key,
							'data-pjax' => '0',

						]);
					},
				],


			],**/

		],
    ]); ?>

</div>
