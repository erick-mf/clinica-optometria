import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { modal } from './modal';
document.addEventListener('DOMContentLoaded', function(){
modal()
})
