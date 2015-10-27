<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AuthUser */

$this->title = \Yii::t('admin','Add Auth User');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('admin','Administrator List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
