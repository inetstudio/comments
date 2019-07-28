<template>
    <div id="add_comments_widget_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade"
         ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Виджет комментариев</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-input-text
                            label = "Заголовок"
                            name = "title"
                            v-bind:value.sync = "model.params.title"
                        />

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'CommentsWidget',
    data() {
      return {
        model: this.getDefaultModel(),
        comments: {
          person: '',
        },
        options: {
          loading: true,
        },
        events: {},
      };
    },
    methods: {
      getDefaultModel() {
        return _.merge(this.getDefaultWidgetModel(), {
          view: 'admin.module.comments::front.partials.content.comments_widget',
          params: {
            id: 0,
            title: ''
          }
        });
      },
      initComponent() {
        let component = this;

        component.model = _.merge(component.model, this.widget.model);
        component.options.loading = false;
      },
      save() {
        let component = this;

        if (component.model.params.title === '') {
          $(component.$refs.modal).modal('hide');

          return;
        }

        let url = (component.model.params.id !== 0) ? route('back.comments.update', component.model.params.id): route('back.comments.store');
        let data = {
          is_read: 1,
          is_active: 1,
          message: component.model.params.title,
          commentable_id: $('#object-id').val(),
          commentable_type: $('#object-type').val()
        };

        if (component.model.params.id !== 0) {
          data._method = 'PUT';
        }

        component.options.loading = true;

        axios.post(url, data).then(response => {
          component.model.params.id = response.data.id;

          component.saveWidget(function() {
            $(component.$refs.modal).modal('hide');
          });
        });
      },
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.model = component.getDefaultModel();
        });
      });
    },
    mixins: [
      window.Admin.vue.mixins['widget'],
    ],
  };
</script>

<style scoped>
</style>
