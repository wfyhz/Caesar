<?php
namespace backend\assets;
use sansusan\easyui\EasyuiAsset;

class AdminAsset extends EasyuiAsset
{

	public $depends = [
		// 'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}