<template>
	<div class="animated fadeIn">
		<b-row class="justify-content-center">
			<b-col>
				<b-card>
					<!-- HEADER -->
					<div slot="header">
						<i class="fa fa-bars" />
						<strong>Listado de Facturas</strong>
					</div>

					<!-- CONTENEDOR: FILTROS  -->
					<b-row>
						<b-col>
							<b-card header="Filtros">
								<b-row>
									<!-- CAMPO: CLIENTE -->
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
													v-model="filtros.fecha_creacion_inicial"
													type="date"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>

										<!-- CAMPO: FECHA CREACION FINAL -->
										<b-form-group label="Fecha Creacion Final">
											<b-input-group>
												<b-form-input
													v-model="filtros.fecha_creacion_final"
													type="date"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>
									</b-col>

									<b-col>
										<!-- CAMPO: FECHA CREACION FINAL -->
										<b-form-group label="Fecha Pago Inicial">
											<b-input-group>
												<b-form-input
													v-model="filtros.fecha_cobro_inicial"
													type="date"
												/>
												<b-input-group-append>
													<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
												</b-input-group-append>
											</b-input-group>
										</b-form-group>

										<!-- CAMPO: FECHA CREACION FINAL-->
										<b-form-group label="Fecha Pago Final">
											<b-input-group>
												<b-form-input
													v-model="filtros.fecha_cobro_final"
													type="date"
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
												:options="estadosFactura"
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
								:per-page="table.perPage"
								:current-page="table.currentPage"
								ref="table"
								class="table-outline mb-3"
								head-variant="light"
								responsive
								striped
								hover
							>
								<!-- COLUMNA: ESTADO -->
								<template
									slot="estado"
									slot-scope="row"
								>
									<b-badge :variant="estadoColVariant(row)">
										{{ row.item.estado }}
									</b-badge>
								</template>

								<!-- COLUMNA: ACCIONES -->
								<template
									slot="acciones"
									slot-scope="row"
								>
									<!-- BOTON: IMPRIMIR -->
									<b-button
										@click="showPreviewModal(row)"
										variant="secondary"
										size="sm"
										class="mr-1"
									>
										<i class="fa fa-eye" />
										Ver Factura
									</b-button>

									<!-- BOTON: EDITAR -->
									<b-button
										@click="showEditPage(row)"
										variant="primary"
										size="sm"
										class="mr-1"
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
						</b-col>
					</b-row>
				</b-card>
			</b-col>
		</b-row>

		<preview-modal ref="previewModal" />
	</div>
</template>

<script>
import Proxy from '@/proxies/FacturaProxy';
import PreviewModal from '@/components/modals/FacturaModal';
import ListPageMixin from '@/mixins/ListPageMixin';
import ClienteSelect from '@/components/selects/ClienteSelect';
import { estadosFactura } from '@/common/data';

export default {

	mixins: [ ListPageMixin ],

	components: {
		PreviewModal,
		ClienteSelect
	},

	proxy: new Proxy(),

	data () {
		return {
			estadosFactura,
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
					{ key: 'id', sortable: true },
					{ key: 'numero', label: 'No. Factura', sortable: true, class: 'text-center' },
					{ key: 'cliente.nombre', sortable: true },
					{ key: 'estado', sortable: true },
					{ key: 'fecha_creacion', sortable: true, class: 'text-center' },
					{ key: 'fecha_cobro', sortable: true, class: 'text-center' },
					{ key: 'tipo_pago', sortable: true, class: 'text-center' },
					{ key: 'monto_total', sortable: true, class: 'text-right', },
					{ key: 'acciones', class: 'text-center' }
				]
			}
		};
	},

	methods: {

		estadoColVariant: ({ item }) => item.estado === 'emitida' ? 'danger' : 'success',

		showCreatePage () { this.$router.push('/dashboard/facturas/crear'); },

		showEditPage (row) { this.$router.push(`/dashboard/facturas/${row.item.id}/editar`);	},

		showPreviewModal (row) { this.$refs.previewModal.show(row.item.id); },
	}
};
</script>
