import { createApp } from 'vue'
import router from '@/router'
import { createPinia } from 'pinia'
import App from './App.vue'
import { i18nVue } from 'laravel-vue-i18n';

const pinia = createPinia()
const app = createApp(App)

app.use(router)
app.use(pinia)
app.use(i18nVue, {
    lang: 'en',
    resolve: async lang => {
        const langs = import.meta.glob('../../lang/*.json');
        return await langs[`../../lang/${lang}.json`]();
    }
})
app.mount('#app')
