export default {

	data () {
		return {
			model: {},
			defaultModel: {}
		};
	},

	created () { Object.assign(this.defaultModel, this.model);  },

	methods: {

		reset () { Object.assign(this.model, this.defaultModel); },

		async $_fetch (id) {
			if (!id) return;
			let { data } = await this.$options.proxy.find(id);
			if (this.$options.transformer) data = this.$options.transformer.fetch(data);
			this.model = data;
			// console.log(data);
		},

		async $_save () {
			let result = await this.$validator.validateAll();
			if (!result) return false;
			if (this.model.id) {
				await this.$options.proxy.update(this.model.id, this.model);
				// let response = await this.$options.proxy.update(this.model.id, this.model);
				// console.log(this.model);
				// console.log(response);
			} else {
				let { data } = await this.$options.proxy.create(this.model);
				this.model.id = data.id;
				// console.log(data);
			}
			return true;
		},

		async $_remove () {
			await this.$options.proxy.destroy(this.model.id);
		}
	}
};
