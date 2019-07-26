<template>
	<b-table
		:items="items"
		:fields="fields"
		:show-empty="true"
		head-variant="light"
		outlined
	>
		<template
			slot="acciones"
			slot-scope="row"
		>
			<!-- BOTON: ELIMINAR  -->
			<b-button
				v-if="editingRow !== row.index"
				:disabled="disabled"
				@click="removeRow(row.index)"
				variant="danger"
			>
				<i class="fa fa-trash" />
			</b-button>
		</template>
	</b-table>
</template>


<script>
export default {
	props: {
		items: {
			type: Array,
			default: () => [],
		},
		disabled: {
			type: Boolean,
			default: false
		}
	},
	data () {
		return {
			editingRow: null,
			fields: [
				{ key: 'id' },
				{ key: 'cliente_destino.nombre' },
				{ key: 'tipo_envio.nombre' },
				{ key: 'precio_total' },
				{ key: 'acciones', class: 'align-center' }
			]
		};
	},
	methods: {
		removeRow (index) {
			if (!confirm('Desea desasociar el Envío de la Factura?')) return;
			this.$delete(this.items, index);
		}
	}
};
</script>
