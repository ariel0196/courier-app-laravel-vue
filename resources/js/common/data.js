const tiposCliente = [
	{ value: 'persona', text: 'Persona' },
	{ value: 'juridico', text: 'Juridico' }
];

const estadosEnvio = [
	{ value: 'pendiente', text: 'Pendiente' },
	{ value: 'recogido', text: 'Recogido' },
	{ value: 'entregado', text: 'Entregado' },
	{ value: 'facturado', text: 'Facturado' },
	{ value: 'cobrado', text: 'Cobrado' }
];

const tiposPaquete = [
	{ value: 'malotes', text: 'Malotes' },
	{ value: 'documento', text: 'Documento' },
	{ value: 'carta', text: 'Carta' },
	{ value: 'caja', text: 'Caja' }
];

const tiposPago = [
	{ value: 'efectivo', text: 'Efectivo' },
	{ value: 'cheque', text: 'Cheque' },
	{ value: 'transferencia', text: 'Transferencia' },

];
const estadosFactura = [
	{ value: 'emitida', text: 'Emitida' },
	{ value: 'cobrada', text: 'Cobrada' }
];

const roles = [
	{ value: 'operador', text: 'Operador' },
	{ value: 'administrador', text: 'Administrador' },
	{ value: 'cajero', text: 'Cajero' }
];

const datosEmpresa = {
	nombre: 'South Express Service S.R.L.',
	direccion: 'Gral. Santos 2363 e/ Rudi Torga 2420 Lambaré',
	telefono: '(021) 308-300',
	email: 'contacto@south-express.com.py',
	website: 'http://www.south-express.com.py'
};

export {
	tiposCliente,
	estadosEnvio,
	tiposPaquete,
	datosEmpresa,
	tiposPago,
	estadosFactura,
	roles
};
