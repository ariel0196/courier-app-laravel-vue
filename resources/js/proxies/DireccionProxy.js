import Proxy from './Proxy';

class DireccionProxy extends Proxy {
	constructor (parameters = {}) {
		super('direcciones', parameters);
	}
}

export default DireccionProxy;
