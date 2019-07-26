import Proxy from './Proxy';

class RolProxy extends Proxy {

	constructor (parameters = {}) {
		super('roles', parameters);
	}
}

export default RolProxy;
