<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageData['title']; ?></title>
    <meta name="vieport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<header></header>

<div id="content">
    <button type="button" class="btn btn-primary" id="js-create">
        Создать и заполнить таблицы
    </button>
    <div class="well" hidden></div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Сотрудники</div>
        <div class="panel-body">
            <!-- Карусель месяцев -->
            <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <?php foreach ($pageData['months'] as $key => $month):
                        if ($key == $pageData['current_month']) :?>
                            <div class="item active" data-id="<?=$key?>">
                                <?=$month?>
                            </div>
                        <?php else:?>
                            <div class="item" data-id="<?=$key?>">
                                <?=$month?>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
                <!-- Элементы управления -->
                <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Предыдущий</span>
                </a>
                <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Следующий</span>
                </a>
            </div>
            <a href="add" class="text-center">
                <button type="button" class="btn btn-success">
                    Добавить нового сотрудника
                </button>
            </a>
            <div id="change-salary" class="btn-group">
                <form id="add-bonus" enctype="application/x-www-form-urlencoded">
                    <button type="submit" class="btn btn-info">Выдать премию</button>
                     всем
                    <div class="btn-group">
                        <select class="form-control" name="position-id" id="inputPositionId">
                            <option selected>Выберите должность</option>
                            <?php foreach ($pageData['positions'] as $key => $position):?>
                                <option value="<?=$key?>"><?=$position?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input type="number" name="bonus" class="form-control" id="inputBonus" placeholder="Введите сумму">
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <table class="table my-table">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Должность</th>
                <th>
                    Зарплата
                    <div id="usd-rate" hidden><?=$pageData['currency']?></div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Выбор валюты
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="change-rub" href="#">Рубли</a></li>
                            <li><a id="change-usd" href="#">Доллары</a></li>
                        </ul>
                    </div>
                    <div class="btn-group" id="show-currency">RUB</div>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pageData['workers'] as $key => $worker):?>
            <tr id="<?=$worker['id']?>">
                <td class="worker-photo">
                    <?php if ($worker['photo']):?>
                        <div class="kt-user-card-v2">
                            <div class="kt-user-card-v2__pic">
                                <img alt="photo" src="<?=$worker['photo']?>"class="minimized">
                            </div>
                        </div>
                    <?php else:?>
                        <form class="add-picture" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=$worker['id']?>" hidden>
                            <div class="form-group">
                                <label for="inputPhoto">Выберите фото:</label>
                                <input type="file" name="photo" class="form-control" id="inputPhoto" placeholder="Выберите фото (Формат .jpeg)">
                            </div>
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </form>
                    <?php endif;?>
                </td>
                <td class="worker-first-name"><?=$worker['first_name']?></td>
                <td class="worker-last-name"><?=$worker['last_name']?></td>
                <td class="worker-position"><?=$worker['title']?></td>
                <td class="worker-salary" data-rub="<?=$worker['salary']?>">
                    <?=$worker['salary']?>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<footer>

</footer>


<script src="/js/script.js"></script>


</body>
</html>