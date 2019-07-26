import Proxy from './Proxy';

class UsuarioProxy extends Proxy {

	constructor (parameters = {}) {
		super('login', parameters);
	}

	login(data) {
		return this.submit('post', this.endpoint, data);
	}

}

export default UsuarioProxy;
