import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import { createHead } from '@vueuse/head';
import '@/assets/css/app.css';
import appSetting from '@/app-setting';
import i18n from '@/i18n';
import { TippyPlugin } from 'tippy.vue';
import Maska from 'maska';
import VueEasymde from 'vue3-easymde';
import 'easymde/dist/easymde.min.css';
import Popper from 'vue3-popper';
import vue3JsonExcel from 'vue3-json-excel';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const pinia = createPinia();
const head = createHead();

const appName = import.meta.env.VITE_APP_NAME || 'GyD';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./views/${name}.vue`, import.meta.glob('./views/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(PerfectScrollbar)
      .use(head)
      .use(i18n)
      .use(TippyPlugin)
      .use(Maska)
      .use(VueEasymde)
      .component('Popper', Popper)
      .use(vue3JsonExcel)
      .mount(el);
    appSetting.init();
  },
  progress: {
      color: '#4B5563',
  },
})