$(function () {

    // Сюда запишем ник пользователя
    var nickname,
        users;
    // Получаем имя текущего пользователя
    $.post({
        url: 'src/controllers/authController.php',
        data: 'getNickname=1',
        success: function (data) {
            nickname = data;
        }
    });

    // Получаем имена всех пользователей
    $.post({
        url: 'src/controllers/tasksController.php',
        data: {getAllUsers: 1},
        dataType: 'json',
        cache: false,
        success: function (data) {
            users = data;
        }
    });

    // Добавить задачу
    $('.addTaskForm').on('submit', function (e) { // Обработка формы добавления задачи
        var description = $('textarea'),
            form = $(this);

        $.post({ // Отправка ajax запроса на добавление задачи
            url: 'src/controllers/tasksController.php',
            data: {addTask: 'true', task: description.val()},
            dataType: 'json',
            cache: false,
            success: function (data) { // При успехе добавляем задачу в таблицу
                var nick = data['assigned_user_login'] == nickname ? 'Вы' : data['assigned_user_login'],
                    tableRow =
                        $('<tr>' +
                        '<td>' + data['description'] + '</td>' +
                        '<td>Вы</td>' +
                        '<td>' + nick + '</td>' +
                        '<td style="color: orange">В процессе</td>' +
                        '<td>' + data['date_added'] + '</td>' +
                        '<td>' +
                        '<p class=\'edit link\'>Изменить &#9998; </p>' +
                        '<p class=\'is_done_changer link\'>Выполнить &#10004; </p>' +
                        '<p class=\'delete link\'>Удалить &cross; </p>' +
                        '<form method="POST" class="changeAssignedUser">' +
                        '<label>' +
                        '<input type="submit" value="Сменить исполнителя" name="changeAssignedUser"> ' +
                        '<select name="assignedUser" class="assignedUser">' +
                        '</select>' +
                        '</label>' +
                        '</form>' +
                        '<input type="hidden" value="' + data['id'] + '">' +
                        '</td>' +
                        '</tr>');

                $.each(users, function () {
                    tableRow.find('select').append('<option value="' + this['id'] + '">' + this['login'] + '</option>');
                });

                var tableRowWithoutSelector = tableRow[0]['outerHTML'],
                    table = $('.tasksOfUser');

                if (table.length === 1) { // Если таблица есть, просто вставить задачу (+ анимация цвета при добавлении)
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
                        '<div>' +
                        '<label>' +
                        'Сортировать по: ' +
                        '<select name="sortBy" id="sortBy">' +
                        '<option value="date">Дате добавления</option>' +
                        '<option value="status">Статусу</option>' +
                        '<option value="description">Описанию</option>' +
                        '</select>' +
                        '</label> ' +
                        '<input type="submit" name="sort" id="sort" value="Сортировка"> ' +
                        '</div>' +
                        '<h2 class="nickname">' + nickname + ', это задачи, созданные вами</h2>' +
                        '</form>' +
                        '<table class="tasksOfUser">' +
                        '<tr>' +
                        '<td>Задача</td>' +
                        '<td>Автор</td>' +
                        '<td>Исполнитель</td>' +
                        '<td>Статус</td>' +
                        '<td>Дата добавления</td>' +
                        '<td>Действия</td>' +
                        '</tr>' +
                        tableRowWithoutSelector +
                        '</table>'
                    );

                    $.each(users, function () {
                        tableRow.find('select').append('<option value="' + this['id'] + '">' + this['login'] + '</option>');
                    });

                    tasks.find('tr:eq(1)').css({
                        backgroundColor: 'lightgreen'
                    }).animate({
                        backgroundColor: 'white'
                    })
                }
            },
            error: function (data) { // При ошибке показать уведомление
                form.prepend('<p class="notice" style="color: red">' + data.responseText + '</p>');
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
        description.val(''); // Чистим textarea
        e.preventDefault(); // Отменяем стандартное поведение формы
    });

    // Отправка содержимого textarea на enter
    $('textarea').on('keypress', function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code === 13) {
            $('input[name=addTask]').trigger('click');
            e.preventDefault();
            return true;
        }
    });

    // Отметить задачу, как выполненную
    $(document).on('click', '.is_done_changer', function () {
        var div = $(this),
            id = div.closest('td').find('input[type=hidden]').val(),
            isDoneTd = div.closest('tr').children('td:eq(3)');

        $.post({
            url: 'src/controllers/tasksController.php',
            data: {isDoneChange: 1, id: id},
            success: function (data) {
                var dataBoolean = (data == 0),
                    status = dataBoolean ? 'В процессе' : 'Выполнено',
                    color = dataBoolean ? 'orange' : 'green',
                    button = dataBoolean ? 'Выполнить &#10004; ' : 'Не выполнить X ';

                isDoneTd.text(status).css({
                    'color': color
                });

                div.html(button);
            }
        });
    });

    // Удалить задачу
    $(document).on('click', '.delete', function () {
        var div = $(this),
            id = div.closest('td').find('input[type=hidden]').val(),
            table = div.closest('table');

        $.post({
            url: 'src/controllers/tasksController.php',
            data: {delete: 'true', id: id},
            success: function () {
                var tableTr = table.find('tr:not(:first)');
                if (tableTr.length - 1 === 0) { // Если мы удаляем последную задачу, убрать таблицу
                    if (table.attr('class') == 'tasksOfUser') {
                        $('.tasks').html(
                            '<p class="smile">&#9785;</p>' +
                            '<p style="text-align: center;">' + nickname + ', вы пока не добавили ни одной задачи</p>'
                        );
                        return;
                    } else {
                        $('.tasksForYou').html(
                            '<p class="smile">&#9785;</p>' +
                            '<p style="text-align: center;">' + nickname + ', для вас пока не добавили ни одной задачи</p>'
                        );
                        return;
                    }
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
                url: 'src/controllers/tasksController.php',
                data: form.serialize(),
                success: function (data) {
                    form.replaceWith(data);
                }
            });

            e.preventDefault();
        })
    });

    // Сортировка таблицы
    $(document).on('submit', '.sortForm', function (e) {
        var form = $(this);

        $.post({
            url: 'src/controllers/tasksController.php',
            data: form.serialize(),
            dataType: 'json',
            cache: false,
            success: function (data) {
                $('.tasksForUser tr:not(:first)').remove();
                $('.tasksOfUser tr:not(:first)').remove();
                $.each(data, function (key, value) {
                    var isDone = (value['is_done'] != 0),
                        processTd = isDone ? '<td style="color: green">Выполнено</td>' : '<td style="color: orange">В процессе</td>',
                        done = isDone ? '<p class=\'is_done_changer link\'>Не выполнить X </p>' : '<p class=\'is_done_changer link\'>Выполнить &#10004; </p>',
                        user = (nickname == value['user_login']) ? 'Вы' : value['user_login'],
                        assigned_user = (nickname == value['assigned_user_login']) ? 'Вы' : value['assigned_user_login'],
                        trWithoutForm =
                            '<tr>' +
                            '<td>' + value['description'] + '</td>' +
                            '<td>' + user + '</td>' +
                            '<td>' + assigned_user + '</td>' +
                            processTd +
                            '<td>' + value['date_added'] + '</td>' +
                            '<td>' +
                            '<p class=\'edit link\'>Изменить &#9998; </p>' +
                            done +
                            '<p class=\'delete link\'>Удалить &cross; </p>' +
                            '<input type="hidden" value="' + value['id'] + '">' +
                            '</td>' +
                            '</tr>',
                        fullTr =
                            '<tr>' +
                            '<td>' + value['description'] + '</td>' +
                            '<td>' + user + '</td>' +
                            '<td>' + assigned_user + '</td>' +
                            processTd +
                            '<td>' + value['date_added'] + '</td>' +
                            '<td>' +
                            '<p class=\'edit link\'>Изменить &#9998; </p>' +
                            done +
                            '<p class=\'delete link\'>Удалить &cross; </p>' +
                            '<form method="POST" class="changeAssignedUser">' +
                            '<label>' +
                            '<input type="submit" value="Сменить исполнителя" name="changeAssignedUser"> ' +
                            '<select name="assignedUser" class="assignedUser">' +
                            '</select>' +
                            '</label>' +
                            '</form>' +
                            '<input type="hidden" value="' + value['id'] + '">' +
                            '</td>' +
                            '</tr>';


                    if (value['user_login'] == nickname) {
                        $('.tasksOfUser').append(fullTr);
                    }
                    if (value['assigned_user_login'] == nickname && value['user_login'] != nickname) {
                        $('.tasksForUser').append(trWithoutForm);
                    }
                });

                $('.assignedUser').each(function () {
                    var select = $(this);
                    $.each(users, function () {
                        select.append('<option value="' + this['id'] + '">' + this['login'] + '</option>');
                    });
                });
            }
        });
        e.preventDefault();
    });

    // Изменить исполнителя задачи
    $(document).on('submit', '.changeAssignedUser', function (e) {
        var form = $(this),
            id = form.closest('td').find('input[type=hidden]').val(),
            assignedUserTd = form.closest('tr').find('td:eq(2)');

        $.post({
            url: 'src/controllers/tasksController.php',
            data: form.serialize() + '&changeAssignedUser=1&id=' + id,
            success: function (data) {
                var content = data == nickname ? 'Вы' : data;
                assignedUserTd.text(content);
            }
        });
        e.preventDefault();
    });

    // Выход из приложения
    $('.logout').on('click', function () {
        $.post({
            url: 'src/controllers/authController.php',
            data: 'logout=1',
            dataType: 'json',
            cache: false,
            success: function (data) {
                if (data['location']) window.location.replace(data['location']);
            }
        });
    });

});
