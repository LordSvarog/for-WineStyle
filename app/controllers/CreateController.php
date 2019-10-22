<?php
require_once "Controller.php";

class CreateController extends Controller
{
    public function __construct()
    {
        $this->model = new CreateModel();
    }

    public function index()
    {
        $res = 0;
        if ($this->clearInt($_GET['go']) === 1) {
            $res = $this->model->createTables();
            if ($res)
                $res = $this->model->addProfessions();
            if ($res)
                $res = $this->model->addWorkers();
            if ($res)
                $res = $this->model->addPayments();
        }
        echo (int)$res;
    }
}