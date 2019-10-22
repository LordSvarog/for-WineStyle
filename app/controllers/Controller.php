<?php

abstract class Controller
{
    public $model;
    public $view;
    protected $pageData = array();

    protected function clear($data)
    {
        $data = trim(strip_tags($data));

        return $data;
    }

    protected function clearInt($data)
    {
        $data = abs((int)$data);

        return $data;
    }
}