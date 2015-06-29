<?php
namespace backend\components;

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\base\InvalidCallException;
use yii\helpers\Html;

use backend\assets\iActiveFormAsset;
class iActiveForm extends ActiveForm
{

	private $_fields = [];
	//是否启用ajax提交
	public $enableAjaxSubmit=false;
	//ajax提交时的url
	public $ajaxSubmitUrl=null;
	/**
	 * Runs the widget.
	 * This registers the necessary javascript code and renders the form close tag.
	 * @throws InvalidCallException if `beginField()` and `endField()` calls are not matching
	 */
	public function run()
	{
		if (!empty($this->_fields)) {
			throw new InvalidCallException('Each beginField() should have a matching endField() call.');
		}

		if ($this->enableClientScript) {
			$id = $this->options['id'];
			$options = Json::htmlEncode($this->getClientOptions());
			$attributes = Json::htmlEncode($this->attributes);
			$view = $this->getView();
			iActiveFormAsset::register($view);
			$view->registerJs("jQuery('#$id').iActiveForm($attributes, $options);");
		}

		echo Html::endForm();
	}

	/**
	 * Returns the options for the form JS widget.
	 * @return array the options
	 */
	protected function getClientOptions()
	{
		$options = [
			'encodeErrorSummary' => $this->encodeErrorSummary,
			'errorSummary' => '.' . implode('.', preg_split('/\s+/', $this->errorSummaryCssClass, -1, PREG_SPLIT_NO_EMPTY)),
			'validateOnSubmit' => $this->validateOnSubmit,
			'errorCssClass' => $this->errorCssClass,
			'successCssClass' => $this->successCssClass,
			'validatingCssClass' => $this->validatingCssClass,
			'ajaxParam' => $this->ajaxParam,
			'ajaxDataType' => $this->ajaxDataType,
			'enableAjaxSubmit'=>$this->enableAjaxSubmit
		];
		if ($this->validationUrl !== null) {
			$options['validationUrl'] = Url::to($this->validationUrl);
		}

		if($this->ajaxSubmitUrl !== null)
		{
			$options['ajaxSubmitUrl'] =Url::to($this->ajaxSubmitUrl);
		}

		// only get the options that are different from the default ones (set in yii.activeForm.js)
		return array_diff_assoc($options, [
			'encodeErrorSummary' => true,
			'errorSummary' => '.error-summary',
			'validateOnSubmit' => true,
			'errorCssClass' => 'has-error',
			'successCssClass' => 'has-success',
			'validatingCssClass' => 'validating',
			'ajaxParam' => 'ajax',
			'ajaxDataType' => 'json',
		]);
	}
}