<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/13
 * Time: 16:57
 */
namespace backend\components;
use yii;
use yii\rbac\Rule;
class authorRule extends Rule
{

	public $name = 'isAuthor';
	public function  execute($user, $item, $params)
	{
		return isset($params['post']) ? $params['post']->createdBy == $user : false;
	}
}