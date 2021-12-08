import {comments} from './package/comments';

require('./plugins/tinymce/plugins/comments');

require('../../../../../../widgets/entities/widgets/resources/assets/js/mixins/widget');

window.Vue.component('CommentsWidget', () => import('./components/partials/CommentsWidget/CommentsWidget.vue'));

comments.init();
