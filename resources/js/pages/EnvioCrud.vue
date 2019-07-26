<template>
	<div class="animated fadeIn">
		<b-row class="justify-content-center">
			<b-col>
				<!-- CONTENEDOR: BOTONES DE CABECERA  -->
				<b-row>
					<b-col>
						<div class="mb-4">
							<!-- BOTON: NUEVO CLIENTE -->
							<b-button
								variant="danger"
								size="sm"
								v-if="!envioFacturado"
								@click="showClienteCrudModal()"
							>
								<i class="fa fa-plus" />
								Nuevo Cliente
							</b-button>

							<!-- BOTON: GENERAR FACTURA -->
							<b-button
								variant="primary"
								size="sm"
								:disabled="envioFacturado || enProceso"
								@click="generateFactura()"
							>
								<i class="fa fa-file-text" />
								Generar Factura
							</b-button>

							<!-- BOTON: VER FACTURA -->
							<b-button
								variant="primary"
								size="sm"
								:disabled="!envioFacturado"
								@click="showFacturaCrudPage()"
							>
								<i class="fa fa-eye" />
								Editar Factura
							</b-button>
							<!-- BOTON: VER GUIA -->
							<b-button
								@click="showGuiaModal()"
								:disabled="!model.id"
								variant="secondary"
								size="sm"
							>
								<i class="fa fa-eye" />
								Ver Guia
							</b-button>
						</div>
					</b-col>
				</b-row>

				<!-- CONTENEDOR: DATOS DEL ENVIO-->
				<b-row>
					<b-col>
						<b-card header="Datos del Envío">
							<b-row>
								<!-- CAMPO BLOQUEADO: ID -->
								<b-col md="1">
									<b-form-group label="Id">
										<b-form-input
											disabled
											:value="model.id"
										/>
									</b-form-group>
								</b-col>

								<!-- CAMPO: ESTADO -->
								<b-col>
									<b-form-group label="Estado">
										<b-form-select
											:options="estadosEnvio"
											v-model="model.estado"
											:disabled="envioFacturado"
											name="estado"
										/>
									</b-form-group>
								</b-col>

								<!-- CAMPO BLOQUEADO: FECHA CREACION -->
								<b-col>
									<b-form-group label="Fecha Creacion">
										<b-input-group>
											<b-form-input
												:value="model.fecha_creacion"
												type="date"
												disabled
											/>
											<b-input-group-append>
												<b-input-group-text>
													<i class="fa fa-calendar" />
												</b-input-group-text>
											</b-input-group-append>
										</b-input-group>
									</b-form-group>
								</b-col>

								<!-- CAMPO BLOQUEADO: FECHA ENTREGA -->
								<b-col>
									<b-form-group label="Fecha Entrega">
										<b-input-group>
											<b-form-input
												:value="model.fecha_entrega"
												name="fecha_entrega"
												type="date"
												disabled
											/>
											<b-input-group-append>
												<b-input-group-text>
													<i class="fa fa-calendar" />
												</b-input-group-text>
											</b-input-group-append>
										</b-input-group>
									</b-form-group>
								</b-col>

								<!-- CAMPO BLOQUEADO: FECHA FACTURACION -->
								<b-col>
									<b-form-group label="Fecha Facturacion">
										<b-input-group>
											<b-form-input
												type="date"
												disabled
												:value="model.factura.fecha_creacion"
												name="fecha_facturacion"
											/>
											<b-input-group-append>
												<b-input-group-text>
													<i class="fa fa-calendar" />
												</b-input-group-text>
											</b-input-group-append>
										</b-input-group>
									</b-form-group>
								</b-col>

								<!-- CAMPO BLOQUEADO: N° FACTURA -->
								<b-col>
									<b-form-group label="No. Factura">
										<b-form-input
											:value="model.factura.numero"
											disabled
										/>
									</b-form-group>
								</b-col>

								<!-- CAMPO: REPARTIDOR -->
								<b-col md="3">
									<b-form-group label="Repartidor">
										<repartidor-select
											v-model="model.repartidor"
											:disabled="envioFacturado"
										/>
										<span
											v-text="errors.first('funcionario_repartidor')"
											class="invalid-feedback d-inline"
										/>
									</b-form-group>
								</b-col>
							</b-row>
						</b-card>
					</b-col>
				</b-row>

				<!-- CONTENEDOR: DATOS DE ORIGEN -->
				<b-row>
					<b-col>
						<b-card header="Datos de Origen">
							<b-row>
								<b-col>
									<!-- CAMPO: CLIENTE ORIGEN -->
									<b-form-group label="Cliente Origen *">
										<cliente-select
											v-model="model.cliente_origen"
											name="cliente"
											v-validate="'required'"
											:disabled="envioFacturado"
										/>
										<span
											class="invalid-feedback d-inline"
											v-text="errors.first('cliente')"
										/>
									</b-form-group>

									<!-- CAMPO: CIUDAD ORIGEN -->
									<b-form-group label="Ciudad Origen *">
										<ciudad-select
											v-model="model.ciudad_origen"
											:disabled="envioFacturado"
											v-validate="'required'"
											name="ciudad_origen"
										/>
										<span
											class="invalid-feedback d-inline"
											v-text="errors.first('ciudad_origen')"
										/>
									</b-form-group>
								</b-col>
								<b-col>
									<!-- CAMPO: DIRECCION ORIGEN -->
									<b-form-group label="Direccion Origen">
										<direccion-select
											:cliente-id="this.model.cliente_origen_id"
											v-model="model.direccion_origen"
											:disabled="envioFacturado || !model.cliente_origen_id"
										/>
									</b-form-group>

									<!-- CAMPO: DIRECCION ORIGEN OPCIONAL -->
									<b-form-group label="Direccion Origen Opcional">
										<b-form-textarea
											v-model="model.direccion_origen_opc"
											:disabled="envioFacturado"
											rows="3"
										/>
									</b-form-group>
								</b-col>
							</b-row>
						</b-card>
					</b-col>

					<!-- CONTENEDOR: DATOS DE DESTINO  -->
					<b-col>
						<b-card header="Datos del Destino">
							<b-row>
								<b-col>
									<!-- CAMPO: CLIENTE DESTINO -->
									<b-form-group label="Cliente Destinatario *">
										<cliente-select
											v-model="model.cliente_destino"
											name="cliente_destino"
											v-validate="'required'"
											:disabled="envioFacturado"
										/>
										<span
											class="invalid-feedback d-inline"
											v-text="errors.first('cliente_destino')"
										/>
									</b-form-group>

									<!-- CAMPO: CIUDAD DESTINO -->
									<b-form-group label="Ciudad Destino *">
										<ciudad-select
											v-model="model.ciudad_destino"
											:disabled="envioFacturado"
											name="ciudad_destino"
											v-validate="'required'"
										/>
										<span
											class="invalid-feedback d-inline"
											v-text="errors.first('ciudad_destino')"
										/>
									</b-form-group>
								</b-col>

								<b-col>
									<!-- CAMPO: DIRECCION DESTINO  -->
									<b-form-group label="Direccion Destino">
										<direccion-select
											:cliente-id="this.model.cliente_destino_id"
											v-model="model.direccion_destino"
											:disabled="envioFacturado || !this.model.cliente_destino_id"
										/>
									</b-form-group>

									<!-- CAMPO: DIRECCION DESTINO OPCIONAL  -->
									<b-form-group label="Direccion Destino Opcional">
										<b-form-textarea
											v-model="model.direccion_destino_opc"
											:disabled="envioFacturado"
											rows="3"
										/>
									</b-form-group>
								</b-col>
							</b-row>
						</b-card>
					</b-col>
				</b-row>

				<!-- CONTENEDOR: DETALLE DEL ENVIO -->
				<b-row>
					<b-col>
						<b-card header="Detalle del Envío">
							<!-- CAMPO: TIPO DE ENVIO -->
							<b-row>
								<b-col md="2">
									<b-form-group label="Tipo Envio *">
										<tipo-envio-select
											v-model="model.tipo_envio"
											:disabled="envioFacturado"
											name="tipo_envio"
											v-validate="'required'"
										/>
										<span
											v-text="errors.first('tipo_envio')"
											class="invalid-feedback d-inline"
										/>
									</b-form-group>
								</b-col>
							</b-row>

							<!-- TABLA: PAQUETES -->
							<b-row>
								<b-col>
									<paquetes-table
										:items="model.paquetes"
										:disabled="envioFacturado"
										ref="table"
									/>
								</b-col>
							</b-row>

							<b-row>
								<!-- BOTON: AGREGAR PAQUETE -->
								<b-col md="2">
									<b-button
										@click="$refs.table.addRow()"
										:disabled="envioFacturado"
										variant="success"
									>
										<i class="fa fa-plus" />
										Agregar Paquete
									</b-button>
								</b-col>

								<!-- CAMPO: PRECIO TOTAL -->
								<b-col
									md="2"
									offset="8"
								>
									<b-form-group>
										<b-input-group append="Gs.">
											<b-form-input
												:value="model.precio_total"
												type="number"
												disabled
											/>
										</b-input-group>
									</b-form-group>
								</b-col>
							</b-row>
						</b-card>
					</b-col>
				</b-row>

				<!-- CONTENEDOR: BOTONES -->
				<b-row>
					<b-col>
						<b-row>
							<!-- BOTON: ELIMINAR -->
							<b-col>
								<b-button
									@click="remove()"
									:disabled="!model.id || envioFacturado"
									variant="danger"
									size="sm"
								>
									<i class="fa fa-trash" />
									Eliminar
								</b-button>
							</b-col>

							<b-col class="text-right">
								<div class="mb-3">
									<!-- BOTON: GUARDAR -->
									<b-button
										@click="save()"
										:disabled="envioFacturado"
										variant="success"
										size="sm"
									>
										<i class="fa fa-save" />
										Guardar
									</b-button>

									<!-- BOTON: CANCELAR -->
									<b-button
										@click="cancel()"
										variant="primary"
										size="sm"
									>
										<i class="fa fa-ban" />
										Cancelar
									</b-button>
								</div>
							</b-col>
						</b-row>
					</b-col>
				</b-row>
			</b-col>
		</b-row>
		<preview-modal ref="previewModal" />
		<cliente-crud-modal ref="clienteCrudModal" />
	</div>
