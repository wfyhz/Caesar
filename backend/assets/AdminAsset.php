<?php
namespace backend\assets;
use sansusan\easyui\EasyuiAsset;

class AdminAsset extends EasyuiAsset
{
	public static $locale = 'easyui-lang-zh_CN';
	public static $theme = 'bootstrap';
	public $depends = [
		// 'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
	];
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/login.css',
	];

	protected function applyTheme()
	{
		if (!empty(self::$theme) && is_string(self::$theme))
			$theme = self::$theme;
		else
			$theme = 'default';
		array_unshift($this->css, strtr('themes/{theme}/easyui.css', ['{theme}' => $theme]));
	}

	protected function applyLocale()
	{
		if (!empty(self::$locale) && is_string(self::$locale))
			$locale = self::$locale;
		else
			$locale = 'easyui-lang-ru';
		array_push($this->js, strtr('locale/{locale}.js', ['{locale}' => $locale]));
	}
}