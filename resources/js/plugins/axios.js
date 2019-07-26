import Vue from 'vue';
import Axios from 'axios';

Vue.prototype.$axios = Axios;

// Object.defineProperty(Vue, '$axios', {
// 	get () {
// 		return Axios
// 	}
// })

// console.log(Vue.$axios)
