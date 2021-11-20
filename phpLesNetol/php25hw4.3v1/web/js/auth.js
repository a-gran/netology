$(function () {
    function switcher() {
        var button = $('.switcher'),
            form = $('form');
        if (button.html() === 'Нет аккаунта? Зарегистрируйтесь!') {
            button.html('Уже есть аккаунт?');
            form.find('input[name=authButton]').attr({'name': 'regButton', 'value': 'Зарегистрироваться'});
        } else {
            button.html('Нет аккаунта? Зарегистрируйтесь!');
            form.find('input[name=regButton]').attr({'name': 'authButton', 'value': 'Войти'});
        }
    }

    $('form').on('submit', function (e) {

        var form = $(this),
            button = form.find('input[type=submit]');

        $.post({
            url: 'src/controllers/authController.php',
            data: form.serialize() + '&' + button.attr('name') + '=1',
            dataType: 'json',
            cache: false,
            success: function (data) {
                if (data['location']) window.location.replace(data['location']);
                if (data['error']) {
                    if ($('.error').length === 0) {
                        form.before('<p class="error">' + data['error'] + '</p>');
                    } else {
                        $('.error').html(data['error']);
                    }
                }
                if (data['notice']) {
                    if ($('.error').length === 0) {
                        form.before('<p class="notice">' + data['notice'] + '</p>');
                    } else {
                        $('.error').replaceWith('<p class="notice">' + data['notice'] + '</p>');
                    }
                    form.find('input[type=text]').val('');
                    form.find('input[type=password]').val('');
                    switcher();
                }
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '.switcher', function (e) {
        switcher();
        e.preventDefault();
    });
});