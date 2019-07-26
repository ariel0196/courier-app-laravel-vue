<template>
	<b-modal
		ref="modal"
		title="Reporte de Envios"
		size="huge"
	>
		<div
			id="pdf-content"
			class="p-2"
		>
			<b-row>
				<b-col>
					<b-img
						class="mb-4"
						height="45"
						:src="require('static/img/logo-large.png')"
					/>
				</b-col>
				<b-col>
					<address>
						<strong>{{ datosEmpresa.nombre }}</strong><br>
						<span>{{ datosEmpresa.direccion }}</span>
						<br>
						Paraguay
					</address>
				</b-col>
			</b-row>

			<b-row>
				<b-col class="text-center">
					<h5 class="mt-4">
						Reporte de Envios
					</h5>
					<hr>
				</b-col>
			</b-row>
			<b-row>
				<b-col>
					<b-table
						:fields="fields"
						:items="items"
						bordered
					/>
				</b-col>
			</b-row>
		</div>

		<template slot="modal-footer">
			<b-button
				variant="primary"
				@click="print"
			>
				<i class="icon-printer" />
				Descargar
			</b-button>
		</template>
	</b-modal>
</template>

<script>
import { datosEmpresa } from '@/common/data';
import html2pdf from 'html2pdf.js';

export default {

	data () {
		return {
			fields:  [
				{ key: 'id' },
				{ key: 'cliente_origen.nombre' },
				{ key: 'cliente_destino.nombre' },
				{ key: 'estado' },
				{ key: 'fecha_creacion' },
				{ key: 'fecha_recogida' },
				{ key: 'fecha_entrega' },
				{ key: 'tipo_envio.nombre' },
				{ key: 'factura.numero', formatter: v => v || '-' },
				{ key: 'precio_total' }
			],
			items: []
		};
	},

	created () {

		this.datosEmpresa = datosEmpresa;
		this.now = new Date().toISOString().slice(0, 10);
	},

	methods: {

		show (items) {

			this.items = items;
			this.$refs.modal.show();
		},

		print () {

			html2pdf(document.getElementById('pdf-content'));
		}
	}
};
</script>
<style>
	.modal .modal-huge {
		max-width: 1200px;
		width: 1200px;
	}
</style>
