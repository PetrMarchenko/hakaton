<?php

namespace Project\Model;

class Project
{
    public $id;
    public $title;

    public $map = array(
        'id' => 'id',
        'title' => 'title',
    );

    public function exchangeArray($data)
    {
        foreach ($this->map as $key =>$value) {
            (array_key_exists($value,$data)) ? $this->$key = $data[$value] : false;
        }
    }

}