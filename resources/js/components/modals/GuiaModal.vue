<template>
	<b-modal
		ref="modal"
		:title="`Envio #${model.id}`"
		size="lg"
	>
		<div
			class="p-4"
			id="pdf-content"
		>
			<b-row>
				<b-col>
					<!-- <img
						height="45"
						src="~static/img/logo-large.png" alt=""
					> -->
					<b-img
						class="mb-4"
						height="45"
						:src="require('static/img/logo-large.png')"
					/>
					<address>
						<strong>{{ datosEmpresa.nombre }}</strong>
						<br>
						<span>{{ datosEmpresa.direccion }}</span>
						<br>
						Paraguay
					</address>
				</b-col>

				<b-col md="4">
					<b-card>
						<p class="card-text">
							<strong>Envio</strong> {{ '#' + model.id }}
							<br>
							<strong>Fecha</strong> {{ now }}
							<br>
							<strong>Fecha Creacion</strong> {{ model.fecha_creacion }}
						</p>
					</b-card>
				</b-col>
			</b-row>

			<b-row>
				<b-col md="8">
					<b-card title="Datos del Envio">
						<p class="card-text">
							<strong>Envio</strong> {{ '#' + model.id }}<br>
							<strong>Cliente</strong> {{ model.cliente_origen.nombre }}<br>
							<strong>Destinatario</strong> {{ model.cliente_destino.nombre }}<br>
							<strong>Origen</strong> {{ model.direccion_origen.descripcion }}<br>
							<strong>Destino</strong> {{ model.direccion_destino.descripcion }}<br>
							<strong>Descripcion Origen</strong> {{ model.direccion_origen_opc || '-' }}<br>
							<strong>Descripcion Destino</strong> {{ model.direccion_destino_opc || '-' }}<br>
						</p>
					</b-card>
				</b-col>
				<b-col>
					<b-card title="Detalles">
						<p class="card-text">
							<strong>Tipo Envio</strong> {{ model.tipo_envio.nombre }}<br>
							<strong>Peso total</strong> {{ model.peso_total_kg }}<br>
						</p>
					</b-card>
				</b-col>
			</b-row>

			<b-row>
				<b-col>
					<p>
						<strong>Firma Destinatario </strong>
						<b-input />
					</p>
				</b-col>
				<b-col>
					<p>
						<strong>Aclaracion </strong>
						<b-input />
					</p>
				</b-col>
			</b-row>

			<hr>

			<b-row>
				<b-col>
					<strong>Teléfono: </strong> {{ datosEmpresa.telefono }}
					<br>
					<strong>Email: </strong> {{ datosEmpresa.email }}
				</b-col>


				<b-col>
					<strong>Website: </strong> {{ datosEmpresa.website }}
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
import { datosEmpresa } from '@/common/data.js';
import Proxy from '@/proxies/EnvioProxy';
import html2pdf from 'html2pdf.js';

const proxy = new Proxy();

export default {
	created () {
		this.now = new Date().toISOString().slice(0, 10);
	},

	data () {
		return {
			datosEmpresa,
			model: {
				cliente_origen: {},
				direccion_origen: {},
				cliente_destino: {},
				direccion_destino: {},
				tipo_envio: {}
			}
		};
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
