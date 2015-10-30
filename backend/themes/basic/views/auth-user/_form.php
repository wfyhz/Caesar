<?php

use yii\helpers\Html;
use backend\components\iActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthUser */
/* @var $form yii\widgets\ActiveForm */
$field_options = ['labelOptions'=>
	['class'=>'col-md-2 col-sm-2  control-label'],
	'template'	=>"{label}\n<div class='col-md-5 col-sm-5'>\n{input}\n</div>\n<div class='col-md-3 col-sm-3'>\n{error}\n</div>",

];
?>

<div class="auth-user-form">
    <?php
	$form_param = [
		'options'	=>['class'=>'form-horizontal'],
		//'action'	=>['auth-user/create'],
		'successCssClass'=>'',
		//'enableAjaxValidation'	=>true,
		//'validationUrl'	=>['auth-user/test-validate'],
		//'enableAjaxSubmit'=>true,
		//'ajaxSubmitUrl'	=>['auth-user/test-validate']
	];
	$form = iActiveForm::begin($form_param);
	?>

    <?php
		if($model->isNewRecord)
		{
			$textConfig = [
				'maxLength'	=>true,
			];
		}
		else
		{
			$textConfig = [
				'maxLength'	=>true,
				'disabled'	=>true,
			];
		}
		echo $form->field($model, 'user_name',$field_options)->textInput($textConfig);
	?>

    <?php
	if($model->isNewRecord)
		echo $form->field($model, 'password',$field_options)->passwordInput(['maxlength' => true]);
	?>

    <?= $form->field($model, 'status',$field_options)->dropDownList(\backend\models\AuthUser::statusLabel()) ?>
	<?= $form->field($model, 'is_super', $field_options)->radioList(\backend\models\AuthUser::superLabel()) ?>

    <div class="form-group">
        <div class="col-md-offset-3 col-sm-offset-3 col-md-8 col-sm-8">
			<?= Html::submitButton($model->isNewRecord ? \Yii::t('admin','Add') : \Yii::t('admin','Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?php iActiveForm::end(); ?>

</div>
