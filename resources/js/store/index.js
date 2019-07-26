const config = {

	state: {
		showModal: false,
		text: 'text del store'
	},

	getters: {
		textUpperCase (state) {
			return state.text.toUpperCase();
		}
	},

	mutations: {
		openModal (state) {
			state.showModal = true;
		},
		closeModal (state) {
			state.showModal = false;
		},
		changeText (state, payload) {
			state.text = payload;
		}
	},

	actions: {
		changeTextAsync ({ commit }) {
			setTimeout(() => {
				commit('changeText', 'lorem');
			}, 1000);
		}
	}
};

export default config;
