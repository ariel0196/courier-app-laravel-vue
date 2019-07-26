// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

// Core
import Vue from 'vue';

// Plugins
import router from './plugins/vue-router';
import store from './plugins/vuex';
import './plugins/axios';
import './plugins/bootstrap-vue';
import './plugins/font-awesome';
import './plugins/simple-line-icons';
import './plugins/flag-icon-css';
import './plugins/vue-bs-notify';
import './plugins/vee-validate';
// import './plugins/vue-the-mask'
// import './plugins/vue-select/'

// App
import App from './App';

new Vue({

	el: '#app',
	template: '<app/>',
	components: {
		App
	},
	router,
	store
});