<?php

return [
    'plugin' => [
        'name' => 'Sugerencias',
    ],

    'index' => [
        'title' => 'Sugerencias',
    ],

    'suggestions' => [
        'title' => 'Sugerencias',
        'updated' => 'La sugerencia ha sido actualizada.',
        'deleted' => 'La sugerencia ha sido eliminada.',
        'status_updated' => 'El estado de la sugerencia ha sido actualizado.',
    ],

    'categories' => [
        'title' => 'Categorías',
        'create' => 'Crear categoría',
        'edit' => 'Editar categoría',
        'created' => 'La categoría ha sido creada.',
        'updated' => 'La categoría ha sido actualizada.',
        'deleted' => 'La categoría ha sido eliminada.',
        'delete_error' => 'No puedes eliminar una categoría que tiene sugerencias.',
    ],

    'permissions' => [
        'create' => 'Crear sugerencias',
        'delete' => 'Eliminar sugerencias',
        'edit' => 'Editar sugerencias',
        'settings' => 'Administrar configuración',
        'comments' => [
            'delete' => 'Eliminar cualquier comentario de sugerencias',
        ],
    ],

    'settings' => [
        'title' => 'Configuración',
        'max_suggestions' => 'Máximo de sugerencias por usuario',
        'max_suggestions_info' => 'Número máximo de sugerencias pendientes que un usuario puede crear (0 para ilimitado)',
        'max_description_length' => 'Longitud máxima de la descripción',
        'max_description_length_info' => 'Número máximo de caracteres para la descripción de la sugerencia (50-4000)',
        'index_title' => 'Título de la página de índice',
        'index_subtitle' => 'Subtítulo de la página de índice',
        'enable_comments' => 'Habilitar comentarios',
        'disable_category_filters' => 'Desactivar filtros por categoría',
    ],

    'discord' => [
        'title' => 'Webhook de Discord',
        'webhook_url' => 'URL del webhook de Discord',
        'webhook_url_info' => 'Introduce la URL de tu webhook de Discord. Puedes crear uno en la configuración de tu servidor en Integraciones > Webhooks.',
        'enabled' => 'Habilitado',
        'send_on_create' => 'Enviar webhook cuando se cree una sugerencia',
        'send_on_accept' => 'Enviar webhook cuando se acepte una sugerencia',
        'send_on_refuse' => 'Enviar webhook cuando se rechace una sugerencia',
        'test' => 'Probar',
        'test_success' => 'Prueba del webhook exitosa',
        'test_failed' => 'Prueba del webhook fallida',
        'how_it_works' => 'Funcionamiento:',
        'feature_list' => [
            'Se enviarán webhooks según las opciones seleccionadas',
            'Los mensajes incluyen detalles de la sugerencia, autor, estado, categoría y número de votos',
            'Se usan diferentes colores para distintas acciones (verde para nuevas, azul para aceptadas, rojo para rechazadas)',
        ],
        'customization' => 'Personalización del webhook',
        'color_created' => 'Color para nuevas',
        'color_accepted' => 'Color para aceptadas',
        'color_refused' => 'Color para rechazadas',
        'custom_templates' => 'Plantillas personalizadas',
        'template_variables_help' => 'Usa variables como {title}, {author}, {category}, {status}, {votes}, {url}, {refusal_reason}',
        'template_created' => 'Plantilla para nuevas',
        'template_accepted' => 'Plantilla para aceptadas',
        'template_refused' => 'Plantilla para rechazadas',
        'custom_username' => 'Nombre de usuario personalizado',
        'custom_avatar_url' => 'URL de avatar personalizado',
        'display_options' => 'Opciones de visualización',
        'show_author' => 'Mostrar autor',
        'show_category' => 'Mostrar categoría',
        'show_votes' => 'Mostrar votos',
        'show_description' => 'Mostrar descripción',
        'description_length' => 'Longitud de la descripción',
        'description_length_help' => 'Número máximo de caracteres para la descripción de la sugerencia (50-4000)',
    ],

    'statistics' => [
        'title' => 'Estadísticas',
        'total_suggestions' => 'Total de sugerencias',
        'pending' => 'Pendientes',
        'accepted' => 'Aceptadas',
        'refused' => 'Rechazadas',
        'total_votes' => 'Total de votos',
        'upvotes' => 'Votos positivos',
        'downvotes' => 'Votos negativos',
        'recent_activity' => 'Actividad reciente (últimos 30 días)',
        'new_suggestions' => 'Nuevas sugerencias',
        'new_votes' => 'Nuevos votos',
        'top_categories' => 'Categorías principales',
        'most_voted_suggestions' => 'Sugerencias más votadas',
        'monthly_activity' => 'Actividad mensual',
        'status_distribution' => 'Distribución por estado',
        'author' => 'Autor',
        'category' => 'Categoría',
        'status' => 'Estado',
        'net_score' => 'Puntuación neta',
        'no_categories' => 'No se encontraron categorías.',
        'no_suggestions' => 'No se encontraron sugerencias.',
        'table_title' => 'Título',
        'suggestions' => 'Sugerencias',
        'votes' => 'Votos',
        'none' => 'Ninguno',
    ],

    'logs' => [
        'suggest' => [
            'created' => 'Sugerencia creada: :title',
            'deleted' => 'Sugerencia eliminada: :title por :author',
            'edited' => 'Sugerencia editada: :title',
        ],
    ],

    'support' => 'Soporte en Discord',
    'serveurliste' => 'Listado de servidores destacados',
];
