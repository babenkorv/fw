<?php

namespace vendor\components\validate;


trait Validator
{
    /**
     * @var array contain validate rules.
     */
    private $rules = [];

    /**
     * @var array contain all errors.
     */
    private $error = [];

    /**
     * @var array contain all exist attribute.
     */
    private $existAttribute = [];

    /**
     * Must return array with field name and validate_name.
     *
     * @return mixed
     */
    abstract public function rule();

    /**
     * Run all model validate method. Return true if validate success, else return false.
     *
     * @return bool
     * @throws \Exception
     */
    public function validate()
    {

        $this->existAttribute = [];
        $this->rules = $this->rule();

        foreach ($this->rules as $rule) {
            $param = [];
            $fields = $rule[0];
            $validator = 'validate' . ucfirst($rule[1]);

            if (!empty($rule['param'])) {
                $param = $rule['param'];
            }
            if (is_array($fields)) {
                foreach ($fields as $field) {
                    if (method_exists($this, $validator)) {
                        if ($this->checkExistAttribute($field)) {
                            $this->$validator($field, $param);
                        }
                    } else {
                        throw new \Exception('Validator with name :' . $validator . 'is not exist');
                    }
                }
            } else {

                if (method_exists($this, $validator)) {

                    if ($this->checkExistAttribute($fields)) {

                        $this->$validator($fields, $param);
                    }
                } else {
                    throw new \Exception('Validator with name :' . $validator . 'is not exist');
                }
            }
        }

        if (empty($this->error)) {
            return true;
        }

        return false;
    }

    /**
     * Check on exist @param string $attribute on modal attribute.
     *
     * @param string $attribute filed name.
     * @return bool
     * @throws \Exception
     */
    public function checkExistAttribute($attribute)
    {

        if (empty($this->existAttribute)) {
            foreach ($this->attribute as $key => $value) {
                $this->existAttribute[] = $key;
            }
        }
        if (in_array(trim($attribute), $this->existAttribute)) {
            return true;
        } else {
            if (property_exists($this, $attribute)) {
                $this->existAttribute[] = $attribute;
                return true;
            } else {
                throw new \Exception('Attribute with name :' . $attribute . ' is not exist');
            }
        }
    }

    /**
     * Return array with error.
     *
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * Add error to error Array/
     *
     * @param string $field field name.
     * @param $errorDescription
     */
    public function addError($field, $errorDescription)
    {
        if (!empty($this->error[$field])) {
            array_push($this->error[$field], $errorDescription);
        } else {
            $this->error[$field] = [$errorDescription];
        }
    }

    /**
     * Check on not empty field.
     *
     * For example:
     *      [['field_1', 'field_2'], 'required'],
     *
     * @param string $field field name
     * @return bool
     */
    public function validateRequired($field)
    {
        if($this->{$field} != '') {
            return true;
        }
        
        $this->addError($field, 'Field is required');
    }

    /**
     * Check on equal input field with input any field or value.
     * For example:
     *
     *      ['field name', 'equal', 'param' => [
     *          'value' => 'your value',
     *          'field' => 'other field',
     *      ]],
     *
     * @param string $field field name
     * @param array $param
     */
    public function validateEqual($field, $param)
    {
        if (!empty($param['field']) ? $this->checkExistAttribute($param['field']) : true) {
            if (!empty($param['value'])) {
                if ($param['value'] !== $this->{$field}) {
                    $this->addError($field, 'Field is not equal ' . $param['value']);
                }
            }

            if (!empty($param['field'])) {
                if ($this->{$param['field']} !== $this->{$field}) {
                    $this->addError($field, 'Field with name ' . $field . ' is not equal ' . $param['field']);
                }
            }
        }
    }

