<template>
	<b-modal
		ref="modal"
		title="Cliente"
		size="lg"
	>
		<!-- Formulario -->
		<b-form>
			<b-row>
				<!-- Id -->
				<b-col>
					<b-form-group label="Id">
						<b-form-input
							name="id"
							readonly
							v-model="model.id"
						/>
					</b-form-group>
				</b-col>

				<!-- Tipo -->
				<b-col>
					<b-form-group
						label="Tipo de Cliente *"
						:invalid-feedback="errors.first('tipo')"
					>
						<b-form-select
							name="tipo"
							v-validate="'required'"
							:state="errors.has('tipo') ? 'invalid' : null"
							:options="tiposCliente"
							v-model="model.tipo"
						/>
					</b-form-group>
				</b-col>

				<!-- Documento -->
				<b-col>
					<b-form-group>
						<label>Documento/RUC *</label>
						<b-form-input
							name="documento"
							placeholder="0000000-0"
							v-model="model.documento"
						/>
					</b-form-group>
				</b-col>

				<!-- Mayorista  -->
				<b-col>
					<b-form-checkbox v-model="model.mayorista">
						Cliente Mayorista
					</b-form-checkbox>
				</b-col>
			</b-row>

			<b-row>
				<!-- Nombre -->
				<b-col>
					<b-form-group
						label="Nombre *"
						:invalid-feedback="errors.first('nombre')"
					>
						<b-form-input
							name="nombre"
							v-validate="'required|alpha_spaces'"
							:state="errors.has('nombre') ? 'invalid' : null"
							v-model="model.nombre"
						/>
					</b-form-group>
				</b-col>

				<!-- Email-->
				<b-col>
					<b-form-group label="E-mail">
						<b-form-input
							name="email"
							placeholder="email@dominio.com"
							v-model="model.email"
						/>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<!-- Celular-->
				<b-col>
					<b-form-group label="Celular">
						<b-form-input
							name="celular"
							placeholder="0000-000-000"
							v-model="model.celular"
						/>
					</b-form-group>
				</b-col>

				<!-- Teléfono-->
				<b-col>
					<b-form-group label="Telefono">
						<b-form-input
							name="telefono"
							placeholder="000-000-000"
							v-model="model.telefono"
						/>
					</b-form-group>
				</b-col>
			</b-row>
		</b-form>


		<!-- Direcciones -->
		<b-row>
			<b-col>
				<b-form-group label="Direcciones">
					<direcciones-table :items="model.direcciones" />
				</b-form-group>
			</b-col>
		</b-row>

		<!-- Botones -->
		<template slot="modal-footer">
			<b-button
				variant="danger"
				size="sm"
				:disabled="!model.id"
				@click="remove"
			>
				<i class="fa fa-trash" /> Eliminar
			</b-button>

			<b-button
				variant="success"
				size="sm"
				@click="save"
			>
				<i class="fa fa-save" /> Guardar
			</b-button>

			<b-button
				variant="primary"
				size="sm"
				@click="cancel"
			>
				<i class="fa fa-ban" /> Cancelar
			</b-button>
		</template>
	</b-modal>
</template>

<script>
import CrudModalMixin from '@/mixins/CrudModalMixin';
import Proxy from '@/proxies/ClienteProxy';
import { tiposCliente } from '@/common/data';
import DireccionesTable from './ClienteCrudModal/DireccionesTable';

export default {

	components: { DireccionesTable },

	mixins: [ CrudModalMixin ],

	proxy: new Proxy(),

	mounted () {
		this.$refs.modal.$on('hide', () => {
			this.reset();
			this.model.direcciones = [];
		});
	},

	data () {
		return {
			tiposCliente,
			model: {
				id: null,
				tipo: null,
				documento: null,
				nombre: null,
				email: null,
				celular: null,
				telefono: null,
				direcciones: [],
				mayorista: null
			},
		};
	}
};
</script>