</template>

<script>

import CrudPageMixin from '@/mixins/CrudPageMixin';
import EnvioTransformer from '@/transformers/EnvioTransformer';

import Proxy from '@/proxies/EnvioProxy';
import FacturaProxy from '@/proxies/FacturaProxy';

import ClienteSelect from '@/components/selects/ClienteSelect';
import CiudadSelect from '@/components/selects/CiudadSelect';
import RepartidorSelect from '@/components/selects/RepartidorSelect';
import TipoEnvioSelect from '@/components/selects/TipoEnvioSelect';
import DireccionSelect from '@/components/selects/DireccionSelect';

import ClienteCrudModal from '@/components/modals/ClienteCrudModal';
import PreviewModal from '@/components/modals/GuiaModal';

import PaquetesTable from './EnvioCrud/EnvioCrudPaquetesTable';

import { tiposPaquete, estadosEnvio as estados } from '@/common/data';

const estadosEnvio = estados.map((e) => {
	return {
		value: e.value,
		text: e.text,
		disabled: ['facturado', 'cobrado'].includes(e.value)
	};
});

const facturaProxy = new FacturaProxy();

export default {

	mixins: [ CrudPageMixin ],

	components: {
		ClienteSelect,
		CiudadSelect,
		RepartidorSelect,
		TipoEnvioSelect,
		DireccionSelect,
		ClienteCrudModal,
		PaquetesTable,
		PreviewModal
	},

	proxy: new Proxy(),

	transformer: EnvioTransformer,

	data () {
		return {
			tiposPaquete,
			estadosEnvio,
			model: {
				id: null,

				cliente_origen_id: null,
				ciudad_origen_id: null,
				direccion_origen_id: null,
				direccion_origen_opc: null,
				cliente_destino_id: null,
				cliente_destino_opc: null,
				ciudad_destino_id: null,
				direccion_destino_id: null,
				direccion_destino_opc: null,

				tipo_envio_id: null,
				repartidor_id: null,

				factura_id: null,
				peso_total_kg: null,
				precio_total: null,

				estado: 'pendiente',

				fecha_creacion: null,
				fecha_recogida: null,
				fecha_entrega: null,

				paquetes: [],

				factura: {},

				cliente_origen: null,
				ciudad_origen: null,
				direccion_origen: null,

				cliente_destino: null,
				ciudad_destino: null,
				direccion_destino: null,

				tipo_envio: null,
				repartidor: null
			}
		};
	},

	computed: {

		envioFacturado () {
			return	['facturado', 'cobrado'].includes(this.model.estado);
		},

		enProceso () {
			return ['pendiente', 'recogido'].includes(this.model.estado);
		}

	},
	methods: {

		showFacturaCrudPage () {
			this.$router.push(`/dashboard/facturas/${this.model.factura_id}/editar`);
		},

		showGuiaModal () { this.$refs.previewModal.show(this.model.id); },

		showClienteCrudModal () { this.$refs.clienteCrudModal.show(); },

		// CRITICO

		nuevoPrecioTotal () {
			let pesoTotal = 0;
			this.model.paquetes.forEach(paquete => {
				pesoTotal += parseInt(paquete.peso_kg);
			});
			// alert(pesoTotal);
			this.model.peso_total_kg = pesoTotal;
			this.model.precio_total = pesoTotal * (this.model.tipo_envio ? this.model.tipo_envio.precio_kg : 0);
		},

		async generateFactura () {
			if (! await this.$validator.validateAll()) return;

			try {

				let { data } = await facturaProxy.create({
					'cliente_id': this.model.cliente_origen_id,
					'monto_total': this.model.precio_total,
					'envios': [{ envio_id: this.model.id }],
					'numero': 11
				});

				this.model.factura = data;
				this.model.factura_id = data.id;
				this.model.estado = 'facturado';

				alert('Factura generada exitosamente.');

			} catch (e) {

				console.log(e.response.data);
			}
		}
	},

	watch: {
		// Selects
		'model.estado' (estado) {
			let date = new Date().toISOString().slice(0,10);

			if (estado == 'recogido') {
				this.model.fecha_recogida = date;
			} else if (estado == 'entregado') {
				this.model.fecha_recogida = date;
				this.model.fecha_entrega = date;
			}

		},
		'model.repartidor' (rep) { this.model.repartidor_id = rep ? rep.id : null; },
		'model.cliente_origen' (cliente) { 	this.model.cliente_origen_id = cliente ? cliente.id : null; },
		'model.ciudad_origen' (ciudad) { this.model.ciudad_origen_id = ciudad ? ciudad.id : null; },
		'model.direccion_origen' (dir) { this.model.direccion_origen_id = dir ? dir.id : null; },
		'model.cliente_destino' (cliente) { this.model.cliente_destino_id = cliente ? cliente.id : null; },
		'model.ciudad_destino' (ciudad) { this.model.ciudad_destino_id = ciudad ? ciudad.id : null; },
		'model.direccion_destino' (dir) { this.model.direccion_destino_id = dir ? dir.id : null; },
		'model.tipo_envio' (te) {
			this.model.tipo_envio_id = te ? te.id : null;
			this.nuevoPrecioTotal();
		},
		// End Selects
		'model.paquetes': {
			handler () {
				this.nuevoPrecioTotal();
			},
			deep: true
		}
	}
};
</script>
