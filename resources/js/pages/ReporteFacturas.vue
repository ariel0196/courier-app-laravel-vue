<template>
	<div class="animated fadeIn">
		<b-row class="justify-content-center">
			<b-col>
				<b-card>
					<!-- HEADER -->
					<div slot="header">
						<i class="fa fa-bars" />
						<strong>Reporte de Facturas</strong>
					</div>

					<!-- CONTENEDOR: FILTROS  -->
					<b-card>
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
							/>
						</b-col>
					</b-row>

					<b-row>
						<!-- BOTON: PAGINACION -->
						<b-col>
							<b-pagination
								:total-rows="table.totalRows"
								:per-page="table.perPage"
								v-model="table.currentPage"
							/>
						</b-col>

						<!-- BOTON: IMPRIMIR -->
						<b-col>
							<b-button
								class="pull-right"
								variant="primary"
								@click="showReporteModal()"
							>
								<i class="icon-printer" />
								Vista Previa
							</b-button>
						</b-col>
					</b-row>
				</b-card>
			</b-col>
		</b-row>

		<reporte-modal ref="reporteModal" />
	</div>
</template>

<script>
import Proxy from '@/proxies/FacturaProxy';
import ListPageMixin from '@/mixins/ListPageMixin';
import { estadosFactura } from '@/common/data';

import ClienteSelect from '@/components/selects/ClienteSelect';
import ReporteModal from './ReporteFacturas/ReporteFacturasModal';

export default {

	mixins: [ ListPageMixin ],

	components: {
		ClienteSelect,
		ReporteModal
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
					{
						key: 'numero',
						formatter: (value) => '#' + value,
						sortable: true,
						label: 'No. Factura'
					},
					{ key: 'cliente.nombre', sortable: true },
					{ key: 'estado', sortable: true },
					{ key: 'fecha_creacion', sortable: true },
					{ key: 'fecha_cobro', sortable: true },
					{ key: 'monto_total', sortable: true }
				]
			}
		};
	},

	methods: {
		showReporteModal () {	this.$refs.reporteModal.show(this.$refs.table.items);	}
	}
};
</script>
