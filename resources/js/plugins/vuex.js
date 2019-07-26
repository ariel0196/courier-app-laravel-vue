import Vue from 'vue';
import Vuex from 'vuex';

import config from '@/store';

Vue.use(Vuex);

const store = new Vuex.Store(config);

export default store;
