<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageData['title']; ?></title>
    <meta name="vieport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="/css/style2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<header></header>

<div id="content">
    <form method="post" action="/add/create" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputFirstName">Имя:</label>
            <input type="text" name="first-name" class="form-control" id="inputFirstName" placeholder="Иван">
        </div>
        <div class="form-group">
            <label for="inputLastName">Фамилия:</label>
            <input type="text" name="last-name" class="form-control" id="inputLastName" placeholder="Иванов">
        </div>
        <div class="form-group">
            <label for="inputPositionId">Должность:</label>
            <select class="form-control" name="position-id" id="inputPositionId">
                <option selected>Выберите должность</option>
                <?php foreach ($pageData['positions'] as $key => $position):?>
                    <option value="<?=$key?>"><?=$position?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="inputPayRate">Оклад:</label>
            <input type="number" name="pay-rate" class="form-control" id="inputPayRate" placeholder="Введите сумму">
        </div>
        <div class="form-group">
            <label for="inputPhoto">Фото:</label>
            <input type="file" name="photo" class="form-control" id="inputPhoto" placeholder="Выберите фото (Формат .jpeg)">
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
</div>

<footer>

</footer>


<script src="/js/script.js"></script>


</body>
</html>