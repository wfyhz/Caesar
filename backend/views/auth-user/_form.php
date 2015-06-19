<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-user-form">
    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>

    <?= $form->field($model, 'user_name',['labelOptions'=>
		['class'=>'col-sm-2  control-label'],
		'template'	=>"{label}\n<div class='col-sm-10'>\n{input}\n</div>\n{hint}\n{error}"
	])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
