<template>
	<div class="animated fadeIn">
		<b-row class="justify-content-center">
			<b-col>
				<b-card>
					<!-- HEADER -->
					<div slot="header">
						<i class="fa fa-bars" />
						<strong>Reporte de Envios</strong>
					</div>


					<!-- FILTROS  -->
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

					<!-- TABLA: ENVIOS -->
					<b-row>
						<b-col>
							<b-table
								:items="tableItemsProvider"
								:fields="table.fields"
								:per-page="table.perPage"
								:current-page="table.currentPage"
								:show-empty="true"
								ref="table"
								class="table-outline mb-3"
								head-variant="light"
								responsive
								striped
								hover
							>
								<template
									slot="factura.numero"
									slot-scope="row"
								>
									<b-link
										v-if="row.item.factura"
										:to="`facturas/${row.item.factura.id}/editar`"
									>
										{{ row.item.factura.numero }}
									</b-link>
									<template v-else>
										-
									</template>
								</template>
							</b-table>
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

						<!-- BOTON VISTA PREVIA -->
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
import Proxy from '@/proxies/EnvioProxy';
import ListPageMixin from '@/mixins/ListPageMixin';
import { estadosEnvio } from '@/common/data';

import ReporteModal from './ReporteEnvios/ReporteEnviosModal';
import ClienteSelect from '@/components/selects/ClienteSelect';

export default {

	mixins: [ ListPageMixin ],

	components: {
		ClienteSelect,
		ReporteModal
	},

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
					{ key: 'id', sortable: true },
					{ key: 'cliente_origen.nombre', sortable: true },
					{ key: 'cliente_destino.nombre', sortable: true },
					{ key: 'estado', sortable: true },
					{ key: 'fecha_creacion', sortable: true, class: "text-center" },
					{ key: 'fecha_recogida', sortable: true, class: "text-center" },
					{ key: 'fecha_entrega', sortable: true, class: "text-center" },
					{ key: 'tipo_envio.nombre', sortable: true, class: "text-center" },
					{ key: 'factura.numero', class: "text-center" },
					{ key: 'precio_total', sortable: true }
				]
			}
		};
	},

	methods: {
		showReporteModal () { this.$refs.reporteModal.show(this.$refs.table.items); }
	}
};
</script>
