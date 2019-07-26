import Proxy from './Proxy';

class EnvioProxy extends Proxy {

	constructor (parameters = {}) {
		super('envios', parameters);
	}

	chart() {
		return this.submit('get', `${this.endpoint}/chart`);
	}
}

export default EnvioProxy;
