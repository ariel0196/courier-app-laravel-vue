<template>
	<div class="animated fadeIn">
		<b-row class="justify-content-center">
			<b-col>
				<b-card>
					<!-- HEADER -->
					<div slot="header">
						<i class="fa fa-bars" />
						<strong>Listado de Ciudades</strong>
					</div>

					<!-- BOTON: AGREGAR CIUDAD -->
					<b-row>
						<b-col>
							<div class="pb-3">
								<b-button
									variant="primary"
									@click="showCrudModal()"
								>
									<i class="fa fa-plus" />
									Agregar Ciudad
								</b-button>
							</div>
						</b-col>
					</b-row>

					<b-row>
						<!-- TABLA: CIUDADES -->
						<b-col md="10">
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
								<template
									slot="acciones"
									slot-scope="row"
								>
									<b-button
										size="sm"
										class="mr-1"
										variant="primary"
										@click="showCrudModal(row)"
									>
										<i class="fa fa-edit" /> Editar
									</b-button>
								</template>
							</b-table>
						</b-col>

						<!-- FILTROS  -->
						<b-col>
							<b-card header="Filtros">
								<b-row>
									<b-col>
										<!-- CAMPO: NOMBRE -->
										<b-form-group label="Nombre">
											<b-form-input v-model="filtros.nombre" />
										</b-form-group>
									</b-col>
								</b-row>
							</b-card>
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

		<!-- MODAL: CRUD CIUDAD -->
		<crud-modal
			ref="crudModal"
			@remove="refreshTable()"
			@save="refreshTable()"
		/>
	</div>
</template>

<script>
import CrudModal from '@/components/modals/CiudadCrudModal';
import Proxy from '@/proxies/CiudadProxy';
import ListPageMixin from '@/mixins/ListPageMixin';

export default {

	mixins: [ ListPageMixin ],

	components: { CrudModal },

	proxy: new Proxy(),

	data () {
		return {
			filtros: { nombre: null },
			table: {
				fields: [
					{ key: 'id', sortable: true },
					{ key: 'nombre', sortable: true },
					{ key: 'departamento.nombre', sortable: true },
					{ key: 'descripcion', sortable: true },
					{ key: 'acciones', class: 'text-center' }
				]
			}
		};
	}
};
</script>
