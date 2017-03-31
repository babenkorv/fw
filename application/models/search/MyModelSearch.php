<?php

namespace application\models\search;

use application\models\MyModel;

class MyModelSearch extends MyModel
{
    /**
     * Screening string or 0 value.
     *
     * @param string $string
     * @return string
     */
    private function screening($string)
    {
        return (!empty($string) || is_numeric($string)) ? '"' . $string . '"' : '';
    }

    /**
     * Return model object with sets find options.
     *
     * @param array $findData array with find data.
     * @return $this
     */
    public function search($findData)
    {
        $this->where('name', '=', $this->screening($findData['name']))->andWhere('sex', '=', $this->screening($findData['sex']));

        return $this;
    }
}