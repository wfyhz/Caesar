<div class="row">
	<div class="col-md-2">
		<ul id="main-nav" class="nav nav-tabs nav-stacked" style="">
			<li class="active">
				<a href="#">
					<i class="glyphicon glyphicon-th-large"></i>
					首页
				</a>
			</li>
			<li>
				<a href="#systemSetting" class="nav-header collapsed" data-toggle="collapse">
					<i class="glyphicon glyphicon-cog"></i>
					系统管理
					<span class="pull-right glyphicon glyphicon-chevron-down"></span>
				</a>
				<ul id="systemSetting" class="nav nav-list collapse secondmenu" >
					<li><a href=<?= url::to(['site/index'])?>><i class="glyphicon glyphicon-user"></i>用户管理</a></li>
					<li><a href="#"><i class="glyphicon glyphicon-th-list"></i>菜单管理</a></li>
					<li><a href="#"><i class="glyphicon glyphicon-asterisk"></i>角色管理</a></li>
					<li><a href="#"><i class="glyphicon glyphicon-edit"></i>修改密码</a></li>
					<li><a href="#"><i class="glyphicon glyphicon-eye-open"></i>日志查看</a></li>
				</ul>
			</li>
			<li>
				<a href="./plans.html">
					<i class="glyphicon glyphicon-credit-card"></i>
					物料管理
				</a>
			</li>

			<li>
				<a href="./grid.html">
					<i class="glyphicon glyphicon-globe"></i>
					分发配置
					<span class="label label-warning pull-right">5</span>
				</a>
			</li>

			<li>
				<a href="./charts.html">
					<i class="glyphicon glyphicon-calendar"></i>
					图表统计
				</a>
			</li>
			<li>
				<a href="#">
					<i class="glyphicon glyphicon-fire"></i>
					关于系统
				</a>
			</li>

		</ul>
	</div>
	<div class="col-md-10">
		<?=$content?>
	</div>