window.tinymce.PluginManager.add('comments', function(editor) {
  let widgetData = {
    widget: {
      events: {
        widgetSaved: function(model) {
          editor.execCommand('mceReplaceContent', false,
              '<img class="content-widget" data-type="comments" data-id="' +
              model.id + '" alt="Виджет-комментарии" />',
          );
        },
      },
    },
  };

  function loadWidget() {
    let component = window.Admin.vue.helpers.getVueComponent('comments', 'CommentsWidget');

    component.$data.model.id = widgetData.model.id;
  }

  editor.addButton('add_comments_widget', {
    title: 'Виджет комментариев',
    icon: 'fa fa-comments',
    onclick: function() {
      let content = editor.selection.getContent();

      if ($('#object-id').val() === '') {
        swal({
          title: 'Ошибка',
          text: 'Для добавления виджета необходимо сохранить материал',
          type: 'error',
        });

        return false;
      }

      let isComments = /<img class="content-widget".+data-type="comments".+>/g.test(
          content);

      if (content === '' || isComments) {
        widgetData.model = {
          id: parseInt($(content).attr('data-id')) || 0,
        };

        window.Admin.vue.helpers.initComponent('comments', 'CommentsWidget', widgetData);

        window.waitForElement('#add_comments_widget_modal', function() {
          loadWidget();

          $('#add_comments_widget_modal').modal();
        });
      } else {
        swal({
          title: 'Ошибка',
          text: 'Необходимо выбрать виджет-вопрос',
          type: 'error',
        });

        return false;
      }
    },
  });
});
