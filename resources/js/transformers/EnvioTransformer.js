
import Transformer from './Transformer';

export default class extends Transformer {

	static fetch (envio) {
		envio.factura = envio.factura || {};
		envio.tipo_envio = envio.tipo_envio || { nombre: null };
		envio.ciudad_origen = envio.ciudad_origen || { nombre: null };
		envio.ciudad_destino = envio.ciudad_destino || { nombre: null };
		envio.direccion_origen = envio.direccion_origen || { descripcion: null };
		envio.direccion_destino = envio.direccion_destino || { descripcion: null };
		envio.cliente_origen = envio.cliente_origen || { nombre: null };
		envio.cliente_destino = envio.cliente_destino || { nombre: null };
		return envio;
	}

	static send (envio) {
		return envio;
	}
}
