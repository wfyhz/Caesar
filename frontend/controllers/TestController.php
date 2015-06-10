<?php

namespace frontend\controllers;
use yii\web\Controller;
use Yii;
class TestController extends Controller
{

    public function actionIndex()
    {
		echo date("m月d日",strtotime('+2 day'));exit;
        return $this->render('site/index');
    }

	public  function actionTest()
	{
		$token = 'e220IMWuqCKPoihLrTVq9hUp0pW1l5VMPENKAXb2eA';
		$params = Yii::$app->getRequest()->getQueryParams();
		$method = $params['method'];
		$data = array(
			'v'			=>'1.0',
			'token'	=>$token,
			'method'	=>$method
		);
		switch($method)
		{
			case 'index.login':	//登录
				$p = $this->_login();
				break;
			case 'order.noCardOrder':	//回传银行卡，身份证信息
				$p = $this->_no_card_order();
				break;
			case 'licai.beforeBuy':	//购买理财产品获取余额和订单等信息
				$p = $this->_lc_before_buy();
				break;
			case 'user.mixedInfo':	//充值提现获取用户信息-前置
				$p = $this->_user_mixed_info();
				break;
			case 'order.bindCardOrder':	//获取充值订单号 已绑卡
				$p = $this->_bind_card_order();
				break;
			case 'pz.beforePz':	//购买配资产品获取余额和订单等信息
				$p = $this->_before_pz();
				break;
			case 'pz.beforePzExpand':	//配资展期获取余额和订单等信息
				$p = $this->_before_pz_expand();
				break;
			case 'pz.beforePzFill':	//配资追加保证金获取余额和订单等信息
				$p = $this->_before_pz_fill();
				break;
			case 'Pay.payment':	//支付
				$p = $this->_recharge();
				break;
			case 'Pay.withdraw':	//支付
				$p = $this->_withdraw();
				break;
			default:
				echo '参数错误';
				exit();
		}

		$data = array_merge($data, $p);

		$ch = curl_init ();

		curl_setopt ( $ch, CURLOPT_URL, 'http://mapi.qianyilc.com' );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$return = curl_exec ( $ch );
		curl_close ( $ch );

		echo $return;
	}

	/**
	 * d登录
	 */
	private function _login()
	{
		$data = array(
			'mobile'	=>'15210513963',
			'authcode'=>'1001',
			'plat'		=>'1',
			'imei'		=>'asdf'
		);
		return $data;
	}

	/**
	 * 回传银行卡，身份证信息
	 */
	private function _no_card_order()
	{
		$data = array(

			'amount'		=>10000.0,
			'idCarkNumber'=>'1234123',
			'bankId'	=>0,
			'bankName'	=>0,
			'cardNumber'=>'6225880128217123',
			'name'		=>'asdf'
		);
		return $data;
	}

	/**
	 * 购买理财产品获取余额和订单等信息
	 */
	private  function _lc_before_buy()
	{
		$data = array(
			'pid'	=>'333',
			'amount'	=>'100.00'
		);
		return $data;
	}

	/**
	 * 充值提现获取用户信息-前置
	 */
	private  function _user_mixed_info()
	{
		$data = array(
			'type'	=>'2',	//1充值,2提现
		);
		return $data;
	}

	/**
	 *获取充值订单号 已绑卡
	 */
	private function _bind_card_order()
	{
		$data = array(
			'amount'	=>'300'
		);
		return $data;
	}

	/**
	 *购买配资产品获取余额和订单等信息
	 */
	private function _before_pz()
	{
		$data = array(
			'principal'	=>'45000',
//			'principal'	=>'45000',
			'multiple'		=>'2',
			'type'			=>'2',
			'time'			=>'6'
		);
		return $data;
	}

	/**
	 * 配资展期获取余额和订单等信息
	 */
	private function _before_pz_expand()
	{
		$data = array(
			'pid'	=>'1',
			'time'	=>'123'
		);

		return $data;
	}

	/**
	 * 配资追加保证金获取余额和订单等信息
	 */
	private  function _before_pz_fill()
	{
		$data = array(
			'pid'	=>'1',
			'amount'	=>'1',
		);

		return $data;
	}

	private function _recharge()
	{
		$data = array(
			'sign'=>'{"oid_paybill":"2015061077246409","ret_code":"0000","settle_date":"20150610","money_order":"0.01","result_pay":"SUCCESS","dt_order":"20150610155645","info_order":"20150610155645","no_order":"6932015061015564499995253","agreementno":"2015060881003485","oid_partner":"201408071000001543","ret_msg":"交易成功","sign":"d5b3a693a57de96e0e56e50f293c0404","sign_type":"MD5"}'
		);
		return $data;
	}
	private function _withdraw()
	{
		$data = array(
			'amount'	=>123,
			'authcode'=>'234945'
		);
		return $data;
	}
}
