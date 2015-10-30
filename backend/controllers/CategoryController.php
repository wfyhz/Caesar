<?php

namespace backend\controllers;
use backend\Models\Category;


class CategoryController extends BaseController
{
    public function actions()
    {
        return [
            'nodeChildren' => [
                'class' => 'gilek\gtreetable\actions\NodeChildrenAction',
                'treeModelName' => Category::className()
            ],
            'nodeCreate' => [
                'class' => 'gilek\gtreetable\actions\NodeCreateAction',
                'treeModelName' => Category::className()
            ],
            'nodeUpdate' => [
                'class' => 'gilek\gtreetable\actions\NodeUpdateAction',
                'treeModelName' => Category::className()
            ],
            'nodeDelete' => [
                'class' => 'gilek\gtreetable\actions\NodeDeleteAction',
                'treeModelName' => Category::className()
            ],
            'nodeMove' => [
                'class' => 'gilek\gtreetable\actions\NodeMoveAction',
                'treeModelName' => Category::className()
            ],
        ];
    }
    public function actionIndex()
    {

        return $this->render('index', ['options'=>[
            // 'manyroots' => true
            // 'draggable' => true
        ]]);
    }

}
