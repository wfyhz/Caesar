<?php
/* @var $this yii\web\View */
use backend\assets\AdminAsset;
use yii\helpers\Html;
AdminAsset::register($this);
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
			<div class="login-container">

			</div>
		</div>
	<?php $this->endBody();?>
</body>
</html>
<?php $this->endPage();?>
