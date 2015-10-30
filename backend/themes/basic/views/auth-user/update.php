<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthUser */

$this->title = \Yii::t('admin','Change');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('admin','Administrator List'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
