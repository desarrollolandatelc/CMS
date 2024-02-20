import '../../js/bootstrap';

import { createInertiaApp } from '@inertiajs/svelte'

import '../vendor/bootstrap/css/bootstrap.min.css';
import '../vendor/slider/slider.css';
import '../vendor/select2/css/select2-bootstrap.css';
import '../vendor/select2/css/select2.min.css';
import '../vendor/fontawesome/css/all.min.css';
import '../vendor/icofont/icofont.min.css';
import '../css/style.css';
import '../vendor/owl-carousel/owl.carousel.css';
import '../vendor/owl-carousel/owl.theme.css';


import "../vendor/jquery/jquery.min.js";
import "../vendor/bootstrap/js/bootstrap.bundle.min.js";
import "../vendor/select2/js/select2.min.js";

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
        return pages[`./Pages/${name}.svelte`]
    },
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
});
