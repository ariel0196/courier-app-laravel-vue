import Vue from 'vue';
import VueSelect from 'vue-select';

let VSelect = {

	components: { VueSelect },

	props: {
		options: { required: true },
		value: { required: false }
	},

	template: `<vue-select :options="options" :value="newValue" @input="_input"/>`,

	computed: {
		newValue () {
			return this.options.find(option => {
				return option.value === this.value;
			});
		}
	},

	methods: {
		_input (val) {
			this.$emit('input', val ? val.value : null);
		}
	}
};

Vue.component('v-select', VSelect);
