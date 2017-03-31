<?php
/**
 * Created by PhpStorm.
 * User: rbabenko
 * Date: 01.02.2017
 * Time: 16:57
 */

namespace application\models;

use vendor\components\Model;

class User extends Model
{
    public $token = null;
    public $repeatPassword;

    public function tableName()
    {
        return 'user';
    }

    public function rule()
    {
        if(empty($this->customRule)) {
            return [
                [['email', 'password'], 'required'],
                ['email', 'email'],
            ];
        } else {
            return $this->customRule;
        }
    }
}