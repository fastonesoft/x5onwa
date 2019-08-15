import Vue from 'vue'
import axios from 'axios'
import App from './App.vue'
import router from './router'
import store from './store'
import './plugins/iview.js'

import devArticle from './components/dev-article.vue'

Vue.prototype.$ = axios;
axios.defaults.headers.common['token'] = "8f84868ad064e706f4c902c9ae5a2a9d";
axios.defaults.headers.post["Content-type"] = "application/json";

Vue.config.productionTip = false;
// 框架模板
Vue.component('dev-article', devArticle);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
