$(document).ready(function() {
    const div = $('div#carousel'),
        usd = $('div#usd-rate').text();

    //Создание и заполнение таблиц в базе
    $('#content').on('click', '#js-create', function() {
        $.get("/create?go=1", function(res) {
            const div = $('div#content .well');

            switch (res*1) {
                case 0:
                    div.text('Ошибка, повторите позднее')
                    .removeAttr('hidden');break;
                case 1:
                    div.text('Создание прошло успешно!!!')
                    .removeAttr('hidden');break;
            }
        });
    });

    //Вывод зарплат в зависимости от месяца
    div.on('click', 'a.carousel-control', function () {
       // console.log(div.find('div.active').text());
       let month = div.find('div.active').data('id');
       if ($(this).data('slide') === 'next') {
           month++;
           if (month === 13)
               month = 1;
       } else {
           month--;
           if (month === 0)
               month = 12;
       }
       $.get("/selectMonth?month=" + month, function(res) {
           res = $.parseJSON(res);
           $('tbody').find('td.worker-salary').each(function(i, el) {
               ++i;
               if ($('thead').find('ul.done').length !== 0)
                   $(el).text(+(res[i] / usd).toFixed(1));
               else
                   $(el).text(res[i]);
               $(el).attr('data-rub', res[i]);
           });
       })
    });

    //Скрипт для увеличения фото сотрудника
    $('.minimized').click(function(event) {
        let i_path = $(this).attr('src').replace('/minimages/', '/');
        $('body').append('<div id="overlay"></div><div id="magnify"><img src="' + i_path + '" onload="showPic()"><div id="close-popup"><i></i></div></div>');
    });

    $('body').on('click', '#close-popup, #overlay', function(event) {
        event.preventDefault();

        $('#overlay, #magnify').fadeOut('fast', function() {
            $('#close-popup, #magnify, #overlay').remove();
        });
    });

    //Сохранение фотографии
    $('form.add-picture').on('submit', function(e){
        e.preventDefault();
        $(this).parent().find('span').text('');
        let $that = $(this),
            formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму

        if ($that[0][1]['files'].length === 0) {
            $(this).parent().append("<span>Вы забыли выбрать файл!!!</span>");
            return;
        }
        $.ajax({
            url: '/add/add', // путь к php-обработчику
            type: 'POST', // метод передачи данных
            contentType: false, // важно - убираем форматирование данных по умолчанию
            processData: false, // важно - убираем преобразование строк по умолчанию
            data: formData,
            success: function(res){
                // console.log(res);
                if(res){
                    $that.before('<div class="kt-user-card-v2">' +
                                            '<div class="kt-user-card-v2__pic">' +
                                                '<img alt="photo" src="' + res +'" class="minimized">' +
                                            '</div>' +
                                          '</div>'
                    );
                    $that.css('display', 'none');
                }
            }
        });
    });

    //Изменение валюты отображения доходов
    $('a#change-usd').on('click', function(e) {
       e.preventDefault();
       if ($(this).closest('ul.done').length === 0) {
           $('tbody').find('td.worker-salary').each(function (i, el) {
               let salary = +(($(el).attr('data-rub')) / usd).toFixed(1);
               $(el).text(salary);
           });

           $('div#show-currency').text('USD');
           //добавляем класс, чтобы второй раз не пересчитывать при нажатии снова
           $(this).closest('ul.dropdown-menu').addClass('done');
       }
    });
    $('a#change-rub').on('click', function(e) {
        e.preventDefault();

        $('tbody').find('td.worker-salary').each(function(i, el) {
            let salary = $(el).attr('data-rub');
            $(el).text(salary);
        });

        $('div#show-currency').text('RUB');

        $(this).closest('ul.dropdown-menu').removeClass('done');
    });

    //Выдача премии сотрудникам выбранной профессии
    $('form#add-bonus').on('submit', function(e){
        e.preventDefault();
        const month = div.find('div.active').data('id'),
            posId = $('#inputPositionId option:selected').val(),
            bonus = $('#inputBonus').val();
        if(posId === '' || bonus === ''){// если поле пустое
            $(this).parent().append("<span>Поля 'Должность' и 'Сумма' должны быть заполнены!!!</span>");
            return;
        }
console.log(month, posId, bonus);
        let data = $.param({month: month, posId: posId, bonus: bonus});

        $.post("/addBonus", data, function(res) {
            if (res) {
                const title = $('#inputPositionId option:selected').text();
                $('tbody').children('tr').each(function(i, el) {
                    if ($(el).children('td.worker-position').text() === title) {
                        const tdSalary = $(el).children('td.worker-salary');
                        let salary = tdSalary.data('rub'),
                            newSalary = salary*1 + bonus*1;
                        tdSalary.attr('data-rub', newSalary);
                        if ($('thead').find('ul.done').length !== 0) {
                            newSalary = +(newSalary / usd).toFixed(1);
                        }

                        $(el).children('td.worker-salary').text(newSalary);
                    }
                });
            }
        });
    });
});

function showPic() {
    $('#magnify').css({
        left: ($(window).width() - $('#magnify').outerWidth())/2,
        top: ($(window).height() - $('#magnify').outerHeight())/2
    });
    $('#overlay, #magnify').fadeIn('fast');
}