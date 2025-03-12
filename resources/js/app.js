import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Este ya incluye Popper
import Swal from 'sweetalert2';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css'; // También importa el CSS
import Chart from 'chart.js/auto';
// Importar Flatpickr y el archivo CSS
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css"; // Estilo de Flatpickr
import { Spanish } from "flatpickr/dist/l10n/es.js"; // Localización en español

window.flatpickr = flatpickr;
flatpickr.localize(Spanish);
window.Chart = Chart;
window.Swal = Swal;
window.TomSelect = TomSelect;

