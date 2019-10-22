<?php
require_once "Controller.php";
require_once dirname(__DIR__) . "/views/View.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/components/Currency.php";

class IndexController extends Controller
{
    private $pageTpl = '/views/main.tpl.php';

    public function __construct()
    {
        $this->model = new IndexModel();
        $this->view = new View();
    }

    public function index()
    {
        $this->pageData['title'] = "Просмотр сотрудников";

        if ($this->model->checkTable()) {
            $month = date("m", time());
            $this->pageData['current_month'] = $month;
            $this->pageData['workers'] = $this->model->getWorkers($month);
            $this->pageData['positions'] = $this->model->getPositions();

            $this->pageData['months'] = [
                1 => 'январь',
                2 => 'февраль',
                3 => 'март',
                4 => 'апрель',
                5 => 'май',
                6 => 'июнь',
                7 => 'июль',
                8 => 'август',
                9 => 'сентябрь',
                10 => 'октябрь',
                11 => 'ноябрь',
                12 => 'декабрь',
            ];

            $this->pageData['currency'] = Currency::getCurrency('USD', 2);
        }

        $this->view->render($this->pageTpl, $this->pageData);
    }
    /**
     * Действие для получения зарплат за выбранный месяц
     */
    public function selectMonth()
    {
        $month = $this->clearInt($_GET['month']);

        $salary = $this->model->getSalary($month);
        $salary = json_encode($salary);
        print_r($salary);
    }

    /**
     * Присвоение премии сотрудникам выбранной специальности
     */
    public  function addBonus()
    {
        $month = $this->clearInt($_POST['month']);
        $posId = $this->clearInt($_POST['posId']);
        $bonus = $this->clearInt($_POST['bonus']);

        $res = $this->model->saveBonus($month, $posId, $bonus);

        echo $res;
    }
}