<?php
$this->params['breadcrumbs'] = [
    ['label'	=>'demo'],
    ['label'	=>'demo2']
];
?>
<div class="row">

    <ul id="accordion" class="panel-group">
        <li class="panel panel-default">
            <div class="panel-heading" id="headingOne">
                <a href="#systemSetting" class="collapsed" data-toggle="collapse" data-parent="#according">
                    <i class="glyphicon glyphicon-cog"></i>
                    系统管理
                    <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                </a>
            </div>
            <ul id="systemSetting" class="nav nav-list collapse sub-menu" aria-labelledby="headingOne">
                <li><a href="<?php echo \yii\helpers\Url::to(['auth-user/index'])?>"><i class="glyphicon glyphicon-user"></i>用户管理</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-th-list"></i>菜单管理</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-asterisk"></i>角色管理</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-edit"></i>修改密码</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-eye-open"></i>日志查看</a></li>
            </ul>
        </li>

        <li class="panel panel-default">
            <div class="panel-heading" id="headingTwo">
                <a href="#systemSetting2" class="collapsed" data-toggle="collapse" data-parent="#according">
                    <i class="glyphicon glyphicon-cog"></i>
                    系统管理
                    <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                </a>
            </div>
            <ul id="systemSetting2" class="nav nav-list collapse sub-menu" aria-labelledby="headingTwo">
                <li><a href="<?php echo \yii\helpers\Url::to(['auth-user/index'])?>"><i class="glyphicon glyphicon-user"></i>用户管理</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-th-list"></i>菜单管理2</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-asterisk"></i>角色管理2</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-edit"></i>修改密码2</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-eye-open"></i>日志查看2</a></li>
            </ul>
        </li>

    </ul>

    <?php
        $auth_menu = [
            'items' =>[
                [
                    'label' =>'用户列表',
                    'url'   =>['auth-user/index']
                ],
                [
                    'label' =>'添加用户',
                    'url'   =>['auth-user/create']
                ],
                [
                    'label' =>'角色',
                    'url'   =>'#'
                ]
            ]
        ];
        $sys_menu = [
            'items' =>[
                [
                    'label' =>'数据表',
                    'url'   =>'#'
                ],
                [
                    'label' =>'缓存',
                    'url'   =>'#'
                ]
            ]
        ];
        $menu = [
            'items' =>[
                [
                    'label' =>'首页',
                    'content'   =>''
                ],
                [
                    'label' =>'<i class="glyphicon glyphicon-cog"></i>权限管理<span class="pull-right glyphicon glyphicon-chevron-down"></span>',
                    'content'  =>\yii\widgets\Menu::widget($auth_menu)
                ],
                [
                    'label' =>'系统',
                    'content'   =>\yii\widgets\Menu::widget($sys_menu),
                ]
            ],
            'encodeLabels'  =>false
        ];
        //echo \yii\bootstrap\Collapse::widget($menu);
    ?>
    <!--
    <div class="menu panel-group collapse in" id="w0" aria-expanded="true" style="">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="<?php echo \yii\helpers\Url::to(['auth-user/index'])?>" class="collapse-toggle collapsed" aria-expanded="false">首页</a>
                </h4>
            </div>
            <div class="panel-collapse collapse" id="w0-collapse1" aria-expanded="false"><div class="panel-body"></div>
            </div></div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-parent="#w0" data-toggle="collapse" href="#w0-collapse2" class="collapse-toggle collapsed" aria-expanded="false"><i class="glyphicon glyphicon-cog"></i>权限管理<span class="pull-right glyphicon glyphicon-chevron-down"></span></a>
                </h4>
            </div>
            <div class="panel-collapse collapse" id="w0-collapse2" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <ul><li><a href="/index.php?r=auth-user%2Findex">用户列表</a></li>
                        <li><a href="/index.php?r=auth-user%2Fcreate">添加用户</a></li>
                        <li><a href="#">角色</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-parent="#w0" data-toggle="collapse" href="#w0-collapse3" class="collapse-toggle collapsed" aria-expanded="false">系统</a>
                </h4>
            </div>
            <div class="panel-collapse collapse" id="w0-collapse3" aria-expanded="false">
                <div class="panel-body">
                    <ul><li><a href="#">数据表</a></li>
                        <li><a href="#">缓存</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>-->



    <ul class="nav nav-tabs nav-stacked panel-group collapse in" id="w0" aria-expanded="true" style="">
        <li class="panel panel-default">

            <a data-parent="#w0" data-toggle="collapse" href="#w0-collapse2" class="collapse-toggle collapsed" aria-expanded="false"><i class="glyphicon glyphicon-cog"></i>权限管理<span class="pull-right glyphicon glyphicon-chevron-down"></span></a>
            <ul class="nav nav-list panel-collapse collapse" id="w0-collapse2" aria-expanded="false" style="height: 0px;">

                    <li><a href="/index.php?r=auth-user%2Findex">用户列表</a></li>
                        <li><a href="/index.php?r=auth-user%2Fcreate">添加用户</a></li>
                        <li><a href="#">角色</a></li>

            </ul>
        </li>
        <li class="panel panel-default">

            <a data-parent="#w0" data-toggle="collapse" href="#w0-collapse3" class="collapse-toggle collapsed" aria-expanded="false">系统</a>

            <ul class="nav nav-list panel-collapse collapse" id="w0-collapse3" aria-expanded="false">

                    <li><a href="#">数据表</a></li>
                        <li><a href="#">缓存</a></li>

            </ul>
        </li>
    </ul>


    <ul aria-expanded="true" class="nav nav-tabs nav-stacked panel-group collapse in" id="main-nav">
        <li class="panel panel-default"><a  href="/index.php?r=index%2Findex"><i class="glyphicon glyphicon-th-large"></i>首页</a></li>
        <li class="panel panel-default">
            <a aria-expanded="false" class="collapse-toggle collapsed" data-toggle="collapse" data-parent="#main-nav" href="#systemSetting1">
                <i class="glyphicon glyphicon-cog"></i> 系统管理<span class="pull-right glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul class="nav nav-list panel-collapse collapse" id="systemSetting1">
                <li><a  href="/index.php?r=auth-user%2Findex"><i class="glyphicon glyphicon-user"></i>用户管理</a></li>
                <li><a  href="/index.php?r=auth-user%2Fcreate"><i class="glyphicon glyphicon-th-list"></i>菜单管理</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-asterisk"></i>角色管理</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-edit"></i>修改密码</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-eye-open"></i>日志查看</a></li>
            </ul>
        </li>
        <li class="panel panel-default"><a aria-expanded="false" class="collapse-toggle collapsed" data-toggle="collapse" data-parent="#main-nav" href="#wuliaoSetting"><i class="glyphicon glyphicon-credit-card"></i> 物料管理<span class="pull-right glyphicon glyphicon-chevron-down"></span></a>
            <ul class="nav nav-list collapse sub-menu" id="wuliaoSetting">
                <li><a href="#"><i class="glyphicon glyphicon-user"></i>用户管理</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-th-list"></i>菜单管理</a></li>
                <li><a  href="#"><i class="glyphicon glyphicon-asterisk"></i>角色管理</a></li>
                <li><a  href="#"><i class="glyphicon glyphicon-edit"></i>修改密码</a></li>
                <li><a  href="#"><i class="glyphicon glyphicon-eye-open"></i>日志查看</a></li>
            </ul></li>
    </ul>

    <ul aria-expanded="true" class="nav nav-tabs nav-stacked panel-group collapse in" id="main-nav">
        <li class="panel panel-default"><a href="/index.php?r=index%2Findex"><i class="glyphicon glyphicon-th-large"></i>首页</a></li>
        <li class="panel panel-default">
            <a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#systemSetting1" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-cog"></i> 系统管理<span class="pull-right glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul class="nav nav-list panel-collapse collapse" id="systemSetting1">
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="/index.php?r=auth-user%2Findex" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-user"></i>用户管理</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="/index.php?r=auth-user%2Fcreate" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-th-list"></i>菜单管理</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-asterisk"></i>角色管理</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-edit"></i>修改密码</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-eye-open"></i>日志查看</a></li>
            </ul></li>
        <li class="panel panel-default"><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#wuliaoSetting" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-credit-card"></i> 物料管理<span class="pull-right glyphicon glyphicon-chevron-down"></span></a>
            <ul class="nav nav-list collapse sub-menu" id="wuliaoSetting">
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-user"></i>用户管理</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-th-list"></i>菜单管理</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-asterisk"></i>角色管理</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-edit"></i>修改密码</a></li>
                <li><a aria-expanded="false" data-parent="#main-nav" data-toggle="collapse" href="#" class="collapse-toggle collapsed"><i class="glyphicon glyphicon-eye-open"></i>日志查看</a></li>
            </ul></li>
    </ul>
</div>