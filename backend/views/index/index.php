<?php
/* @var $this yii\web\View */
use backend\assets\LoginAsset;
use yii\helpers\Html;
LoginAsset::register($this);
$this->beginPage();
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
				<a href="#"><img width="100" height="30" src="images/logo-login@2x.png"></a>
				<form action="#" method="post">
					<div class="form-group">
						<input class="form-control" type="text" placeholder="用户名">
					</div>
					<div class="form-group">
						<input class="form-control" type="password" placeholder="密码">
					</div>
				</form>
			</div>
		</div>
	<?php $this->endBody();?>
</body>
</html>
<?php $this->endPage();?>
