<?php
/* @var $this yii\web\View */
use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
LoginAsset::register($this);
$this->beginPage();
$this->title = 'Admin后台管理';
?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language?>">
<head>
	<meta charset="<?php echo Yii::$app->charset?>">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<?php echo Html::csrfMetaTags();?>
	<title><?php echo Html::encode($this->title)?></title>
	<?php $this->head()?>
</head>
<body class="login">
<?php $this->beginBody()?>
<div class="login-wrap">
	<div class="container login-container">
		<!--				<a href="#"><img width="100" height="30" src="images/logo-login@2x.png"></a>-->
		<h2><?= Html::encode($this->title) ?></h2>
		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<?= $form->field($model, 'username',['enableLabel'=>false,'options'=>['class'=>'col-sm-12']])
				->textInput(['placeholder'=>$model->getAttributeLabel('username')]);
			?>
		</div>
		<div class="row">
			<?= $form->field($model, 'password',['enableLabel'=>false,'options'=>['class'=>'col-sm-12']])
				->passwordInput(['placeholder'=>$model->getAttributeLabel('password')]) ?>
		</div>
		<div class="row">
			<?= $form->field($model, 'verifyCode',['enableLabel'=>false, 'options'=>['class'=>'col-sm-4 ']])
				->textInput(['placeholder'=>$model->getAttributeLabel('verifyCode')]) ?>
			<?= $form->field($model, 'verifyCode',['enableLabel'=>false, 'options'=>['class'=>'col-sm-5'],'enableError'=>false])
				->widget(Captcha::className(),[
					'template' => "{image}",
					'imageOptions' => ['alt' => '验证码'],

				])?>
		</div>
		<div class="row">
			<?= Html::submitButton('登录',['class'=>'btn btn-primary'])?>
		</div>
	</div>
</div>
<?php $this->endBody();?>
</body>
</html>
<?php $this->endPage();?>
