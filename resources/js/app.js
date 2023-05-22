import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

require('./datatables');
window.Alpine = Alpine;

import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/powergrid.css'


Alpine.plugin(focus);

Alpine.start();
