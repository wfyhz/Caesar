<?php
$this->params['breadcrumbs'] = [
	['label'	=>'demo'],
	['label'	=>'demo2']
];
?>
	<a id="imageUpload" href="javascript:;">上传图片</a>
<?= \troy\ImageUpload\ImageUpload::widget(
	[
		'targetId' => 'imageUpload',//html dom id
		'config' =>[
			'action' =>Yii::$app->getUrlManager()->createUrl(['site/index'])
		]
	]
); ?>