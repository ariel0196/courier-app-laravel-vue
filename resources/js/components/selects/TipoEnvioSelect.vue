<template>
	<vue-select
		:options="options"
		:label="label"
		:value="selected"
		@input="value => $emit('input', value)"
		:disabled="disabled"
	>
		<template slot="no-options">
			<div @mousedown.stop="">
				Porfavor escribe el nombre de un Tipo de Envío.
			</div>
		</template>
	</vue-select>
</template>

<script>
import SelectMixin from '@/mixins/SelectMixin';
import Proxy from '@/proxies/TipoEnvioProxy';

export default {

	mixins: [ SelectMixin ],

	proxy: new Proxy(),

	async created () {
		this.$options.proxy.setParameters({
			'nopaginate': true
		});
		let { data } = await this.$options.proxy.all();
		this.options = data;
		this.selected = data[0];
	},

	data () {
		return {
			label: 'nombre',
			valueKey: 'id',
			selected: null
		};
	},

	watch: {
		'value' (value) {
			this.selected = value;
		}
	}
};

</script>
