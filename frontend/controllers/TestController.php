<?php

namespace frontend\controllers;
use yii\web\Controller;
use Yii;
class TestController extends Controller
{

    public function actionIndex()
    {

		$length = 10;
		$num = 3;
		$red = $this->factor($length)/($this->factor($num)*$this->factor($length-$num));
		$blue = 16;
		echo $red;
		echo '<br/>';
		$red_list = $this->redList();
		$result = array();
		foreach($red_list as $v)
		{
			sort($v);
			$result[implode(',',$v)] = '';
		}
		var_dump(count($result));
		exit;
        return $this->render('site/index');
    }

	/**
	 * 阶乘
	 * @param $n
	 * @return int
	 */
	protected function factor($n)
	{
		if($n == 0 || $n == 1)
		{
			return 1;
		}

		return ($n--)*$this->factor($n);
	}

	protected function redList()
	{
		$max =10;
		$arr = range(1,3);
		$arr_max_index = 2;
		$result = array();
		for($i=$arr_max_index; $i>=0; $i--)
		{
			$temp = array_slice($arr, 0, $i+1);
			var_dump($temp);
			for($j=$arr[$i]+1; $j<=$max; $j++)
			{
				if(in_array($j, $arr))
					continue;

				$temp[$i] = $j;
				$result[] = $temp;
			}
		}
		return $result;

	}

	/**
	 * @param $start
	 * @param int $cycles 循环次数
	 * @param int $max 最大值
	 * @return array
	 */
	protected function _test($start, $cycles, $max=33)
	{
		if($cycles == 0 || $cycles == 1)
		{
			return range($start, $max);
		}

		$t = $this->_test($start-1,0);



	}

	public  function actionTest()
	{
		$token = '24abtWW9N6UN6DlaQ8tKoXsyeDBVHsyxqanmWdhMzA';
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
			case 'licai.lcbuy':	//余额购买理财
				$p = $this->_lcbuy();
				break;
			case 'sms.withdrawSmsCode':	//提现验证码
				$p = $this->_withdraw_sms_code();
				break;
			case 'index.bankTip':	//银行维护信息
				$p = array();
				break;
			case 'Pay.bankList':	//银行列表
				$p =array();
				break;
			case 'FixCard.getBank';	//大额行号
				$p = $this->_get_bank();
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
		//var_dump(curl_getinfo($ch));
		curl_close ( $ch );


		echo $return;
	}

	/**
	 * d登录
	 */
	private function _login()
	{
		$data = array(
			'mobile'	=>'15010116691',
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

			'amount'		=>'10000.0',
			'idCarkNumber'=>'411123198801012546',
			'bankId'	=>1,
			'bankName'	=>'招商银行',
			'cardNumber'=>'6228480018456929571',	//6225881014307465
			//'cardNumber'=>'622848126165749219',	//农行
			//'cardNumber'=>'6225881014307465',	//招行
			//'cardNumber'=>'6212261711000238478',	//工行
			//'cardNumber'=>'6227000014150407041',//建行
			'cardNumber'=>'6217000010026994767',
			'name'		=>'苏兴',
			'pid'	=>'359',
			'fCode'	=>'asdf',
			'buyAmount'	=>'1000',
			'pidType'	=>'3'
		);
		return $data;
	}

	/**
	 * 购买理财产品获取余额和订单等信息
	 */
	private  function _lc_before_buy()
	{
		$data = array(
			'pid'	=>'360',
			'amount'	=>'100.00',
			//'inviteCode'=>'asdfo'
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
			'sign'=>'{"sign":"072a2bf4f4bfd56d8a24d825b89cc4e1","oid_paybill":"2015060575007707","ret_code":"0000","result_pay":"SUCCESS","no_order":"6712015060520373510249989","oid_partner":"201408071000001543","agreementno":"2015060579670694","sign_type":"MD5","ret_msg":"交易成功!","dt_order":"20150605203739","money_order":"0.01","settle_date":"20150605","info_order":""}'
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

	private function _lcbuy()
	{
		$data = array(
			'pid'	=>'359',
			'money'=>'10000000'
		);
		return $data;
	}

	private function _withdraw_sms_code()
	{
		$data = array();
		return $data;
	}

	private function _get_bank()
	{
		$data = array(
			'card_no'	=>'6212260200059789319',	//银行卡号
			'bank_code'=>'9',	//银行编码
			'city_code'=>'350300',	//市编码
			'key'		=>'银行',	//支行关键字
		);
		return $data;
	}

}
