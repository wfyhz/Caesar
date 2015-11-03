<?php
use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
	<?php
	NavBar::begin([
		'brandLabel' => 'My Company',
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	]);
	$menuItems = [
		['label' => 'Home', 'url' => ['/site/index']],
	];
	if (Yii::$app->user->isGuest) {
		$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
	} else {
		$menuItems[] = [
			'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
			'url' => ['/site/logout'],
			'linkOptions' => ['data-method' => 'post']
		];
	}
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => $menuItems,
	]);
	NavBar::end();



	$menus = [
		'items'	=>[
			[
				'label'=>'<i class="glyphicon glyphicon-th-large"></i>首页',
				'url'	=>['index/index']
			],
			[
				'label'=>'<i class="glyphicon glyphicon-cog"></i> 系统管理<span class="pull-right glyphicon glyphicon-chevron-down"></span>',
				'url'	=>'#systemSetting1',
				'items'=>[
					[
						'label'	=>'<i class="glyphicon glyphicon-user"></i>用户管理',
						'url'		=>['auth-user/index'],
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-th-list"></i>菜单管理',
						'url'		=>['auth-user/create']
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-asterisk"></i>商品分类',
						'url'		=>['category/index'],
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-edit"></i>图片上传',
						'url'		=>['site/index'],
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-eye-open"></i>日志查看',
						'url'		=>'#'
					]
				],

				'linkOptions'	=>['class'=>'collapse-toggle collapsed','data-toggle'=>'collapse','data-parent'=>'#main-nav','aria-expanded'=>"false"],
				'submenuOptions'	=>['class'=>'nav nav-list panel-collapse collapse','id'=>'systemSetting1']
			],
			[
				'label'	=>'<i class="glyphicon glyphicon-credit-card"></i> 物料管理<span class="pull-right glyphicon glyphicon-chevron-down"></span>',
				'url'		=>'#wuliaoSetting',
				'items'=>[
					[
						'label'	=>'<i class="glyphicon glyphicon-user"></i>用户管理',
						'url'		=>'#',
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-th-list"></i>菜单管理',
						'url'		=>'#'
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-asterisk"></i>角色管理',
						'url'		=>'#',
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-edit"></i>修改密码',
						'url'		=>'#',
					],
					[
						'label'	=>'<i class="glyphicon glyphicon-eye-open"></i>日志查看',
						'url'		=>'#'
					]
				],
				'linkOptions'	=>['class'=>'collapse-toggle collapsed','data-toggle'=>'collapse','data-parent'=>'#main-nav','aria-expanded'=>"false"],
				'submenuOptions'	=>['class'=>'nav nav-list collapse sub-menu','id'=>'wuliaoSetting']
			],

		],
		'encodeLabels'	=>false,
		'options'			=>[
			'id'	=>'main-nav',
			'class'=>'nav nav-tabs nav-stacked panel-group collapse in',
			'aria-expanded'=>'true'
		],
		'linkTemplate'	=>'<a href="{url}" target="contents">{label}</a>',
		'itemOptions'	=>['class'=>'panel panel-default'],
	];
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 leftMenu">
				<?php
					echo \backend\components\iMenu2::widget($menus);
				?>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 rightContent">
				<!-- 16:9 aspect ratio -->
				<div class="embed-responsive embed-responsive-16by9">
					<iframe name="contents" class="embed-responsive-item" src="<?php echo Url::to(['index/index'])?>"></iframe>
				</div>
			</div>
		</div>
	</div>
</div>


<!--<footer class="footer">-->
<!--	<div class="container">-->
<!--		<p class="pull-left">&copy; My Company --><?//= date('Y') ?><!--</p>-->
<!--		<p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
<!--	</div>-->
<!--</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
