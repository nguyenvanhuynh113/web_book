import './bootstrap';
import 'owl.carousel';

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
ClassicEditor
    .create(document.querySelector('#content'))
    .then(editor => {
        console.log('CKEditor is ready to use.', editor);
    })
    .catch(error => {
        console.error('Error initializing CKEditor.', error);
    });
window.$ = window.jQuery = require('jquery');
require('owl.carousel');
