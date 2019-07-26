<template>
	<div class="app flex-row align-items-center">
		<div class="container">
			<b-row class="justify-content-center">
				<b-col md="5">
					<b-card-group>
						<b-card
							no-body
							class="p-4"
						>
							<b-card-body>
								<!-- TITULO -->
								<b-row>
									<b-col class="text-center">
										<b-img
											class="mb-4"
											height="50"
											:src="require('static/img/logo-large.png')"
										/>
										<h4 class="text-center">
											Sistema de Gestión de Envíos
										</h4>
									</b-col>
								</b-row>

								<hr>

								<!-- TITULO -->
								<b-row>
									<b-col>
										<h4>Acceder</h4>
										<p class="text-muted">
											Accede a tu cuenta
										</p>
									</b-col>
								</b-row>

								<b-form
									@submit.prevent="acceder"
								>
									<!-- Campo Email -->
									<b-row>
										<b-col>
											<b-form-group
												class="mb-3"
												:invalid-feedback="errors.first('email')"
												:state="errors.has('email') ? 'invalid' : null"
											>
												<b-input-group>
													<b-input-group-prepend>
														<b-input-group-text>
															<i class="icon-user" />
														</b-input-group-text>
													</b-input-group-prepend>
													<b-form-input
														v-model="model.email"
														v-validate="'required|email'"
														:state="errors.has('email') ? 'invalid' : null"
														type="text"
														placeholder="Email"
														name="email"
													/>
												</b-input-group>
											</b-form-group>
										</b-col>
									</b-row>

									<!-- Campo Password -->
									<b-row>
										<b-col>
											<b-form-group
												class="mb-4"
												:invalid-feedback="errors.first('password')"
												:state="errors.has('password') ? 'invalid' : null"
											>
												<b-input-group>
													<b-input-group-prepend>
														<b-input-group-text><i class="icon-lock" /></b-input-group-text>
													</b-input-group-prepend>
													<b-form-input
														v-model="model.password"
														v-validate="'required'"
														:state="errors.has('password') ? 'invalid' : null"
														type="password"
														name="password"
														placeholder="Password"
													/>
												</b-input-group>
											</b-form-group>
										</b-col>
									</b-row>

									<!-- Boton Acceder  -->
									<b-row>
										<b-col>
											<b-button
												type="submit"
												variant="primary"
												class="px-4"
											>
												Acceder
											</b-button>
										</b-col>
									</b-row>
								</b-form>
							</b-card-body>
						</b-card>
					</b-card-group>
				</b-col>
			</b-row>
		</div>
	</div>
</template>

<script>
import Proxy from '@/proxies/AuthProxy';

let proxy = new Proxy();

export default {
	name: 'Login',

	data () {
		return {
			model: {
				email: null,
				password: null
			}
		};
	},

	beforeRouteEnter (to, from, next) {

		if (localStorage.getItem('user')) return next('/dashboard');
		next();
	},

	methods: {

		async acceder () {

			let result = await this.$validator.validateAll();
			if (!result) return console.log('Error de validacion de formulario.');

			try {

				let { user } = await proxy.login(this.model);
				console.log(user);
				if (!user) alert('Usuario o contraseña icorrectos.');
				alert('Usted ha accedido correctamente.');
				// user.rol = 'cliente';
				localStorage.setItem('user', JSON.stringify(user));
				this.$router.push(user.rol == 'cliente' ? '/dashboard/cliente' : '/dashboard');

			} catch ({ response }) {

				if (response) alert(response.data);
			}

		}
	}
};
</script>
