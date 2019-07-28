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

  function initCommentsComponents() {
    if (typeof window.Admin.vue.modulesComponents.$refs['comments_CommentsWidget'] ==
        'undefined') {
      window.Admin.vue.modulesComponents.modules.comments.components = _.union(
          window.Admin.vue.modulesComponents.modules.comments.components, [
            {
              name: 'CommentsWidget',
              data: widgetData,
            },
          ]);
    } else {
      let component = window.Admin.vue.modulesComponents.$refs['comments_CommentsWidget'][0];

      component.$data.model.id = widgetData.model.id;
    }
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

        initCommentsComponents();

        window.waitForElement('#add_comments_widget_modal', function() {
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
