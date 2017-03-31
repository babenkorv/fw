<?php

new \application\models\MyModel();
\vendor\components\AssetManager::register($this->viewUniqueName);
$paginator = new \vendor\widgets\Pagination(new \application\models\MyModel(), 6, 6);

echo new \vendor\widgets\GridView([
    'model' => $paginator->model(),
    'searchModel' => new \application\models\search\MyModelSearch(),
    'column' => [
        [
            'attribute' => 'name',
            'label' => 'asd',
            'filter' =>''
        ],
        [
            'attribute' => 'sex',
            'label' => 'gender',
        ],
        'dr'
    ],
    'paginationNavBar' => $paginator->navBar(),
]);
//
//$form = new \vendor\widgets\Form();
//
//$form->begin('my_form', '/my/index', 'get');
//
//$form->field('a')->defaultValue(5)->label('as')->textarea(10);
//
////$form->field('gender')->label('ss')->radio(['man' => 1, 'women' => 0], 'man');
//
//$form->field('zoo')->select(['1'=> 'tiger', '2'=> 'turtle']);
//$form->field('ss')->checkbox('one', 'one');
//
//$form->end();
?>
