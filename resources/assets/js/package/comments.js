let comments = {};

comments.init = function () {
    $('.comments-package .dataTable').each(function () {
        let table = $(this);

        $('.comments-package .table-group-buttons a').each(function () {
            let btn = $(this);

            btn.on('click', function () {
                let data = $('.comments-package .group-element').serializeJSON();

                swal({
                    title: "Вы уверены?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Отмена",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Да",
                    closeOnConfirm: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: btn.attr('data-url'),
                            method: "POST",
                            dataType: "json",
                            data: data,
                            success: function (data) {
                                if (data.success === true) {
                                    swal({
                                        title: "Записи обновлены",
                                        type: "success"
                                    });
                                    table.DataTable().ajax.reload();
                                } else {
                                    swal({
                                        title: "Ошибка",
                                        text: "При обновлении записей произошла ошибка",
                                        type: "error"
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    });

    $('.comments-package .dataTable').each(function () {
        $(this).on('draw.dt', function () {
            if ($('.i-checks').length > 0) {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });
            }

            $('input.switchery').each(function () {
                new Switchery($(this).get(0), {
                    size: 'small'
                });

                let url = ($(this).attr('data-target'));

                if (url) {
                    $(this).on('change', function () {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            dataType: 'json',
                            success: function (data) {
                                if (data.success === true) {
                                    swal({
                                        title: "Запись изменена",
                                        type: "success"
                                    });
                                } else {
                                    swal({
                                        title: "Ошибка",
                                        text: "Произошла ошибка",
                                        type: "error"
                                    });
                                }
                            }
                        });
                    });
                }
            });
        });
    });
};

module.exports = comments;
