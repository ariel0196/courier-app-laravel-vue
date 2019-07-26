<template>
	<div class="animated fadeIn">
		<b-row class="justify-content-center">
			<b-col>
				<b-card>
					<!-- HEADER -->
					<div slot="header">
						<i class="fa fa-bars" />
						<strong>Listado de Envíos</strong>
					</div>

					<!-- BOTON: AGREGAR -->
					<b-row>
						<b-col>
							<div class="pb-3">
								<b-button
									variant="primary"
									@click="showCreatePage()"
								>
									<i class="fa fa-plus" />
									Agregar Envio
								</b-button>
								<b-button
									:disabled="selected.length == 0"
									@click="generarFactura()"
								>
									<i class="fa fa-file-text" />
									Generar Factura
								</b-button>
							</div>
						</b-col>
					</b-row>

					<!-- CONTENEDOR: FILTROS -->
					<b-row>
						<b-col>
							<b-card header="Filtros">
								<b-row>
									<!-- CAMPO: Cliente -->
									<b-col>
										<b-form-group label="Cliente">
											<cliente-select
												@input="cliente => filtros.cliente_id = cliente ? cliente.id : null"
											/>
										</b-form-group>
									</b-col>

									<b-col>
										<!-- CAMPO: FECHA CREACION INICIAL -->
										<b-form-group label="Fecha Creacion Inicial">
											<b-input-group>
												<b-form-input
													type="date"
													v-model="filtros.fecha_creacion_inicial"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>

										<!-- CAMPO: FECHA CREACION INICIAL -->
										<b-form-group label="Fecha Creacion Final">
											<b-input-group>
												<b-form-input
													type="date"
													v-model="filtros.fecha_creacion_final"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>
									</b-col>

									<b-col>
										<!-- CAMPO: FECHA RECOGIDA INICIAL -->
										<b-form-group label="Fecha Recogida Inicial">
											<b-input-group>
												<b-form-input
													type="date"
													v-model="filtros.fecha_recogida_inicial"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>

										<!-- CAMPO: FECHA RECOGIDA INICIAL -->
										<b-form-group label="Fecha Recogida Final">
											<b-input-group>
												<b-form-input
													type="date"
													v-model="filtros.fecha_recogida_final"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>
									</b-col>

									<b-col>
										<!-- CAMPO: FECHA ENTREGA INICIAL -->
										<b-form-group label="Fecha Entrega Inicial">
											<b-input-group>
												<b-form-input
													type="date"
													v-model="filtros.fecha_entrega_inicial"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>

										<!-- CAMPO: FECHA ENTREGA INICIAL -->
										<b-form-group label="Fecha Entrega Final">
											<b-input-group>
												<b-form-input
													type="date"
													v-model="filtros.fecha_entrega_final"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>
									</b-col>

									<b-col>
										<!-- CAMPO: ESTADO -->
										<b-form-group label="Estado">
											<b-form-checkbox-group
												:options="estadosEnvio"
												@change="estados => filtros.estados = estados.join()"
												stacked
											/>
										</b-form-group>
									</b-col>
								</b-row>
							</b-card>
						</b-col>
					</b-row>

					<!-- TABLA: FACTURAS -->
					<b-row>
						<b-col>
							<b-table
								:items="tableItemsProvider"
								:fields="table.fields"
								:filter="table.filter"
								:per-page="table.perPage"
								:current-page="table.currentPage"
								ref="table"
								class="table-outline mb-3"
								head-variant="light"
								responsive
								striped
								hover
							>
								<template
									slot="seleccionar"
									slot-scope="row"
								>
									<b-form-checkbox @change="checked => addOrRemoveRow(checked, row)" />
								</template>

								<template
									slot="estado"
									slot-scope="row"
								>
									<b-badge :variant="estadoColVariant(row)">
										{{ row.item.estado }}
									</b-badge>
								</template>

								<template
									slot="facturanumero"
									slot-scope="row"
								>
									<b-link
										v-if="row.item.factura"
										:to="`/dashboard/facturas/${row.item.factura.id}/editar`"
									>
										{{ row.item.factura.numero }}
									</b-link>
									<template v-else>
										-
									</template>
								</template>

								<template
									slot="acciones"
									slot-scope="row"
								>
									<b-button
										@click="showPreviewModal(row)"
										size="sm"
										class="mr-1"
										variant="secondary"
									>
										<i class="fa fa-eye" />
										Ver Guía
									</b-button>
									<b-button
										@click="showEditPage(row)"
										size="sm"
										class="mr-1"
										variant="primary"
									>
										<i class="fa fa-edit" />
										Editar
									</b-button>
								</template>
							</b-table>
						</b-col>
					</b-row>

					<b-row>
						<!-- CAMPO: REGISTROS POR PAGINA -->
						<b-col class="col-auto mr-auto">
							<b-form-group>
								<b-form-select
									:options="[10, 15, 30]"
									v-model="table.perPage"
								/>
							</b-form-group>
						</b-col>

						<!-- CAMPO: PAGINACION -->
						<b-col class="col-auto">
							<b-pagination
								:total-rows="table.totalRows"
								:per-page="table.perPage"
								v-model="table.currentPage"
							/>
							{{ selected }}
						</b-col>
					</b-row>
				</b-card>
			</b-col>
		</b-row>

		<preview-modal ref="previewModal" />
	</div>
