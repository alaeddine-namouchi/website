/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// any CSS you import will output into a single css file (app.css in this case)
// import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import bsCustomFileInput from 'bs-custom-file-input';

// loads the jquery package from node_modules
import $ from 'jquery';

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
import greet from './greet';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-react';

window.ClassicEditor = ClassicEditor;
window.CKEditor = CKEditor;

bsCustomFileInput.init();


$(document).ready(function() {
    $('body').prepend('<h1>'+greet('jill')+'</h1>');
 });