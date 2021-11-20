$(function () {

    $('.addTaskForm').on('submit', function (e) { // Добавления задачи
        var description = $('textarea'),
            form = $(this);

        $.post({ // Отправка ajax запроса на добавление задачи
            url: 'src/controller.php',
            data: {addTask: 'true', task: description.val()},
            dataType: 'json',
            cache: false,
            success: function (data) { // При успехе добавляем задачу в таблицу
                var tableRow =
                        $('<tr>' +
                            '<td>' + data['description'] + '</td>' +
                            '<td style="color: orange">В процессе</td>' +
                            '<td>' + data['date_added'] + '</td>' +
                            '<td>' +
                            '<p class=\'edit link\'>Изменить &#9998; </p>' +
                            '<p class=\'done link\'>Выполнить  </p>' +
                            '<p class=\'delete link\'>Удалить &cross; </p>' +
                            '<input type="hidden" value="' + data['id'] + '">' +
                            '</td>' +
                            '</tr>'),
                    tableRowWithoutSelector = tableRow[0]['outerHTML'],
                    table = $('table');

                if (table.length === 1) { // Если таблица есть, вставить задачу (+ анимация цвета при добавлении)
                    table.append(tableRow);
                    tableRow.css({
                        backgroundColor: 'lightgreen'
                    }).animate({
                        backgroundColor: ($('tr').length - 1) % 2 === 0 ? '#eeeeee' : 'white'
                    })
                } else { // Если таблицы нет, создаем ее и добавляем туда задачу (+ анимация цвета при добавлени)
                    var tasks = $('.tasks');
                    tasks.html(
                        '<form method="POST" class="sortForm">' +
                        '<label>' +
                        'Сортировать по: ' +
                        '<select name="sortBy" id="sortBy">' +
                        '<option value="date">Дате добавления</option>' +
                        '<option value="status">Статусу</option>' +
                        '<option value="description">Описанию</option>' +
                        '</select>' +
                        '</label> ' +
                        '<input type="submit" name="sort" id="sort" value="Сортировка"> ' +
                        '</form>' +
                        '<table>' +
                        '<tr>' +
                        '<td>Задача</td>' +
                        '<td>Статус</td>' +
                        '<td>Дата добавления</td>' +
                        '<td>Действия</td>' +
                        '</tr>' +
                        tableRowWithoutSelector +
                        '</table>'
                    );

                    tasks.find('tr:eq(1)').css({
                        backgroundColor: 'lightgreen'
                    }).animate({
                        backgroundColor: 'white'
                    })
                }
            },
            error: function (data) { // При ошибке показать сообщение
                form.prepend('<p class="notice" style="color: red">Ошибка, попробуйте еще раз! (' + data.responseText + ')</p>');
                $('.notice').delay(1500).fadeOut(1000, function () {
                    $(this).css({
                        'display': 'block',
                        'visibility': 'hidden'
                    }).animate({
                        'height': '0',
                        'margin': '0'
                    }, function () {
                        $(this).remove();
                    });
                });
            }
        });
        description.val(''); // Чистим текстовую область
        e.preventDefault(); // Отменяем стандартное поведение формы
    });


    // Отправка содержимого текстовой области на enter
    $('textarea').on('keypress', function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code === 13) {
            $('input[name=addTask]').trigger('click');
            e.preventDefault();
            return true;
        }
    });

    // Отметить задачу, как выполненную
    $(document).on('click', '.done', function () {
        var div = $(this),
            id = div.closest('td').find('input[type=hidden]').val(),
            isDoneTd = div.closest('tr').children('td:eq(1)');

        if (isDoneTd.text() === 'Выполнено') { // Если уже выполненная, то ничего не делать
            return;
        }

        $.post({
            url: 'src/controller.php',
            data: {done: 'true', id: id},
            success: function (data) {
                isDoneTd.text(data).css({
                    'color': 'green'
                });
                div.fadeOut('fast');
            }
        });
    });

    // Удалить задачу
    $(document).on('click', '.delete', function () {
        var div = $(this),
            id = div.closest('td').find('input[type=hidden]').val();

        $.post({
            url: 'src/controller.php',
            data: {delete: 'true', id: id},
            success: function () {
                var tableTr = $('table tr:not(:first)');
                if (tableTr.length - 1 === 0) { // Если мы удаляем последную задачу, убрать таблицу
                    $('.tasks').html(
                        '<p class="smile">&#9785;</p>' +
                        '<p>Вы пока не добавили ни одной задачи</p>'
                    );
                    return;
                }
                div.closest('tr').remove();
                tableTr.each(function () {
                   if ($(this).index() % 2 === 0) {
                       $(this).css({
                           backgroundColor: '#eeeeee'
                       })
                   } else {
                       $(this).css({
                           backgroundColor: 'white'
                       })
                   }
                });
            }
        });
    });

    // Отредактировать задачу
    $(document).on('click', '.edit', function () {
        var td = $(this).closest('tr').children('td:first-child'),
            id = $(this).closest('td').find('input[type=hidden]').val(),
            text = td.text();

        // Убрать текст задачи, показать форму для изменения
        td.fadeOut('fast', function () {
            var replaceElement = $('<td>' +
                '<form method="POST" class="editTaskForm">' +
                '<input type="text" name="editDescription" value="' + text + '" required><br>' +
                '<input type="submit" value="Изменить" name="editTask" class="button">' +
                '<input type="hidden" name="id" value="' + id + '">' +
                '</form>' +
                '</td>').hide();

            td.replaceWith(replaceElement);
            replaceElement.fadeIn('fast');
        });

        // При подтверждении изменения изменить и вставить изменения
        $(document).on('submit', '.editTaskForm', function (e) {
            var form = $(this);
            $.post({
                url: 'src/controller.php',
                data: form.serialize(),
                success: function (data) {
                    form.replaceWith(data);
                },
                error: function (data) {
                    console.log('Ошибка ' + data);
                }
            });

            e.preventDefault();
        })
    });

    $(document).on('submit', '.sortForm', function (e) {
        var form = $(this);
        $.post({
            url: 'src/controller.php',
            data: form.serialize(),
            dataType: 'json',
            cache: false,
            success: function (data) {
                $('table tr:not(:first)').remove();
                $.each(data, function (key, value) {
                    var isDone = value['is_done'];
                    if (isDone == 0) {
                        var processTd = '<td style="color: orange">В процессе</td>',
                            done = '<p class=\'done link\'>Выполнить &#10003; </p>';
                    }
                    if (isDone == 1) {
                        var processTd = '<td style="color: green">Выполнено</td>',
                            done = '';
                    }

                    $('table').append(
                        '<tr>' +
                        '<td>' + value['description'] + '</td>' +
                        processTd +
                        '<td>' + value['date_added'] + '</td>' +
                        '<td>' +
                        '<p class=\'edit link\'>Изменить &#9997; </p>' +
                        done +
                        '<p class=\'delete link\'>Удалить &#10008; </p>' +
                        '<input type="hidden" value="' + value['id'] + '">' +
                        '</td>' +
                        '</tr>'
                    )
                });
            }
        });
        e.preventDefault();
    });
});