</template>

<script>
import Proxy from '@/proxies/EnvioProxy';
import PreviewModal from '@/components/modals/GuiaModal';
import ListPageMixin from '@/mixins/ListPageMixin';
import FacturaProxy from '@/proxies/FacturaProxy';
import { estadosEnvio } from '@/common/data';
import ClienteSelect from '@/components/selects/ClienteSelect';

const facturaProxy = new FacturaProxy();

export default {

	mixins: [ ListPageMixin ],

	components: {	PreviewModal, ClienteSelect },

	proxy: new Proxy(),

	data () {
		return {
			estadosEnvio,
			filtros: {
				cliente_id: null,
				fecha_creacion_inicial: null,
				fecha_creacion_final: null,
				fecha_entrega_inicial: null,
				fecha_entrega_final: null,
				fecha_facturacion_inicial: null,
				fecha_facturacion_final: null,
				estados: null
			},
			table: {
				fields: [
					{ key: 'seleccionar', label: '' },
					{ key: 'id', sortable: true },
					{ key: 'cliente_origen.nombre', label: "Cliente", sortable: true },
					{ key: 'cliente_destino.nombre', label: "Destinatario", sortable: true },
					{ key: 'estado', sortable: true, class: 'text-center' },
					{ key: 'fecha_creacion', label: 'F. Creacion', sortable: true, class: 'text-center' },
					{ key: 'fecha_recogida', label: 'F. Recogida', sortable: true, class: 'text-center' },
					{ key: 'fecha_entrega', label: 'F. Entrega', sortable: true, class: 'text-center' },
					{ key: 'tipo_envio.nombre', label: 'Tipo Envio', sortable: true, class: 'text-center' },
					{ key: 'facturanumero', label: "N° Factura", class: 'text-right' },
					{ key: 'precio_total', sortable: true, class: 'text-right'},
					{ key: 'acciones', class: 'text-center' }
				]
			},
			selected: []
		};
	},

	methods: {

		estadoColVariant (row) {
			return {
				'pendiente': 'danger',
				'recogido': 'warning',
				'entregado': 'secondary',
				'facturado': 'primary',
				'cobrado': 'success'
			}[row.item.estado];
		},

		showCreatePage () { this.$router.push('/dashboard/envios/crear'); },

		showEditPage (row) { this.$router.push(`/dashboard/envios/${row.item.id}/editar`);	},

		showPreviewModal (row) { this.$refs.previewModal.show(row.item.id); },

		addOrRemoveRow(checked, { item }) {
			if (!checked) return this.selected = this.selected.filter(row => row.envio_id != item.id);
			this.selected.push({
				'envio_id': item.id,
				'cliente_origen_id': item.cliente_origen_id,
				'estado': item.estado,
				'precio_total': item.precio_total
			});
		},

		async generarFactura () {

			let clienteId = this.selected[0].cliente_origen_id;
			let invalidItems = this.selected.some(envio => envio.cliente_origen_id != clienteId || !['entregado'].includes(envio.estado));
			if (invalidItems)
				return alert('Los envios seleccionados deben ser del mismo Cliente y sus estados solo pueden ser entregado');

			let montoTotal = this.selected.reduce((total, item) => total + item.precio_total, 0);

			try {

				let { data } = await facturaProxy.create({
					'cliente_id': clienteId,
					'monto_total': montoTotal,
					'envios': this.selected,
					'numero': 11
				});

				console.log(data);
				alert('Factura generada exitosamente.');
				this.$refs.table.refresh();

			} catch (e) {

				console.log(e);
			}
		}
	}
};
</script>
