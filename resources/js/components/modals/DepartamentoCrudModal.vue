<template>
	<b-modal
		ref="modal"
		title="Departamento"
	>
		<!-- Formulario -->
		<b-form>
			<b-row>
				<b-col>
					<!-- Input Id -->
					<b-form-group>
						<label>Id</label>
						<b-form-input
							name="id"
							readonly
							v-model="model.id"
						/>
					</b-form-group>

					<!-- Input Nombre -->
					<b-form-group :invalid-feedback="errors.first('nombre')">
						<label>Nombre</label>
						<b-form-input
							name="nombre"
							v-validate="'required|alpha_spaces'"
							:state="errors.has('nombre') ? 'invalid' : null"
							v-model="model.nombre"
						/>
					</b-form-group>

					<!-- Input Descripcion -->
					<b-form-group>
						<label>Descripcion</label>
						<b-form-input
							name="descripcion"
							v-model="model.descripcion"
						/>
					</b-form-group>
				</b-col>
			</b-row>
		</b-form>

		<!-- Botones -->
		<template slot="modal-footer">
			<b-button
				variant="danger"
				size="sm"
				:disabled="!model.id"
				@click="_remove"
			>
				<i class="fa fa-trash" /> Eliminar
			</b-button>

			<b-button
				variant="success"
				size="sm"
				@click="_save"
			>
				<i class="fa fa-save" /> Guardar
			</b-button>

			<b-button
				variant="primary"
				size="sm"
				@click="_cancel"
			>
				<i class="fa fa-ban" /> Cancelar
			</b-button>
		</template>
	</b-modal>
</template>

<script>
import Proxy from '@/proxies/DepartamentoProxy';
import CrudModalMixin from '@/mixins/CrudModalMixin';

export default {

	mixins: [ CrudModalMixin ],

	proxy: new Proxy(),

	data () {
		return {
			model: {
				id: null,
				nombre: null,
				descripcion: null
			}
		};
	}
};
</script>
