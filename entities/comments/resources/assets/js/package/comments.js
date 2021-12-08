import Swal from 'sweetalert2';
import Switchery from 'switchery';

export let comments = {
  init: () => {
    let $table = $('#comments_table .dataTable');
    let $tableContent = $('#comments_table .ibox-content');

    $table.on('ifClicked', '#comment_all', function() {
      $('.group-element').iCheck('toggle');
    });

    $('#comments_table .table-group-buttons a').on('click', function() {
      let $btn = $(this);

      let url = $btn.data('url');
      let data = $table.find('.group-element').serializeJSON();

      Swal.fire({
        title: 'Вы уверены?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Отмена',
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Да',
      }).then((result) => {
        if (result.value) {
          $tableContent.toggleClass('sk-loading');

          $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: data,
            success: function(data) {
              $tableContent.toggleClass('sk-loading');
              $('#comment_all').iCheck('uncheck');

              if (data.success === true) {
                Swal.fire({
                  title: 'Записи обновлены',
                  icon: 'success',
                });
                $table.DataTable().ajax.reload(null, false);
              } else {
                showError('При обновлении записей произошла ошибка');
              }
            },
            error: function() {
              $tableContent.toggleClass('sk-loading');
              $('#comment_all').iCheck('uncheck');

              showError('При обновлении записей произошла ошибка');
            },
          });
        }
      });
    });

    $table.on('draw.dt', function() {
      if ($('.i-checks').length > 0) {
        $('.i-checks').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
        });
      }

      let $switchers = $table.find('input.switchery');

      $switchers.each(function() {
        new Switchery($(this).get(0), {
          size: 'small',
        });
      });

      $switchers.on('change', function() {
        let $input = $(this);

        let url = $input.data('target');
        let val = $input.val();

        $tableContent.toggleClass('sk-loading');

        $.ajax({
          url: url,
          method: 'POST',
          dataType: 'json',
          data: {
            comments: [val],
          },
          success: function(data) {
            $tableContent.toggleClass('sk-loading');

            if (data.success === true) {
              Swal.fire({
                title: 'Запись изменена',
                icon: 'success',
              });
            } else {
              showError('Произошла ошибка');
            }
          },
          error: function() {
            $tableContent.toggleClass('sk-loading');

            showError('Произошла ошибка');
          },
        });
      });
    });

    function showError(text) {
      Swal.fire({
        title: 'Ошибка',
        text: text,
        icon: 'error',
      });
    }
  }
};
