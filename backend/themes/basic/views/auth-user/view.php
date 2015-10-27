<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthUser */

$this->title = \Yii::t('admin','View');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('admin','Administrator List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-user-view">
    <p>
        <?php
        if($model->is_super !== \backend\models\AuthUser::IS_SUPER_YES)
        {
            echo Html::a(\Yii::t('admin','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo '&nbsp;';
            echo Html::a(\Yii::t('admin','Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_name',
            [
                'attribute' =>'status',
                'value' =>\backend\models\AuthUser::statusLabel($model->status)
            ]
        ],
    ]) ?>

</div>
