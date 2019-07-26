<template>
	<b-modal
		ref="modal"
		title="Usuario"
	>
		<b-form>
			<b-row>
				<!-- CAMPO ID -->
				<b-col>
					<b-form-group label="Id">
						<b-form-input
							readonly
							:value="model.id"
						/>
					</b-form-group>
				</b-col>

				<!-- CAMPO FECHA CREACION -->
				<b-col>
					<b-form-group label="Fecha Creacion">
						<b-input-group>
							<b-form-input
								type="date"
								disabled
								name="fecha_creacion"
								:value="model.fecha_creacion"
							/>
							<b-input-group-append>
								<b-input-group-text><i class="fa fa-calendar" /></b-input-group-text>
							</b-input-group-append>
						</b-input-group>
					</b-form-group>
				</b-col>
			</b-row>
			<b-row>
				<b-col>
					<!-- CAMPO NOMBRE -->
					<b-form-group
						:invalid-feedback="errors.first('nombre')"
						label="Nombre"
					>
						<b-form-input
							v-model="model.nombre"
							v-validate="'required|alpha'"
							:state="errors.has('nombre') ? 'invalid' : null"
							name="nombre"
						/>
					</b-form-group>

					<!-- CAMPO EMAIL -->
					<b-form-group
						:invalid-feedback="errors.first('email')"
						label="Email"
					>
						<b-form-input
							v-model="model.email"
							v-validate="'required|email'"
							:state="errors.has('email') ? 'invalid' : null"
							name="email"
						/>
					</b-form-group>

					<!-- CAMPO ROL -->
					<b-form-group label="Rol">
						<b-form-select
							:options="roles"
							v-model="model.rol"
							name="rol"
							v-validate="'required'"
						/>
						<span
							class="invalid-feedback d-inline"
							v-text="errors.first('rol')"
						/>
					</b-form-group>
				</b-col>
			</b-row>
		</b-form>

		<!-- FOOTER  -->
		<template slot="modal-footer">
			<!-- BOTON ELIMINAR  -->
			<b-button
				variant="danger"
				size="sm"
				:disabled="!model.id"
				@click="remove()"
			>
				<i class="fa fa-trash" />
				Eliminar
			</b-button>

			<!-- BOTON GUARDAR  -->
			<b-button
				variant="success"
				size="sm"
				@click="save()"
			>
				<i class="fa fa-save" />
				Guardar
			</b-button>

			<!-- BOTON CANCELAR  -->
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
import Proxy from '@/proxies/UsuarioProxy';
import CrudModalMixin from '@/mixins/CrudModalMixin';
import { roles } from '@/common/data';

export default {

	mixins: [	CrudModalMixin],

	proxy: new Proxy(),

	data () {
		return {
			roles,
			model: {
				id: null,
				nombre: null,
				email: null,
				fecha_creacion: null,
				rol: null
			}
		};
	}
};
</script>
