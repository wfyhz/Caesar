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
<body>
	<?php $this->beginBody()?>
	<div class="container">
		<div id="login" class="easyui-panel" title="后台登录" data-options="iconCls:'icon-application'">
			<form id="fmLogin" method="post" novalidate>
				<div style="margin-bottom:10px">
					<input class="easyui-textbox" name="name"  style="width:100%;height:40px;padding:12px" data-options="prompt:'用户名',iconCls:'icon-man',iconWidth:38,validType:'length[5,15]',delay:'1000',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" type="password" name="pwd" id="pwd" style="width:100%;height:40px;padding:12px" data-options="prompt:'密码',iconCls:'icon-lock',iconWidth:38,validType:'length[5,20]',delay:'1000',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="verify" style="width:100%;height:40px;padding:12px" data-options="prompt:'验证码',iconCls:'icon-cup',iconWidth:38,required:true,validType:'longness[4]'">
				</div>
				<div style="margin-bottom:20px">
					<img id="verifyImg1" src="{:U('Login/verify')}" align="absbottom" onClick="fleshVerify()" style="cursor:pointer;"/>
				</div>
				<div>
					<a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" style="padding:5px 0px;width:100%;" onclick="doLogin()">
						<span style="font-size:14px;">登录</span>
					</a>
				</div>
			</form>
		</div>
	</div>
	<?php $this->endBody();?>
</body>
</html>
<?php $this->endPage();?>
