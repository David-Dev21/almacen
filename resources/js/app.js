import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import "./notifications.js";
import Swal from 'sweetalert2';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css'; 
import Chart from 'chart.js/auto';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Spanish } from "flatpickr/dist/l10n/es.js"; 
import { Tooltip } from 'bootstrap';

window.flatpickr = flatpickr;
flatpickr.localize(Spanish);
window.Chart = Chart;
window.Swal = Swal;
window.TomSelect = TomSelect;

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltipTriggerList.forEach((tooltipTriggerEl) => {
  new Tooltip(tooltipTriggerEl);
});