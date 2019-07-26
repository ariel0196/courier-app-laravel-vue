<?php

return [
    'estados_envio' => [
        'pendiente',
        'recogido',
        'entregado',
        'facturado',
        'cobrado'
    ],
    'tipos_cliente' => [
        'persona',
        'juridico'
    ],
    'tipos_pago' => [
        'efectivo',
        'cheque',
        'transferencia'
    ],
    'tipos_paquete' => [
        'malotes',
        'documento',
        'caja',
        'carta'
    ],
    'estados_factura' => [
        'emitida',
        'cobrada'
    ],
    'roles' => [
        'operador',
        'administrador',
				'cajero',
				'cliente'
    ]
];
