<?php
use backend\components\iMenu;
echo iMenu::widget([
			'items' => [
          // Important: you need to specify url as 'controller/action',
         // not just as 'controller' even if default action is used.
          ['label' => 'Home', 'url' => ['site/index']],
          // 'Products' menu item will be selected as long as the route is 'product/index'
          ['label' => 'Products', 'url' => ['product/index'], 'items' => [
              ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
              ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
          ]],
          ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
      ],
  ]);