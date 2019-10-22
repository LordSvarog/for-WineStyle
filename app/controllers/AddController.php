<?php
require_once "Controller.php";
require_once dirname(__DIR__) . "/views/View.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/components/SavePictures.php";
require_once dirname(__DIR__) . "/models/IndexModel.php";

class AddController extends Controller
{
    private $pageTpl = '/views/add_worker.tpl.php';

    public function __construct()
    {
        $this->model = new AddModel();
        $this->view = new View();
    }

    public function index()
    {
        $this->pageData['title'] = "Добавление нового сотрудника";

        $extraModel = new IndexModel();
        $this->pageData['positions'] = $extraModel->getPositions();

        $this->view->render($this->pageTpl, $this->pageData);
    }
    /**
     * Добавление сотрудника
     */
    public function create()
    {
        $firstName = $this->clear($_POST['first-name']);
        $lastName = $this->clear($_POST['last-name']);
        $positionId = $this->clearInt($_POST['position-id']);
        $payRate = $this->clearInt($_POST['pay-rate']);
        $namePic = $this->clear($_FILES['photo']['name']);
        if ($namePic)
            $photo = "/images/minimages/" . $namePic;
        else
            $photo = "";
        $res = $this->model->registerNewWorker($firstName, $lastName, $positionId, $payRate, $photo);

        SavePictures::savePic($_FILES['photo']);
        if ($res)
            header("Location: /");
    }
    /**
     * Сохранение фотографии
     */
    public function add()
    {
        $pic = $_FILES['photo'];
        $id = $this->clearInt($_POST['id']);
        SavePictures::savePic($pic);
        $picPath = "/images/minimages/" . $pic['name'];
        if ($this->model->setPic($picPath, $id))
            echo $picPath;
    }
}