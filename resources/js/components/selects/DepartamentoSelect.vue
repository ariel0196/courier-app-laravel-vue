<template>
	<vue-select
		:options="options"
		:label="label"
		:value="value"
		@input="value => $emit('input', value)"
		@search="$_search"
		:filterable="false"
		:disabled="disabled"
	>
		<template slot="no-options">
			<div @mousedown.stop="">
				Porfavor escribe el nombre de un Departamento.
			</div>
		</template>
	</vue-select>
</template>
<script>
import SelectMixin from '@/mixins/SelectMixin';
import Proxy from '@/proxies/DepartamentoProxy';

export default {

	mixins: [ SelectMixin ],

	proxy: new Proxy(),

	data () {
		return {
			label: 'nombre',
			valueKey: 'id',
		};
	}
};

</script>
