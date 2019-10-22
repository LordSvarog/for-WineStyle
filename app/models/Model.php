<?php

class Model
{
    protected $db = '';

    public function __construct()
    {
        $this->db = Database::connectionToDB();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}