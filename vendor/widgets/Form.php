<?php

namespace vendor\widgets;

use models\User;
use vendor\components\Auth;

class Form
{
    private $field;
    private $config = [];
    private $formName;
    private $value;
    private $label;

    /**
     * Set field name.
     *
     * @param $fieldName
     * @return $this
     */
    public function field($fieldName)
    {
        $this->field = '';
        $this->value = '';
        $this->field = $fieldName;

        return $this;
    }

    /**
     * Set default field value,
     *
     * @param string $default
     * @return $this
     */
    public function defaultValue($default = '')
    {
        $this->value = $default;

        return $this;
    }

    /**
     * Show input text field.
     */
    public function text()
    {
        echo (!empty($this->label)) ? '<label class="form-label" for="' . $this->field . '">' . $this->label . '</label>' : '';
        echo '<input type="text" name="' . $this->field . '"' . 'value="' . $this->value . '"' . 'form="' . $this->formName . '">';
    }

    /**
     * Show input email field.
     */
    public function email()
    {
        echo (!empty($this->label)) ? '<label class="form-label" for="' . $this->field . '">' . $this->label . '</label>' : '';
        echo '<input type="email" name="' . $this->field . '"' . 'value="' . $this->value . '"' . 'form="' . $this->formName . '">';
    }

    /**
     * Show radio buttons.
     *
     * Example @param $value:
     *     ['man' => 1, 'women' => 0]
     *
     * @param array $value assoc array with array_key = value and array_value = radio_value
     * @param string $active name default active radio item.
     */
    public function radio($value = [], $active = '')
    {
        echo '<div class="form-group">';
        echo '<label class="form-label">' . $this->label . '</label>';
        foreach ($value as $key => $value) {
            echo '<label class="form-radio">';
            echo '<input type="radio" name="' . $this->field . '" value="' . $value . '"';
            echo ($key == $active) ? 'checked' . ' />' : ' />';
            echo '<i class="form-icon"></i>' . $key;
            echo '</label>';
        }
        echo '</div>';
    }

    /**
     * Show checkbox.
     *
     * @param string $value field value.
     * @param string $message checkbox description.
     */
    public function checkbox($value, $message)
    {
        echo '<div class="form-group">';
        echo '<label class="form-checkbox">';
        echo '<input type="checkbox" name="' . $this->field . '" value="' . $value . '"/>';
        echo ' <i class="form-icon"></i>' . $message;
        echo '</label>';
        echo '</div>';
    }

    /**
     * Show textArea.
     *
     * @param int $rows count textArea rows.
     */
    public function textarea($rows = 5)
    {
        echo '<div class="form-group">';
        echo (!empty($this->label)) ? '<label class="form-label" for="' . $this->field . '">' . $this->label . '</label>' : '';
        echo '<textarea class="form-input" name="' . $this->field . '"' . 'value="' . $this->value . '"' . 'form="' . $this->formName . '" rows="' . $rows . '"> </textarea>';
        echo '</div>';
    }

    /**
     * Show select field.
     *
     * Example of @param $data:
     *      ['1'=> 'tiger', '2'=> 'turtle']
     *
     * @param array $data
     */
    public function select($data = [])
    {
        echo '<div class="form-group">';
        echo '<select class="form-select" form="' . $this->formName . '" name="' . $this->field . '">';

        foreach ($data as $key => $value) {
            echo '<option  value="' . $key . '"> ' . $value . '</option>';
        }

        echo '</select>';
        echo '</div>';
    }

    /**
     * Set field label.
     *
     * @param string $label label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Return hidden field with user token.
     */
    private function submitToken()
    {
        echo '<input type="text" hidden value="' . Auth::getUserToken() . '">';
    }

    /**
     * Show form head.
     *
     * @param string $name form name.
     * @param string $action form action.
     * @param string $method form method (get, post ...).
     * @param array $config
     * @return $this
     */
    public function begin($name, $action, $method = 'GET', $config = [])
    {
        $this->formName = $name;
        $this->config = $config;
        echo '<form action="' . $action . '" id="' . $name . '" method="' . $method . '">';
        return $this;
    }

    /**
     * Show hidden field with user token and submit button.
     */
    public function end()
    {
        $this->submitToken();
        echo '<input type="submit" id="' . $this->formName . '">';
        echo '</form>';
    }
}