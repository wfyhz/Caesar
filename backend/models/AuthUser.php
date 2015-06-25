<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%auth_user}}".
 *
 * @property integer $id
 * @property string $user_name
 * @property string $password
 * @property integer $status
 */
class AuthUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DEL = -1;  //删除
    const STATUS_NORMAL = 1;    //正常
	const IS_SUPER_NO = 0;	//非超级管理员
	const IS_SUPER_YES = 1;	//超级管理员

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name','password'], 'required'],
			[['user_name'],'unique'],
            [['status','is_super'], 'integer'],
            [['user_name'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => '用户名',
            'password' => '密码',
            'status' => '状态',
			'is_super'=>'超级管理员'
        ];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['user_name' => $username, 'status' => self::STATUS_NORMAL]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return md5($password) === $this->password;
//        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_NORMAL]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public  function getUserName()
    {
        return $this->user_name;
    }

	/**
	 * 状态
	 * @param null $key
	 * @return mixed
	 */
	public static function statusLabel($key=null)
	{
		static $status = [
			self::STATUS_NORMAL	=>'正常',
			self::STATUS_DEL	=>'删除',

		];

		if($key !== null && isset($status[$key]))
		{
			return $status[$key];
		}

		return $status;
	}

	/**
	 * 是否超级管理员
	 * @param null $key
	 * @return mixed
	 */
	public static function superLabel($key=null)
	{
		static $super = [
			self::IS_SUPER_NO	=>'否',
			self::IS_SUPER_YES	=>'是',
		];
		if($key !== null && isset($super[$key]))
		{
			return $super[$key];
		}

		return $super;
	}

	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert))
		{
			$this->password = md5($this->password);
			return true;
		}
		return false;
	}
}
