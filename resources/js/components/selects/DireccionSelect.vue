<template>
	<vue-select
		:options="options"
		:label="label"
		:value="value"
		@input="value => $emit('input', value)"
		:disabled="disabled"
	>
		<!-- :reset-on-options-change="true" -->

		<template slot="no-options">
			<div @mousedown.stop="">
				Porfavor escribe el nombre de una Direccion.
			</div>
		</template>
	</vue-select>
</template>
<script>
import SelectMixin from '@/mixins/SelectMixin';
import Proxy from '@/proxies/DireccionProxy';

export default {

	mixins: [ SelectMixin ],

	proxy: new Proxy(),

	props: {
		clienteId: {
			type: Number,
			default: null
		}
	},

	watch: {
		clienteId () { this.loadOptions(); }
	},

	data () {
		return {
			label: 'descripcion'
		};
	},

	methods: {
		async loadOptions () {
			if (!this.clienteId) return [];
			this.$options.proxy.setParameters({
				'cliente_id': this.clienteId,
				'nopaginate': true
			});
			let { data } = await this.$options.proxy.all();
			this.options = data;
		}
	}
};

</script>
