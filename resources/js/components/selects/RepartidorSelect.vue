<template>
	<vue-select
		:options="options"
		:label="label"
		:value="value"
		@input="value => $emit('input', value)"
		:disabled="disabled"
	>
		<template slot="no-options">
			<div @mousedown.stop="">
				Porfavor escribe el nombre de un Repartidor.
			</div>
		</template>
	</vue-select>
</template>

<script>
import SelectMixin from '@/mixins/SelectMixin';
import Proxy from '@/proxies/RepartidorProxy';

export default {

	mixins: [ SelectMixin ],

	proxy: new Proxy(),
	
	async created () {
		this.$options.proxy.setParameters({
			'nopaginate': true
		});
		let { data } = await this.$options.proxy.all();
		this.options = data;
	},

	data () {
		return {
			label: 'nombre'
		};
	}
};
</script>
