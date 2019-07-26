<template>
	<b-modal
		ref="modal"
		title="Tipo de Envio"
	>
		<!-- Formulario -->
		<b-form>
			<b-row>
				<b-col>
					<!-- CAMPO ID  -->
					<b-form-group label="Id">
						<b-form-input
							v-model="model.id"
							name="id"
							readonly
						/>
					</b-form-group>

					<!-- CAMPO NOMBRE -->
					<b-form-group
						:invalid-feedback="errors.first('nombre')"
						label="Nombre"
					>
						<b-form-input
							v-model="model.nombre"
							v-validate="'required|alpha_spaces'"
							:state="errors.has('nombre') ? 'invalid' : null"
							name="nombre"
						/>
					</b-form-group>

					<!-- CAMPO DESCRIPCION -->
					<b-form-group label="Descripcion">
						<b-form-input
							v-model="model.descripcion"
							name="descripcion"
						/>
					</b-form-group>

					<!-- CAMPO PRECIO -->
					<b-form-group
						:invalid-feedback="errors.first('precio_kg')"
						label="Precio"
					>
						<b-form-input
							v-model="model.precio_kg"
							v-validate="'required|numeric'"
							:state="errors.has('precio_kg') ? 'invalid' : null"
							name="precio_kg"
							type="number"
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
				@click="remove()"
			>
				<i class="fa fa-trash" />
				Eliminar
			</b-button>

			<b-button
				variant="success"
				size="sm"
				@click="save()"
			>
				<i class="fa fa-save" />
				Guardar
			</b-button>

			<b-button
				variant="primary"
				size="sm"
				@click="cancel()"
			>
				<i class="fa fa-ban" />
				Cancelar
			</b-button>
		</template>
	</b-modal>
</template>

<script>
import Proxy from '@/proxies/TipoEnvioProxy';
import CrudModalMixin from '@/mixins/CrudModalMixin';

export default {

	mixins: [ CrudModalMixin ],

	proxy: new Proxy(),

	data () {
		return {
			model: {
				id: null,
				nombre: null,
				descripcion: null,
				precio_kg: null
			}
		};
	}
};
</script>