    /**
     * Check on different input field with input any field or value.
     * For example:
     *
     *      ['field name', 'equal', 'param' => [
     *          'value' => 'your value',
     *          'field' => 'other field',
     *      ]],
     *
     * @param string $field field name
     * @param array $param
     */
    public function validateDifferent($field, $param)
    {
        if (!empty($param['field']) ? $this->checkExistAttribute($param['field']) : true) {
            if (!empty($param['value'])) {
                if ($param['value'] === $this->{$field}) {
                    $this->addError($field, 'Field is not different ' . $param['value']);
                }
            }

            if (!empty($param['field'])) {
                if ($this->{$param['field']} === $this->{$field}) {
                    $this->addError($field, 'Field with name ' . $field . ' is not different ' . $param['field']);
                }
            }
        }
    }

    /**
     * Checkbox or Radio must be accepted (yes, on, 1, true)
     *
     * For example:
     *      [['field_1', 'field_2'], 'accepted'],
     *
     * @param string $field field name
     * @return bool
     */
    public function validateAccepted($field)
    {
        $acceptedValue = [true, 1, '1', 'yes', 'on'];

        if (in_array($this->{$field}, $acceptedValue)) {
            return true;
        }

        $this->addError($field, 'Field with name ' . $field . ' is not accepted');
    }

    /**
     * Check filed is numeric.
     *
     * For example:
     *      [['field_1', 'field_2'], 'numeric'],
     *
     * @param string $field field name.
     */
    public function validateNumeric($field)
    {
        if (!is_numeric($this->{$field})) {
            $this->addError($field, 'Field with name ' . $field . ' is not numeric');
        }
    }

    /**
     * Check filed is integer.
     *
     * For example:
     *      [['field_1', 'field_2'], 'integer'],
     *
     * @param string $field field name.
     */
    public function validateInteger($field)
    {
        if (!is_integer($this->{$field})) {
            $this->addError($field, 'Field with name ' . $field . ' is not numeric');
        }
    }

    /**
     * Check filed is boolean.
     *
     * For example:
     *      [['field_1', 'field_2'], 'boolean'],
     *
     * @param string $field field name.
     */
    public function validateBoolean($field)
    {
        if (!is_bool($this->{$field})) {
            $this->addError($field, 'Field with name ' . $field . ' is not boolean');
        }
    }

    /**
     * Check filed is array.
     *
     * For example:
     *      [['field_1', 'field_2'], 'array'],
     *
     * @param string $field field name.
     */
    public function validateArray($field)
    {
        if (!is_array($this->{$field})) {
            $this->addError($field, 'Field with name ' . $field . ' is not array');
        }
    }

    /**
     * Check field value is equal input length.
     *
     * For example:
     *      [['field_1', 'field_2'], 'length', 'param' => 5],
     *
     * @param string $field field name
     * @param int $param string length
     * @return bool;
     */
    public function validateLength($field, $param)
    {
        if (is_string($this->{$field})) {
            if (strlen($this->{$field}) === $param) {
                return true;
            }
        }

        $this->addError($field, 'Length of filed: ' . $field . 'is not equal ' . $param);
    }

