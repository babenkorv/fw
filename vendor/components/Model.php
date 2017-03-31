<?php

namespace vendor\components;

use vendor\components\validate\Validator;
use vendor\db\DataBaseConnect;
use vendor\db\SqlBuilder;

abstract class Model extends SqlBuilder
{
    use Validator;

    public $notDefineAttribute = [];

    public $customRule = [];
    public $attribute = [];
    public $oldAttribute = [];
    
    abstract public function tableName();

    public function __construct()
    {
        parent::__construct(DataBaseConnect::instance(null)->getAdapter(), $this->tableName());

        $this->attribute = $this->getAttribute();
    }

    public function setCustomRule($rule = [])
    {
        $this->customRule = $rule;
    }
    
    private function getAttribute()
    {
        $attribute = [];
        foreach ($this->tableInfo as $field) {
            $attribute[$field['Field']] = [
                'type' => $field['Type'],
                'null' => $field['Null'],
                'auto_increment' => $field['Extra'],
                'value' => '',
            ];
        }

        return $attribute;
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->attribute)) {
            $this->attribute[$name]['value'] = $value;
        } else {
            throw new \Exception('Attribute with name: ' . '"' . $name . '"' . 'in table:' . ' "' . $this->tableName() . '"' . ' is not exist');
        }
    }

    public function __get($name)
    {


        if (array_key_exists($name, $this->attribute)) {
            return $this->attribute[$name]['value'];
        } else {
            throw new \Exception('Attribute with name: ' . '"' . $name . '"' . 'in table:' . ' "' . $this->tableName() . '"' . ' is not exist');
        }
    }

    public function save()
    {
        $this->clearSqlPart();
        $data = [];

        foreach ($this->attribute as $fieldName => $fieldValue) {
            if ($fieldValue['value'] != '') {
                $data[$fieldName] = $fieldValue['value'];
            }
        }

        if (!empty($data)) {

            if (empty($this->oldAttribute)) {
                $this->insert($data)->execute();
                $this->oldAttribute = $this->attribute;
                $this->oldAttribute['id']['value'] = $this->lastInsertId();
            } else {
                $count = 0;
                foreach ($this->oldAttribute as $fieldName => $fieldValue) {
                    $this->where($fieldName, '=', (!empty($fieldValue['value'])) ? '"' . $fieldValue['value'] . '"' : null, ($count === 0) ? '' : ' and');
                    $count++;
                }

                $this->update($data)->execute();
            }
        }
    }

    public function findOne()
    {
        $modelData = parent::findOne();
        if (!empty($modelData)) {
            foreach ($modelData as $key => $value) {
                $this->oldAttribute[$key]['value'] = $value;
                $this->attribute[$key]['value'] = $value;
            }
        }

        return false;
    }

    public function load()
    {
        if (empty($_GET) && empty($_POST)) {
            return false;
        } else {
            $attribute = [];
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $attribute = $_GET;
                    break;
                case 'POST':
                    $attribute = $_POST;
                    break;
            }

            $this->setAttribute($attribute);
            return true;
        }
    }

    public function setAttribute($attributes)
    {
        foreach ($attributes as $attributeName => $attributeValue) {
            if (key_exists($attributeName, $this->attribute)) {
                $this->{$attributeName} = $attributeValue;
            } else {
                if (property_exists($this, $attributeName)) {
                    $this->{$attributeName} = $attributeValue;
                } else {
                    $this->notDefineAttribute[$attributeName] = $attributeValue;
                }
            }
        }
    }
}

