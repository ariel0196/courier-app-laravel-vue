import Proxy from './Proxy';

class TipoEnvioProxy extends Proxy {
	constructor (parameters = {}) {
		super('tipos_envio', parameters);
	}
}

export default TipoEnvioProxy;
