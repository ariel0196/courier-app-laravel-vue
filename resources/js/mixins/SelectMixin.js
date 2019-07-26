import VueSelect from 'vue-select';
import _ from 'lodash';

export default {

	components: { VueSelect },

	props: {
		value: {
			type: Object,
			default: null
		},
		disabled: {
			type: Boolean,
			default: false
		}
	},

	data () {
		return {
			label: 'id',
			valueKey: 'id',
			options: []
		};
	},

	methods: {
		$_search: _.debounce(async function (search, loading) {
			try {
				loading(true);
				this.$options.proxy.setParameters({
					'nopaginate': true,
					[this.label]: search
				});
				let { data } = await this.$options.proxy.all();
				this.options = data;
			} catch (e) {
				console.log(e);
			}
			loading(false);
		}, 350),
	}
};
