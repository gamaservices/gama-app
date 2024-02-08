<?php

return [
    'title' => 'Historial de actividad',

    'date_format' => 'j F, Y',
    'time_format' => 'H:i l',

    'filters' => [
        'date' => 'Fecha',
        'causer' => 'Usuario Iniciador',
        'subject_type' => 'Recurso',
        'subject_id' => 'ID de Recurso',
        'event' => 'Acción',
    ],
    'table' => [
        'field' => 'Campo',
        'old' => 'Antiguo',
        'new' => 'Nuevo',
        'value' => 'Valor',
        'no_records_yet' => 'Aún no hay entradas',
    ],
    'events' => [
        'created' => [
            'title' => 'Creado',
            'description' => 'Entrada creada',
        ],
        'updated' => [
            'title' => 'Actualizado',
            'description' => 'Entrada actualizada',
        ],
        'deleted' => [
            'title' => 'Eliminado',
            'description' => 'Entrada eliminada',
        ],
        'restored' => [
            'title' => 'Restaurado',
            'description' => 'Entrada restaurada',
        ],
        'attached' => [
            'title' => 'Adjunto',
            'description' => 'Entrada adjunta',
        ],
        'detached' => [
            'title' => 'Desvinculado',
            'description' => 'Entrada desvinculada',
        ],
    ],
    'boolean' => [
        'true' => 'Verdadero',
        'false' => 'Falso',
    ],
];

