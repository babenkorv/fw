<?php

namespace application\models;

use vendor\components\Model;

class MyModel extends  Model
{
    public function tableName()
    {
        return 'data';
    }

    public function rule()
    {
        return [];
    }
    
}


