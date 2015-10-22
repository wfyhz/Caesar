<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
	public $verifyCode;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
//			['verifyCode','required'],
//			['verifyCode','captcha'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if(!$user)
            {
                $this->addError('username',\Yii::t('admin', 'Incorrect username'));
                return;
            }
            if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, \Yii::t('admin','The password is incorrect'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = AuthUser::findByUsername($this->username);
        }

        return $this->_user;
    }

	/**
	 * 字段对应的名字
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'username'		=>\Yii::t('admin','User Name'),
			'password'		=>\Yii::t('admin','Password'),
			'rememberMe'	=>'自动登录',
			'verifyCode'	=>'验证码',
		];
	}
}
