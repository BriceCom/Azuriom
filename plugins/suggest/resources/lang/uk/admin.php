<?php

return [
    'plugin' => [
        'name' => 'Пропозиції',
    ],

    'index' => [
        'title' => 'Пропозиції',
    ],

    'suggestions' => [
        'title' => 'Пропозиції',
        'updated' => 'Пропозицію оновлено.',
        'deleted' => 'Пропозицію видалено.',
        'status_updated' => 'Статус пропозиції оновлено.',
    ],

    'categories' => [
        'title' => 'Категорії',
        'create' => 'Створити категорію',
        'edit' => 'Редагувати категорію',
        'created' => 'Категорію створено.',
        'updated' => 'Категорію оновлено.',
        'deleted' => 'Категорію видалено.',
        'delete_error' => 'Неможливо видалити категорію, що містить пропозиції.',
    ],

    'permissions' => [
        'create' => 'Створення пропозицій',
        'delete' => 'Видалення пропозицій',
        'edit' => 'Редагування пропозицій',
        'settings' => 'Керування налаштуваннями',
    ],

    'settings' => [
        'title' => 'Налаштування',
        'max_suggestions' => 'Максимальна кількість пропозицій на користувача',
        'max_suggestions_info' => 'Максимальна кількість очікуючих пропозицій, які користувач може створити (0 — без обмежень)',
        'max_description_length' => 'Максимальна довжина опису',
        'max_description_length_info' => 'Максимальна кількість символів для опису пропозиції (50-4000)',
        'index_title' => 'Заголовок головної сторінки',
        'index_subtitle' => 'Підзаголовок головної сторінки',
        'disable_category_filters' => 'Вимкнути фільтри за категоріями',
    ],

    'discord' => [
        'title' => 'Discord Webhook',
        'webhook_url' => 'URL Discord Webhook',
        'webhook_url_info' => 'Введіть URL вашого Discord webhook. Ви можете створити його у налаштуваннях свого Discord-сервера в розділі Інтеграції > Webhooks.',
        'enabled' => 'Увімкнено',
        'send_on_create' => 'Надсилати webhook при створенні пропозиції',
        'send_on_accept' => 'Надсилати webhook при прийнятті пропозиції',
        'send_on_refuse' => 'Надсилати webhook при відхиленні пропозиції',
        'test' => 'Тестувати',
        'test_success' => 'Webhook успішно протестовано!',
        'test_failed' => 'Тест webhook не вдався',
        'how_it_works' => 'Як це працює:',
        'feature_list' => [
            'Webhooks надсилатимуться згідно з вибраними опціями',
            'Повідомлення містять дані пропозиції, автора, статус, категорію та кількість голосів',
            'Різні кольори використовуються для різних дій (зелений — нова, синій — прийнята, червоний — відхилена)',
        ],
        'customization' => 'Налаштування Webhook',
        'color_created' => 'Колір створення',
        'color_accepted' => 'Колір прийняття',
        'color_refused' => 'Колір відхилення',
        'custom_templates' => 'Користувацькі шаблони',
        'template_variables_help' => 'Використовуйте змінні типу {title}, {author}, {category}, {status}, {votes}, {url}, {refusal_reason}',
        'template_created' => 'Шаблон створення',
        'template_accepted' => 'Шаблон прийняття',
        'template_refused' => 'Шаблон відхилення',
        'custom_username' => 'Користувацьке імʼя користувача',
        'custom_avatar_url' => 'Користувацький URL аватарки',
        'display_options' => 'Опції відображення',
        'show_author' => 'Показувати автора',
        'show_category' => 'Показувати категорію',
        'show_votes' => 'Показувати голоси',
        'show_description' => 'Показувати опис',
        'description_length' => 'Довжина опису',
        'description_length_help' => 'Максимальна кількість символів в описі пропозиції (50-4000)',
    ],

    'statistics' => [
        'title' => 'Статистика',
        'total_suggestions' => 'Усього пропозицій',
        'pending' => 'Очікують',
        'accepted' => 'Прийняті',
        'refused' => 'Відхилені',
        'total_votes' => 'Усього голосів',
        'upvotes' => 'Позитивні голоси',
        'downvotes' => 'Негативні голоси',
        'recent_activity' => 'Остання активність (останні 30 днів)',
        'new_suggestions' => 'Нові пропозиції',
        'new_votes' => 'Нові голоси',
        'top_categories' => 'Топ категорій',
        'most_voted_suggestions' => 'Найбільш підтримані пропозиції',
        'monthly_activity' => 'Місячна активність',
        'status_distribution' => 'Розподіл статусів',
        'author' => 'Автор',
        'category' => 'Категорія',
        'status' => 'Статус',
        'net_score' => 'Чистий рейтинг',
        'no_categories' => 'Категорії не знайдено.',
        'no_suggestions' => 'Пропозицій не знайдено.',
        'table_title' => 'Назва',
        'suggestions' => 'Пропозиції',
        'votes' => 'Голоси',
        'none' => 'Немає',
    ],

    'logs' => [
        'suggest' => [
            'created' => 'Пропозицію створено: :title',
            'deleted' => 'Пропозицію видалено: :title автором :author',
            'edited' => 'Пропозицію відредаговано: :title',
        ],
    ],

    'support' => "Підтримка в Discord",
    "serveurliste" => "Список топ-серверів",
];
