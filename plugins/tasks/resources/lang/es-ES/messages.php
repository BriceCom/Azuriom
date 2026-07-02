<?php

return [
    'title' => 'Tareas',

    'actions' => [
        'create' => 'Crear Tarea',
        'edit' => 'Editar Tarea',
        'delete' => 'Eliminar Tarea',
        'view' => 'Ver Tarea',
        'filter' => 'Filtrar Tareas',
        'clear_filter' => 'Limpiar Filtros',
        'add_checklist' => 'Añadir Elemento de Lista de Verificación',
        'add_assignee' => 'Añadir Responsable',
        'remove_assignee' => 'Eliminar Responsable',
        'add_comment' => 'Añadir Comentario',
        'edit_comment' => 'Editar Comentario',
        'delete_comment' => 'Eliminar Comentario',
        'select' => 'Seleccionar',
        'confirm_deletion' => 'Confirmar eliminación',
        'confirm_delete' => '¿Estás seguro de que quieres eliminar :item?',
        'irreversible' => 'Esta acción es irreversible.'
    ],

    'fields' => [
        'title' => 'Título',
        'description' => 'Descripción',
        'status' => 'Estado',
        'author' => 'Autor',
        'assignees' => 'Responsables',
        'tags' => 'Etiquetas',
        'started_at' => 'Fecha de Inicio',
        'limited_at' => 'Fecha de Vencimiento',
        'created_at' => 'Creado El',
        'updated_at' => 'Actualizado El',
        'visibility' => 'Visibilidad',
        'related_tasks' => 'Tareas Relacionadas',
        'checklist' => 'Lista de Verificación',
        'comments' => 'Comentarios',
        'content' => 'Contenido',
        'informations' => 'Información',
    ],

    'status' => [
        'pending' => 'Pendiente',
        'in_progress' => 'En Progreso',
        'completed' => 'Completada',
        'cancelled' => 'Cancelada',
    ],

    'visibility' => [
        'private' => 'Privada (solo autor y responsables)',
        'public' => 'Pública (todos los usuarios)',
        'role' => 'Basada en Roles (roles específicos)',
    ],

    'info' => [
        'no_tasks' => 'No se encontraron tareas.',
        'no_checklist' => 'No hay elementos en la lista de verificación para esta tarea.',
        'no_assignees' => 'No hay responsables para esta tarea.',
        'no_related_tasks' => 'No hay tareas relacionadas.',
        'no_comments' => 'No hay comentarios para esta tarea.',
        'overdue' => 'Atrasada',
        'due_soon' => 'Próxima a vencer',
        'completion' => ':percent% completada',
    ],

    'created' => 'Tarea creada correctamente.',
    'updated' => 'Tarea actualizada correctamente.',
    'deleted' => 'Tarea eliminada correctamente.',
    'archived' => 'Tarea archivada correctamente.',
    'restored' => 'Tarea restaurada correctamente.',
    'force_deleted' => 'Tarea eliminada permanentemente.',

    'checklist' => [
        'created' => 'Elemento de lista de verificación añadido correctamente.',
        'updated' => 'Elemento de lista de verificación actualizado correctamente.',
        'deleted' => 'Elemento de lista de verificación eliminado correctamente.',
        'completed' => 'Elemento marcado como completado.',
        'uncompleted' => 'Elemento marcado como no completado.',
    ],

    'assignee' => [
        'added' => 'Responsable añadido correctamente.',
        'removed' => 'Responsable eliminado correctamente.',
        'already_assigned' => 'El usuario ya está asignado a esta tarea.',
    ],

    'comment' => [
        'created' => 'Comentario añadido correctamente.',
        'updated' => 'Comentario actualizado correctamente.',
        'deleted' => 'Comentario eliminado correctamente.',
    ],

    'by' => 'por :name',

    'validation' => [
        'title' => [
            'required' => 'El título de la tarea es obligatorio.',
        ],
        'description' => [
            'required' => 'La descripción de la tarea es obligatoria.',
        ],
        'status' => [
            'required' => 'El estado de la tarea es obligatorio.',
            'exists' => 'El estado seleccionado no existe.',
            'name' => [
                'required' => 'El nombre del estado es obligatorio.',
                'max' => 'El nombre del estado no debe superar los :max caracteres.',
            ],
        ],
        'limited_at' => [
            'after_or_equal' => 'La fecha de vencimiento debe ser igual o posterior a la fecha de inicio.',
        ],
        'tags' => [
            'exists' => 'Una o más etiquetas seleccionadas no existen.',
        ],
        'assignees' => [
            'exists' => 'Uno o más responsables seleccionados no existen.',
        ],
        'visibility_roles' => [
            'exists' => 'Uno o más roles seleccionados no existen.',
        ],
        'related_tasks' => [
            'exists' => 'Una o más tareas relacionadas seleccionadas no existen.',
            'different' => 'Una tarea no puede estar relacionada consigo misma.',
        ],
        'checklist' => [
            'title' => [
                'required' => 'El título del elemento de la lista de verificación es obligatorio.',
                'max' => 'El título del elemento no debe superar los :max caracteres.',
            ],
        ],
        'tag' => [
            'name' => [
                'required' => 'El nombre de la etiqueta es obligatorio.',
                'max' => 'El nombre de la etiqueta no debe superar los :max caracteres.',
            ],
            'color' => [
                'required' => 'El color de la etiqueta es obligatorio.',
                'format' => 'El color de la etiqueta debe ser un código HEX válido.',
            ],
        ],
        'assignee' => [
            'user_id' => [
                'required' => 'El ID de usuario es obligatorio.',
                'exists' => 'El usuario seleccionado no existe.',
            ],
        ],
        'visibility' => [
            'role_id' => [
                'required' => 'El ID del rol es obligatorio.',
                'exists' => 'El rol seleccionado no existe.',
            ],
        ],
        'related_task' => [
            'id' => [
                'required' => 'El ID de la tarea relacionada es obligatorio.',
                'exists' => 'La tarea relacionada seleccionada no existe.',
                'different' => 'Una tarea no puede estar relacionada consigo misma.',
            ],
        ],
        'comment' => [
            'content' => [
                'required' => 'El contenido del comentario es obligatorio.',
            ],
        ],
    ],
];
