<?php
namespace backend\assets;

use yii\web\AssetBundle;

class iActiveFormAsset extends AssetBundle
{
	//public $sourcePath = '@backend/web/';
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $js = [
		'js/iActiveForm.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
}