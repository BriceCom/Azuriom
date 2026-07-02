<?php

return [
    'plugin' => [
        'name' => 'Sugestões',
    ],

    'index' => [
        'title' => 'Sugestões',
    ],

    'suggestions' => [
        'title' => 'Sugestões',
        'updated' => 'A sugestão foi atualizada.',
        'deleted' => 'A sugestão foi excluída.',
        'status_updated' => 'O status da sugestão foi atualizado.',
    ],

    'categories' => [
        'title' => 'Categorias',
        'create' => 'Criar categoria',
        'edit' => 'Editar categoria',
        'created' => 'A categoria foi criada.',
        'updated' => 'A categoria foi atualizada.',
        'deleted' => 'A categoria foi excluída.',
        'delete_error' => 'Você não pode excluir uma categoria que possui sugestões.',
    ],

    'permissions' => [
        'create' => 'Criar sugestões',
        'delete' => 'Excluir sugestões',
        'edit' => 'Editar sugestões',
        'settings' => 'Gerenciar configurações',
        'comments' => [
            'delete' => 'Excluir qualquer comentário de sugestões',
        ],
    ],

    'settings' => [
        'title' => 'Configurações',
        'max_suggestions' => 'Máximo de sugestões por usuário',
        'max_suggestions_info' => 'Número máximo de sugestões pendentes que um usuário pode criar (0 para ilimitado)',
        'max_description_length' => 'Comprimento máximo da descrição',
        'max_description_length_info' => 'Número máximo de caracteres para descrição da sugestão (50-4000)',
        'index_title' => 'Título da página inicial',
        'index_subtitle' => 'Subtítulo da página inicial',
        'enable_comments' => 'Ativar comentários',
        'disable_category_filters' => 'Desativar filtros por categoria',
    ],

    'discord' => [
        'title' => 'Discord Webhook',
        'webhook_url' => 'URL do Webhook Discord',
        'webhook_url_info' => 'Digite a URL do seu webhook Discord. Você pode criar um nas configurações do seu servidor Discord em Integrações > Webhooks.',
        'enabled' => 'Ativado',
        'send_on_create' => 'Enviar webhook quando uma sugestão for criada',
        'send_on_accept' => 'Enviar webhook quando uma sugestão for aceita',
        'send_on_refuse' => 'Enviar webhook quando uma sugestão for recusada',
        'test' => 'Testar',
        'test_success' => 'Teste do webhook bem-sucedido!',
        'test_failed' => 'Falha no teste do webhook',
        'how_it_works' => 'Como funciona:',
        'feature_list' => [
            'Webhooks serão enviados de acordo com as opções selecionadas',
            'Mensagens incluem detalhes da sugestão, autor, status, categoria e contagem de votos',
            'Cada ação usa uma cor diferente (verde para nova, azul para aceita, vermelho para recusada)',
        ],
        'customization' => 'Personalização do Webhook',
        'color_created' => 'Cor da criação',
        'color_accepted' => 'Cor da aceitação',
        'color_refused' => 'Cor da recusa',
        'custom_templates' => 'Modelos personalizados',
        'template_variables_help' => 'Use variáveis como {title}, {author}, {category}, {status}, {votes}, {url}, {refusal_reason}',
        'template_created' => 'Modelo de criação',
        'template_accepted' => 'Modelo de aceitação',
        'template_refused' => 'Modelo de recusa',
        'custom_username' => 'Nome de usuário personalizado',
        'custom_avatar_url' => 'URL do avatar personalizado',
        'display_options' => 'Opções de exibição',
        'show_author' => 'Mostrar autor',
        'show_category' => 'Mostrar categoria',
        'show_votes' => 'Mostrar votos',
        'show_description' => 'Mostrar descrição',
        'description_length' => 'Comprimento da descrição',
        'description_length_help' => 'Número máximo de caracteres para descrição da sugestão (50-4000)',
    ],

    'statistics' => [
        'title' => 'Estatísticas',
        'total_suggestions' => 'Total de sugestões',
        'pending' => 'Pendentes',
        'accepted' => 'Aceitas',
        'refused' => 'Recusadas',
        'total_votes' => 'Total de votos',
        'upvotes' => 'Votos positivos',
        'downvotes' => 'Votos negativos',
        'recent_activity' => 'Atividade recente (últimos 30 dias)',
        'new_suggestions' => 'Novas sugestões',
        'new_votes' => 'Novos votos',
        'top_categories' => 'Top categorias',
        'most_voted_suggestions' => 'Sugestões mais votadas',
        'monthly_activity' => 'Atividade mensal',
        'status_distribution' => 'Distribuição de status',
        'author' => 'Autor',
        'category' => 'Categoria',
        'status' => 'Status',
        'net_score' => 'Pontuação líquida',
        'no_categories' => 'Nenhuma categoria encontrada.',
        'no_suggestions' => 'Nenhuma sugestão encontrada.',
        'table_title' => 'Título',
        'suggestions' => 'Sugestões',
        'votes' => 'Votos',
        'none' => 'Nenhum',
    ],

    'logs' => [
        'suggest' => [
            'created' => 'Sugestão criada: :title',
            'deleted' => 'Sugestão excluída: :title por :author',
            'edited' => 'Sugestão editada: :title',
        ],
    ],

    'support' => "Suporte Discord",
    'serveurliste' => "Top Servidores",
];
