require('./plugins/tinymce/plugins/comments');
require('../../../../../../widgets/resources/assets/js/mixins/widget');

Vue.component(
    'CommentsWidget',
    require('./components/partials/CommentsWidget/CommentsWidget.vue').default,
);

window.Switchery = require('switchery');

let comments = require('./package/comments');
comments.init();
