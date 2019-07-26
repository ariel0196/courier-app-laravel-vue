import Notifications from './Notifications.vue';

const Notify = {

	items: [],

	options: {
		duration: 5
	},

	showItem (item) {
		this.items.push({
			variant: item.variant,
			message: item.message,
			duration: item.duration || this.options.duration
		});
	},

	install (Vue) {

		Vue.component('notifications', Notifications);

		Vue.prototype.$notify = {
			show: (item) => {
				this.showItem(item);
			},
			getItems: () => {
				return this.items;
			}
		};
	}
};

export default Notify;
