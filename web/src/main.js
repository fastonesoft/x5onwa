import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './plugins/iview.js'

import axios from './libs/axios'

import devArticle from './components/dev-article.vue'

// 跨域
Vue.prototype.$ = location.hostname === 'localhost' ? axios.axio_local : axios.axio;

Vue.config.productionTip = false;

// 框架模板
Vue.component('dev-article', devArticle);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
