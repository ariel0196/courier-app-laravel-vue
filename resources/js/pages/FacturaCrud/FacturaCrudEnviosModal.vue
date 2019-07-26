<template>
	<b-modal
		ref="modal"
		title="Asignar Envios"
		size="lg"
	>
		<b-row>
			<b-col>
				<!-- TABLA: DIRECCIONES  -->
				<b-table
					:items="tableItemsProvider"
					:fields="table.fields"
					:show-empty="true"
					ref="table"
					head-variant="light"
					outlined
				>
					<!-- COLUMNA: SELECCION -->
					<template
						slot="seleccion"
						slot-scope="row"
					>
						<b-checkbox @change="agregarFilaSeleccionada(row.item)" />
					</template>
				</b-table>
			</b-col>
		</b-row>

		<template slot="modal-footer">
			<!-- BOTON: ASIGNAR  -->
			<b-button
				variant="success"
				size="sm"
				@click="asignarFilasSeleccionadas()"
			>
				<i class="fa fa-save" />
				Asignar
			</b-button>

			<!-- BOTON: CANCELAR  -->
			<b-button
				variant="primary"
				size="sm"
				@click="cancel"
			>
				<i class="fa fa-ban" />
				Cancelar
			</b-button>
		</template>
	</b-modal>
</template>

<script>

import Proxy from '@/proxies/EnvioProxy';

export default {

	proxy: new Proxy(),

	data () {
		return {
			queryParams: null,
			clienteId: null,
			facturaId: null,
			table: {
				fields: [
					{ key: 'seleccion' },
					{ key: 'id' },
					{ key: 'cliente_destino.nombre' },
					{ key: 'estado' },
					{ key: 'fecha_creacion' },
					{ key: 'fecha_entrega' },
					{ key: 'tipo_envio.nombre' },
					{ key: 'precio_total' }
				],
				totalRows: 0,
			},
			selectedRows: []
		};
	},

	methods: {

		$_emitAssign () { this.$emit('assign', this.selectedRows); },

		cancel () { this.$refs.modal.hide(); },

		async tableItemsProvider (ctx) {
			if (!this.clienteId && !this.facturaId) return [];
			this.$options.proxy.setParameters({
				'cliente_id': this.clienteId,
				'factura_id': this.facturaId,
				'per_page': ctx.perPage,
				'page': ctx.currentPage
			});
			try {
				let {data, meta} = await this.$options.proxy.all();
				this.table.totalRows = meta.total;
				return data || [];
			} catch (e) {
				console.log(e);
				// this.isBusy= false;
				return [];
			}
		},

		show (clienteId, facturaId) {
			if (!clienteId && !facturaId) return;
			this.clienteId = clienteId;
			this.facturaId = facturaId;
			this.$refs.table.refresh();
			this.$refs.modal.show();
		},

		agregarFilaSeleccionada (item) {
			let index = this.selectedRows.findIndex(i => i.id == item.id);
			console.log(index);
			if (index >= 0) return this.selectedRows.splice(index, 1);
			this.selectedRows.push(item);
		},

		asignarFilasSeleccionadas () {
			this.$_emitAssign();
			this.$refs.modal.hide();
		}
	}
};
</script>
