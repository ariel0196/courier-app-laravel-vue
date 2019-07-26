<template>
	<b-modal
		ref="modal"
		:title="`Factura #${model.id}`"
		size="lg"
	>
		<div
			class="p-4"
			id="pdf-content"
		>
			<b-row>
				<b-col>
					<b-img
						class="mb-4"
						height="45"
						:src="require('static/img/logo-large.png')"
					/>
					<address>
						<strong>{{ datosEmpresa.nombre }}</strong><br>
						<span>{{ datosEmpresa.direccion }}</span><br>
						Paraguay
					</address>
				</b-col>

				<b-col md="4">
					<b-card>
						<p class="card-text">
							<strong>Cliente </strong> {{ model.cliente.nombre }} <br>
							<strong>Factura #</strong> {{ model.numero }} <br>
							<strong>Fecha</strong> {{ now }} <br>
							<strong>Fecha Creación</strong> {{ model.fecha_creación }}
						</p>
					</b-card>
				</b-col>
			</b-row>

			<b-row>
				<b-col>
					<h4>Detalles</h4>
				</b-col>
			</b-row>

			<b-row>
				<b-col>
					<b-table
						responsive
						bordered
						small
						:fields="fields"
						:items="model.envios"
					/>
				</b-col>
			</b-row>

			<b-row>
				<b-col class="text-right">
					<p>
						<strong>Total </strong> {{ model.monto_total }} <br>
					</p>
				</b-col>
			</b-row>

			<hr>

			<b-row>
				<b-col class="text-center">
					<strong>Teléfono:</strong> {{ datosEmpresa.telefono }}
				</b-col>

				<b-col class="text-center">
					<strong>Email:</strong> {{ datosEmpresa.email }}
				</b-col>

				<b-col class="text-center">
					<strong>Website:</strong> {{ datosEmpresa.website }}
				</b-col>
			</b-row>
		</div>

		<template slot="modal-footer">
			<b-button
				variant="primary"
				@click="imprimir"
			>
				<i class="icon-printer" /> Descargar
			</b-button>
		</template>
	</b-modal>
</template>

<script>
import { datosEmpresa } from '@/common/data';
import Proxy from '@/proxies/FacturaProxy';
import html2pdf from 'html2pdf.js';

let proxy = new Proxy();

export default {
	data () {
		return {
			model: {
				cliente: {},
				envios: []
			},

			fields: [
				{ key: 'id', label: '# Envio' },
				{ key: 'cliente_destino.nombre', label: "Destinatario" },
				{ key: 'fecha_creacion' },
				{ key: 'fecha_entrega' },
				{ key: 'tipo_envio.nombre' },
				{ key: 'precio_total' }
			]
		};
	},
	created () {

		this.datosEmpresa = datosEmpresa;
		this.now = new Date().toISOString().slice(0, 10);
	},

	methods: {

		async show (id) {
			if (!id) return;
			let { data } = await proxy.find(id);
			this.model = data;
			this.$refs.modal.show();
		},

		imprimir () {

			html2pdf(document.getElementById('pdf-content'));
		}
	}
};
</script>
