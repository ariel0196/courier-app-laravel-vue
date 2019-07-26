import Proxy from './Proxy';

class UsuarioProxy extends Proxy {

	constructor (parameters = {}) {
		super('usuarios', parameters);
	}

}

export default UsuarioProxy;
