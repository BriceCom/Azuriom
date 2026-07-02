<?php

return [
    'title' => 'Tasks',

    'actions' => [
        'create' => 'Create Task',
        'edit' => 'Edit Task',
        'delete' => 'Delete Task',
        'view' => 'View Task',
        'filter' => 'Filter Tasks',
        'clear_filter' => 'Clear Filters',
        'add_checklist' => 'Add Checklist Item',
        'add_assignee' => 'Add Assignee',
        'remove_assignee' => 'Remove Assignee',
        'add_comment' => 'Add Comment',
        'edit_comment' => 'Edit Comment',
        'delete_comment' => 'Delete Comment',
        'select' => 'Select',
        'confirm_deletion' => 'Confirm Deletion',
        'confirm_delete' => 'Are you sure you want to delete :item?',
        'irreversible' => 'This action is irreversible.',
    ],

    'fields' => [
        'title' => 'Title',
        'description' => 'Description',
        'status' => 'Status',
        'author' => 'Author',
        'assignees' => 'Assignees',
        'tags' => 'Tags',
        'started_at' => 'Start Date',
        'limited_at' => 'Due Date',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'visibility' => 'Visibility',
        'related_tasks' => 'Related Tasks',
        'checklist' => 'Checklist',
        'comments' => 'Comments',
        'content' => 'Content',
        'informations' => 'Informations',
    ],

    'status' => [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'visibility' => [
        'private' => 'Private (only author and assignees)',
        'public' => 'Public (all users)',
        'role' => 'Role-based (specific roles)',
    ],

    'info' => [
        'no_tasks' => 'No tasks found.',
        'no_checklist' => 'No checklist items for this task.',
        'no_assignees' => 'No assignees for this task.',
        'no_related_tasks' => 'No related tasks.',
        'no_comments' => 'No comments for this task.',
        'overdue' => 'Overdue',
        'due_soon' => 'Due soon',
        'completion' => ':percent% completed',
    ],

    'created' => 'Task created successfully.',
    'updated' => 'Task updated successfully.',
    'deleted' => 'Task deleted successfully.',
    'archived' => 'Task archived successfully.',
    'restored' => 'Task restored successfully.',
    'force_deleted' => 'Task permanently deleted.',

    'checklist' => [
        'created' => 'Checklist item added successfully.',
        'updated' => 'Checklist item updated successfully.',
        'deleted' => 'Checklist item deleted successfully.',
        'completed' => 'Checklist item marked as completed.',
        'uncompleted' => 'Checklist item marked as not completed.',
    ],

    'assignee' => [
        'added' => 'Assignee added successfully.',
        'removed' => 'Assignee removed successfully.',
        'already_assigned' => 'User is already assigned to this task.',
    ],

    'comment' => [
        'created' => 'Comment added successfully.',
        'updated' => 'Comment updated successfully.',
        'deleted' => 'Comment deleted successfully.',
    ],

    'by' => 'by :name',

    'validation' => [
        'title' => [
            'required' => 'The task title is required.',
        ],
        'description' => [
            'required' => 'The task description is required.',
        ],
        'status' => [
            'required' => 'The task status is required.',
            'exists' => 'The selected status does not exist.',
            'name' => [
                'required' => 'The status name is required.',
                'max' => 'The status name may not be greater than :max characters.',
            ],
        ],
        'limited_at' => [
            'after_or_equal' => 'The due date must be after or equal to the start date.',
        ],
        'tags' => [
            'exists' => 'One or more selected tags do not exist.',
        ],
        'assignees' => [
            'exists' => 'One or more selected assignees do not exist.',
        ],
        'visibility_roles' => [
            'exists' => 'One or more selected roles do not exist.',
        ],
        'related_tasks' => [
            'exists' => 'One or more selected related tasks do not exist.',
            'different' => 'A task cannot be related to itself.',
        ],
        'checklist' => [
            'title' => [
                'required' => 'The checklist item title is required.',
                'max' => 'The checklist item title may not be greater than :max characters.',
            ],
        ],
        'tag' => [
            'name' => [
                'required' => 'The tag name is required.',
                'max' => 'The tag name may not be greater than :max characters.',
            ],
            'color' => [
                'required' => 'The tag color is required.',
                'format' => 'The tag color must be a valid HEX color code.',
            ],
        ],
        'assignee' => [
            'user_id' => [
                'required' => 'The user ID is required.',
                'exists' => 'The selected user does not exist.',
            ],
        ],
        'visibility' => [
            'role_id' => [
                'required' => 'The role ID is required.',
                'exists' => 'The selected role does not exist.',
            ],
        ],
        'related_task' => [
            'id' => [
                'required' => 'The related task ID is required.',
                'exists' => 'The selected related task does not exist.',
                'different' => 'A task cannot be related to itself.',
            ],
        ],
        'comment' => [
            'content' => [
                'required' => 'The comment content is required.',
            ],
        ],
        'status' => [
            'color' => [
                'format' => 'The color must be a valid HEX color code.',
            ],
        ],
    ],
];
