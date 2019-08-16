import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './plugins/iview.js'

import axio from './libs/axios'

import devArticle from './components/dev-article.vue'

Vue.prototype.$ = axio;

Vue.config.productionTip = false;

// 框架模板
Vue.component('dev-article', devArticle);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
