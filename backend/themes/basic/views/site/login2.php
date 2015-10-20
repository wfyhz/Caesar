<?php
/* @var $this yii\web\View */
use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

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
<body>
<?php $this->beginBody()?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<h1 class="page-header">登录</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-3 col-md-2">
				用户名:
			</div>
			<div class="col-md-4"><input></div>
		</div>
	</div>
<?php $this->endBody();?>
</body>
</html>
<?php $this->endPage();?>
