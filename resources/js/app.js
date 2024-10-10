import './bootstrap';

import store from './store'
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import "primeflex/primeflex.css";
import "primeicons/primeicons.css";
import './assets/styles/layout.scss';
import router from "./router";
import AppWrapper from "./AppWrapper.vue";
import Toast from 'primevue/toast';
import Chip from 'primevue/chip';
import Badge from 'primevue/badge';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from 'primevue/card';
import Toolbar from 'primevue/toolbar';
import Dialog from 'primevue/dialog';
import ConfirmPopup from 'primevue/confirmpopup';
import DynamicDialog from 'primevue/dynamicdialog';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import Select from 'primevue/select';
import Password from 'primevue/password';
import ConfirmationService from 'primevue/confirmationservice';
import Toasting, { useToast } from 'vue-toastification';
import "vue-toastification/dist/index.css";


router.beforeEach(function (to, from, next) {
  window.scrollTo(0, 0);
  next();
});

const app = createApp(AppWrapper);
app.config.globalProperties.$notification = useToast();
app.use(PrimeVue, {
  unstyled: false,
  theme: {
    preset: Aura,
    options: {
      darkModeSelector: ".app-dark",
    },
  },
  locale: {
    startsWith: "Начинается с",
    contains: "Содержит",
    notContains: "Не содержит",
    endsWith: "Заканчивается с",
    equals: "Равно",
    notEquals: "Не равно",
    noFilter: "Без фильтра",
    lt: "Меньше чем",
    lte: "Меньше чем или рано",
    gt: "Больше чем",
    gte: "Больше чем или равно",
    dateIs: "Date is",
    dateIsNot: "Date is not",
    dateBefore: "Date is before",
    dateAfter: "Date is after",
    clear: "Очистить",
    apply: "Применить",
    matchAll: "Match All",
    matchAny: "Match Any",
    addRule: "Добавить правило",
    removeRule: "Удалить правило",
    accept: "Да",
    reject: "Нет",
    choose: "Выбор",
    upload: "Загрузка",
    cancel: "Отказ",
    dayNames: [
      "Воскресенье",
      "Понедельник",
      "Вторник",
      "Среда",
      "Четверг",
      "Пятница",
      "Суббота",
    ],
    dayNamesShort: ["Вос", "Пон", "Вто", "Сре", "Чет", "Пят", "Суб"],
    dayNamesMin: ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
    monthNames: [
      "Январь",
      "Февраль",
      "Март",
      "Апрель",
      "Май",
      "Июнь",
      "Июль",
      "Август",
      "Сентябрь",
      "Октябрь",
      "Ноябрь",
      "Декабрь",
    ],
    monthNamesShort: [
      "Янв",
      "Фев",
      "Мар",
      "Апр",
      "Май",
      "Июн",
      "Июл",
      "Авг",
      "Сен",
      "Окт",
      "Ноя",
      "Дек",
    ],
    today: "Сегодня",
    weekHeader: "Wk",
    firstDayOfWeek: 0,
    dateFormat: "mm/dd/yy",
    weak: "Слабый",
    medium: "Средний",
    strong: "Сильный",
    passwordPrompt: "Введите пароль",
    emptyFilterMessage: "Результатов нет",
    emptyMessage: "Нет доступных опций",
    selectionMessage: "Выбрано элементов: {0}",
  },
});

app.use(router);
app.use(Toasting, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 30,
  newestOnTop: true,
  timeout: 15000,
  closeButton: false,
  closeOnClick: false,
})

app.component('Toast', Toast);
app.component('Badge', Badge);
app.component('Chip', Chip);
app.component('Button', Button);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('Card', Card);
app.component('Toolbar', Toolbar);
app.component('Textarea', Textarea);
app.component('Dialog', Dialog);
app.component('Select', Select);
app.component('ConfirmPopup', ConfirmPopup);
app.component('DynamicDialog', DynamicDialog);
app.component('InputText', InputText);
app.component('InputNumber', InputNumber);
app.component('Password', Password);
app.use(ConfirmationService);
app.use(store);
app.mount('#app');
