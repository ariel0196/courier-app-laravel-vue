import Vue from 'vue';
import VueRouter from 'vue-router';

import config from '@/router';

Vue.use(VueRouter);

const router = new VueRouter(config);

router.beforeEach((to, from, next) => {

	if (to.matched.some(m => m.meta.auth) && !localStorage.getItem('user'))
		next('/login');

	next();
});

export default router;
