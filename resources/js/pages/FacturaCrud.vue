<template>
	<div class="animated fadeIn">
		<b-row>
			<b-col>
				<!-- BOTON: IMPRIMIR -->
				<b-row>
					<b-col>
						<div class="mb-3">
							<b-button
								@click="showPreviewModal()"
								variant="secondary"
								size="sm"
							>
								<i class="fa fa-save" />
								Imprimir
							</b-button>
						</div>
					</b-col>
				</b-row>

				<b-row>
					<!-- CONTENEDOR: DATOS DE FACTURA -->
					<b-col md="3">
						<b-card>
							<!-- CAMPO: ID -->
							<b-row>
								<b-col>
									<b-form-group label="Id">
										<b-form-input
											v-model="model.id"
											name="id"
											disabled
										/>
									</b-form-group>
								</b-col>
							</b-row>

							<!-- CAMPO: CLIENTE -->
							<b-row>
								<b-col>
									<b-form-group label="Cliente">
										<cliente-select
											:value="model.cliente"
											name="cliente"
											disabled
										/>
									</b-form-group>
								</b-col>
							</b-row>

							<!-- CAMPO: TIPO DE PAGO -->
							<b-row>
								<b-col>
									<b-form-group label="Tipo Pago">
										<b-form-select
											:options="tiposPago"
											v-model="model.tipo_pago"
											:disabled="facturaCobrada"
											name="tipo_pago"
											v-validate="'required'"
										/>
										<span
											class="invalid-feedback"
											style="display: inline"
											v-text="errors.first('tipo_pago')"
										/>
									</b-form-group>
								</b-col>
							</b-row>
						</b-card>
					</b-col>
					<b-col>
						<b-row>
							<b-col>
								<b-card>
									<b-row>
										<!-- CAMPO: ESTADO -->
										<b-col>
											<b-form-group label="Estado">
												<b-form-select
													:options="estadosFactura"
													v-model="model.estado"
													:disabled="facturaCobrada"
													name="estado"
												/>
											</b-form-group>
										</b-col>

										<!-- CAMPO BLOQUEADO: FECHA CREACION -->
										<b-col>
											<b-form-group label="Fecha Creacion">
												<b-input-group>
													<b-form-input
														v-model="model.fecha_creacion"
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

										<!-- CAMPO BLOQUEADO: FECHA Cobro -->
										<b-col>
											<b-form-group label="Fecha Cobro">
												<b-input-group>
													<b-form-input
														v-model="model.fecha_cobro"
														name="fecha_cobro"
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
									</b-row>
								</b-card>
							</b-col>
						</b-row>
						<b-row>
							<b-col>
								<b-card>
									<!-- TABLA: ENVIOS -->
									<b-row>
										<b-col>
											<envios-table
												:items="model.envios"
												:disabled="facturaCobrada"
											/>
										</b-col>
									</b-row>

									<b-row>
										<!-- BOTON: ENVIO -->
										<b-col>
											<b-button
												@click="showEnviosModal()"
												:disabled="facturaCobrada"
												variant="success"
											>
												<i class="fa fa-save" />
												Asignar Envios
											</b-button>
										</b-col>

										<!-- CAMPO BLOQUEADO: MONTO TOTAL -->
										<b-col
											md="2"
										>
											<b-input-group append="Gs.">
												<b-form-input
													:value="model.monto_total"
													name="monto_total"
													type="number"
													disabled
												/>
											</b-input-group>
										</b-col>
									</b-row>
								</b-card>
							</b-col>
						</b-row>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<div class="mb-3 text-align-right">
							<!-- BUTTON: GUARDAR -->
							<b-button
								@click="saveParent()"
								:disabled="facturaCobrada"
								variant="success"
								size="sm"
							>
								<i class="fa fa-save" />
								Guardar
							</b-button>

							<!-- BUTTON: CANCELAR -->
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

		<preview-modal ref="previewModal" />
		<envios-modal
			ref="enviosModal"
			@assign="asignarEnvios"
		/>
	</div>
</template>

<script>
import CrudPageMixin from '@/mixins/CrudPageMixin';
import Proxy from '@/proxies/FacturaProxy';
import { estadosFactura, tiposPago } from '@/common/data';

import ClienteSelect from '@/components/selects/ClienteSelect';
import EnviosTable from './FacturaCrud/FacturaCrudEnviosTable';
import EnviosModal from './FacturaCrud/FacturaCrudEnviosModal';
import PreviewModal from '@/components/modals/FacturaModal';

export default {

	mixins: [ CrudPageMixin ],

	components: {
		ClienteSelect,
		EnviosTable,
		EnviosModal,
		PreviewModal
	},

	proxy: new Proxy(),

	data () {
		return {
			facturaCobrada: false,
			estadosFactura,
			tiposPago,
			model: {
				id: null,
				numero: null,
				cliente_id: null,
				tipo_pago: null,
				monto_total: null,
				estado: null,
				fecha_creacion: null,
				fecha_pago: null,
				envios: []
			}
		};
	},

	async created () {
		try {
			await this.$_fetch(this.$route.params.id);
			this.facturaCobrada = this.model.estado === 'cobrada';
		} catch (e) {
			alert('Error al obtener el registro');
		}
	},

	methods: {
		showPreviewModal () { this.$refs.previewModal.show(this.model.id); },

		showEnviosModal () {
			this.$refs.enviosModal.show(this.model.cliente_id, this.model.id);
		},

		asignarEnvios (envios) {
			console.log(envios);
			envios.forEach(e => this.model.envios.push(e));
		},

		async saveParent() {
			await this.save();
			this.facturaCobrada = this.model.estado === 'cobrada';
		}
	},

	watch: {
		'model.estado' (estado) {
			let date = new Date().toISOString().slice(0,10);

			if (estado == 'cobrada') {
				this.model.fecha_cobro = date;
			}

		},
	}
};
</script>
