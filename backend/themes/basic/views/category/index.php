<?php

/**
 * @link https://github.com/gilek/yii2-gtreetable
 * @copyright Copyright (c) 2015 Maciej Kłak
 * @license https://github.com/gilek/yii2-gtreetable/blob/master/LICENSE
 */

use gilek\gtreetable\Widget;
use gilek\gtreetable\assets\UrlAsset;
use gilek\gtreetable\assets\BrowserAsset;
use yii\jui\JuiAsset;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

UrlAsset::register($this);

if (isset($title)) {
    $this->title = $title;
}

if (!isset($routes)) {
    $routes = [];
}

$controller = (!isset($controller)) ? '' : $controller.'/';

$routes = array_merge([
    'nodeChildren' => $controller.'nodeChildren',
    'nodeCreate' => $controller.'nodeCreate',
    'nodeUpdate' => $controller.'nodeUpdate',
    'nodeDelete' => $controller.'nodeDelete',
],$routes);

$defaultOptions = [
    'source' => new JsExpression("function (id) {
        return {
            type: 'GET',
            url: URI('".Url::to([$routes['nodeChildren']])."').addSearch({'id':id}).toString(),
            dataType: 'json',
            error: function(XMLHttpRequest) {
                alert(XMLHttpRequest.status+': '+XMLHttpRequest.responseText);
            }
        }; 
    }"),
    'onSave' => new JsExpression("function (oNode) {
        return {
            type: 'POST',
            url: !oNode.isSaved() ? '".Url::to([$routes['nodeCreate']])."' : URI('".Url::to([$routes['nodeUpdate']])."').addSearch({'id':oNode.getId()}).toString(),
            data: {
                parent: oNode.getParent(),
                name: oNode.getName(),
                position: oNode.getInsertPosition(),
                related: oNode.getRelatedNodeId(),
                _csrf:'".Yii::$app->request->getCsrfToken()."'
            },
            dataType: 'json',
            error: function(XMLHttpRequest) {
                alert(XMLHttpRequest.status+': '+XMLHttpRequest.responseText);
            }
        };        
    }"),
    'onDelete' => new JsExpression("function(oNode) {
        return {
            type: 'POST',
            url: URI('".Url::to([$routes['nodeDelete']])."').addSearch({'id':oNode.getId()}).toString(),
            dataType: 'json',
            data:{
            _csrf:'".Yii::$app->request->getCsrfToken()."'
            },
            error: function(XMLHttpRequest) {
                alert(XMLHttpRequest.status+': '+XMLHttpRequest.responseText);
            }
        };        
    }"),
    'languages' =>new JsExpression("{
        'zh-CN':{
            'save':'保存',
            'cancel':'取消',
            'action':'操作',
            'actions':{
                createBefore: '之前创建',
                createAfter: '创建兄弟节点',
                createFirstChild: '创建第一个子节点',
                createLastChild: '创建子节点',
                update: '修改',
                delete: '删除'
            },
            messages: {
                onDelete: '你确定删除?',
                onNewRootNotAllowed: '不允许添加新的根节点.',
                onMoveInDescendant: '目标节点不能是后裔节点T.',
                onMoveAsRoot: '目标节点不能是根节点.'
            }
        },
    }"),
    'defaultActions'    =>new JsExpression("[
        {
            name: '\${createAfter}',
            event: function (oNode, oManager) {
                oNode.add('after', 'default');
            }
        },
        {
            name: '\${createLastChild}',
            event: function (oNode, oManager) {
                oNode.add('lastChild', 'default');
            }
        },
        {
            divider: true
        },
        {
            name: '\${update}',
            event: function (oNode, oManager) {
                oNode.makeEditable();
            }
        },
        {
            name: '\${delete}',
            event: function (oNode, oManager) {
                if (confirm(oManager.language.messages.onDelete)) {
                    oNode.remove();
                }
            }
        }
    ]"),

    'language' => Yii::$app->language,
];
$columnName = '分类';
$options = !isset($options) ? $defaultOptions : ArrayHelper::merge($defaultOptions, $options);
if (array_key_exists('draggable', $options) && $options['draggable'] === true) {
    BrowserAsset::register($this);
    JuiAsset::register($this);
}

$params = [];
$reflector = new ReflectionClass(Widget::className());
foreach($reflector->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
    $name = $property->name;

    if (isset(${$name})) {
        $params[$name] = ${$name};
    }
}
echo Widget::widget($params);