    /**
     *  Check string is be less than given length
     *
     * For example:
     *      [['field_1', 'field_2'], 'lengthMax', 'param' => 5],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateLengthMax($field, $param)
    {
        if (is_string($this->{$field})) {
            if (strlen($this->{$field}) <= $param) {
                return true;
            }
        }

        $this->addError($field, 'Length of filed: ' . $field . 'is not less then ' . $param);
    }

    /**
     *  Check string is be greater than given length
     *
     * For example:
     *      [['field_1', 'field_2'], 'lengthMin', 'param' => 5],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateLengthMin($field, $param)
    {
        if (is_string($this->{$field})) {
            if (strlen($this->{$field}) >= $param) {
                return true;
            }
        }

        $this->addError($field, 'Length of filed: ' . $field . 'is not greater then ' . $param);
    }

    /**
     *  Check string is be in interval than given length
     *
     * For example:
     *      [['field_1', 'field_2'], 'lengthBetween', 'param' => [1, 10]],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateLengthBetween($field, $param)
    {
        if (is_string($this->{$field})) {
            if (strlen($this->{$field}) >= $param[0] && strlen($this->{$field}) <= $param[1]) {
                return true;
            }
        }

        $this->addError($field, 'Length of filed: ' . $field . 'is not less then ' . $param[0] . ' and is not greater ' . $param[1]);
    }

    /**
     *  Check value is be less than given value.
     *
     * For example:
     *      [['field_1', 'field_2'], 'max', 'param' => 5],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateMax($field, $param)
    {
        if (is_numeric($this->{$field})) {
            if ($this->{$field} <= $param) {
                return true;
            }
        }

        $this->addError($field, 'Value of filed: ' . $field . 'is not less then ' . $param);
    }

    /**
     *  Check value is be greater than given value.
     *
     * For example:
     *      [['field_1', 'field_2'], 'min', 'param' => 5],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateMin($field, $param)
    {
        if (is_numeric($this->{$field})) {
            if ($this->{$field} >= $param) {
                return true;
            }
        }

        $this->addError($field, 'Value of filed: ' . $field . 'is not greater then ' . $param);
    }

    /**
     *  Check value is be in interval than given value.
     *
     * For example:
     *      [['field_1', 'field_2'], 'between', 'param' => [1, 10]],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateBetween($field, $param)
    {
        if (is_numeric($this->{$field})) {
            if ($this->{$field} >= $param[0] && $this->{$field} <= $param[1]) {
                return true;
            }
        }

        $this->addError($field, 'Value of filed: ' . $field . 'is not less then ' . $param[0] . ' and is not greater ' . $param[1]);
    }

    /**
     *  Check value is be in interval than given value.
     *
     * For example:
     *      [['field_1', 'field_2'], 'in', 'param' => [1, 10, 2, 4]],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateIn($field, $param)
    {
        if (is_numeric($this->{$field})) {
            if (in_array($this->{$field}, $param)) {
                return true;
            }
        }

        $paramString = '[';
        foreach ($param as $item) {
            $paramString .= $item . ', ';
        }

        $paramString = substr($paramString, 0, -1);
        $paramString .= ']';
        $this->addError($field, 'Value of filed: ' . $field . 'is not in then array ' . $paramString);
    }


    /**
     *  Check value is be not in interval than given value.
     *
     * For example:
     *      [['field_1', 'field_2'], 'notIn', 'param' => [1, 10, 2, 4]],
     *
     * @param string $field field name
     * @param $param
     * @return bool
     */
    public function validateNotIn($field, $param)
    {
        if (is_numeric($this->{$field})) {
            if (in_array($this->{$field}, $param)) {
                return true;
            }
        }

        $paramString = '[';
        foreach ($param as $item) {
            $paramString .= $item . ', ';
        }

        $paramString = substr($paramString, 0, -1);
        $paramString .= ']';
        $this->addError($field, 'Value of filed: ' . $field . 'in then array ' . $paramString);
    }

    /**
     * Validate that a field is a valid IP address
     *
     * For example:
     *      [['field_1', 'field_2'], 'ip'],
     *
     * @param static $field filed name.
     */
    public function validateIp($field)
    {
        if (!filter_var($this->{$field}, FILTER_VALIDATE_IP)) {
            $this->addError($field, 'ip validate error');
        }
    }

    /**
     * Validate that a field is a valid URL address
     *
     * For example:
     *      [['field_1', 'field_2'], 'url'],
     *
     * @param static $field filed name.
     */
    public function validateUrl($field)
    {
        if (!filter_var($this->{$field}, FILTER_VALIDATE_URL)) {
            $this->addError($field, 'email validate error');
        }
    }

    /**
     * Validate that a field is a valid email.
     *
     * For example:
     *      [['field_1', 'field_2'], 'email'],
     *
     * @param static $field filed name.
     */
    public function validateEmail($field)
    {
        if (!filter_var($this->{$field}, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email validate error');
        }
    }

    /**
     * Validate that a field is a date.
     *
     * For example:
     *      [['field_1', 'field_2'], 'date'],
     *
     * @param static $field filed name.
     */
    public function validateDate($field)
    {
        if (!$this->{$field} instanceof \DateTime) {
            $this->addError($field, 'is not a date');
        }
    }
}


