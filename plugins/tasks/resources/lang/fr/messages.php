<?php

return [
    'title' => 'Tâches',

    'actions' => [
        'create' => 'Créer une tâche',
        'edit' => 'Modifier une tâche',
        'delete' => 'Supprimer une tâche',
        'view' => 'Voir la tâche',
        'filter' => 'Filtrer les tâches',
        'clear_filter' => 'Réinitialiser les filtres',
        'add_checklist' => 'Ajouter un élément à la checklist',
        'add_assignee' => 'Ajouter un assigné',
        'remove_assignee' => 'Retirer un assigné',
        'add_comment' => 'Ajouter un commentaire',
        'edit_comment' => 'Modifier un commentaire',
        'delete_comment' => 'Supprimer un commentaire',
        'select' => 'Sélectionner',
        'confirm_deletion' => 'Confirmer la suppression',
        'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer :item ?',
        'irreversible' => 'Cette action est irréversible.',
    ],

    'fields' => [
        'title' => 'Titre',
        'description' => 'Description',
        'status' => 'Statut',
        'author' => 'Auteur',
        'assignees' => 'Assignés',
        'tags' => 'Étiquettes',
        'started_at' => 'Date de début',
        'limited_at' => 'Date limite',
        'created_at' => 'Créée le',
        'updated_at' => 'Mise à jour le',
        'visibility' => 'Visibilité',
        'related_tasks' => 'Tâches liées',
        'checklist' => 'Checklist',
        'comments' => 'Commentaires',
        'content' => 'Contenu',
        'informations' => 'Informations',
    ],

    'status' => [
        'pending' => 'En attente',
        'in_progress' => 'En cours',
        'completed' => 'Terminée',
        'cancelled' => 'Annulée',
    ],

    'visibility' => [
        'private' => 'Privée (seulement l’auteur et les assignés)',
        'public' => 'Publique (tous les utilisateurs)',
        'role' => 'Basée sur les rôles (rôles spécifiques)',
    ],

    'info' => [
        'no_tasks' => 'Aucune tâche trouvée.',
        'no_checklist' => 'Aucun élément de checklist pour cette tâche.',
        'no_assignees' => 'Aucun assigné pour cette tâche.',
        'no_related_tasks' => 'Aucune tâche liée.',
        'no_comments' => 'Aucun commentaire pour cette tâche.',
        'overdue' => 'En retard',
        'due_soon' => 'Bientôt dûe',
        'completion' => ':percent% complétée',
    ],

    'created' => 'Tâche créée avec succès.',
    'updated' => 'Tâche mise à jour avec succès.',
    'deleted' => 'Tâche supprimée avec succès.',
    'archived' => 'Tâche archivée avec succès.',
    'restored' => 'Tâche restaurée avec succès.',
    'force_deleted' => 'Tâche supprimée définitivement.',

    'checklist' => [
        'created' => 'Élément de checklist ajouté avec succès.',
        'updated' => 'Élément de checklist mis à jour avec succès.',
        'deleted' => 'Élément de checklist supprimé avec succès.',
        'completed' => 'Élément de checklist marqué comme complété.',
        'uncompleted' => 'Élément de checklist marqué comme non complété.',
    ],

    'assignee' => [
        'added' => 'Assigné ajouté avec succès.',
        'removed' => 'Assigné retiré avec succès.',
        'already_assigned' => 'L’utilisateur est déjà assigné à cette tâche.',
    ],

    'comment' => [
        'created' => 'Commentaire ajouté avec succès.',
        'updated' => 'Commentaire mis à jour avec succès.',
        'deleted' => 'Commentaire supprimé avec succès.',
    ],

    'by' => 'par :name',

    'validation' => [
        'title' => [
            'required' => 'Le titre de la tâche est requis.',
        ],
        'description' => [
            'required' => 'La description de la tâche est requise.',
        ],
        'status' => [
            'required' => 'Le statut de la tâche est requis.',
            'exists' => 'Le statut sélectionné n’existe pas.',
            'name' => [
                'required' => 'Le nom du statut est requis.',
                'max' => 'Le nom du statut ne doit pas dépasser :max caractères.',
            ],
        ],
        'limited_at' => [
            'after_or_equal' => 'La date limite doit être postérieure ou égale à la date de début.',
        ],
        'tags' => [
            'exists' => 'Une ou plusieurs étiquettes sélectionnées n’existent pas.',
        ],
        'assignees' => [
            'exists' => 'Un ou plusieurs assignés sélectionnés n’existent pas.',
        ],
        'visibility_roles' => [
            'exists' => 'Un ou plusieurs rôles sélectionnés n’existent pas.',
        ],
        'related_tasks' => [
            'exists' => 'Une ou plusieurs tâches liées sélectionnées n’existent pas.',
            'different' => 'Une tâche ne peut pas être liée à elle-même.',
        ],
        'checklist' => [
            'title' => [
                'required' => 'Le titre de l’élément de checklist est requis.',
                'max' => 'Le titre de l’élément de checklist ne doit pas dépasser :max caractères.',
            ],
        ],
        'tag' => [
            'name' => [
                'required' => 'Le nom de l’étiquette est requis.',
                'max' => 'Le nom de l’étiquette ne doit pas dépasser :max caractères.',
            ],
            'color' => [
                'required' => 'La couleur de l’étiquette est requise.',
                'format' => 'La couleur doit être un code HEX valide.',
            ],
        ],
        'assignee' => [
            'user_id' => [
                'required' => 'L’ID utilisateur est requis.',
                'exists' => 'L’utilisateur sélectionné n’existe pas.',
            ],
        ],
        'visibility' => [
            'role_id' => [
                'required' => 'L’ID du rôle est requis.',
                'exists' => 'Le rôle sélectionné n’existe pas.',
            ],
        ],
        'related_task' => [
            'id' => [
                'required' => 'L’ID de la tâche liée est requis.',
                'exists' => 'La tâche liée sélectionnée n’existe pas.',
                'different' => 'Une tâche ne peut pas être liée à elle-même.',
            ],
        ],
        'comment' => [
            'content' => [
                'required' => 'Le contenu du commentaire est requis.',
            ],
        ],
        'status' => [
            'color' => [
                'format' => 'La couleur doit être un code HEX valide.',
            ],
        ],
    ],
];
