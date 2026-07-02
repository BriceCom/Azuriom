(() => {
    const currentHandlers = window.ThemeEditorBlockHandlers && typeof window.ThemeEditorBlockHandlers === 'object'
        ? window.ThemeEditorBlockHandlers
        : {};

    const handlers = {
        header(context) {
            const { element, params, state, helpers } = context;
            const headerShell = helpers.queryAttrValue('node', 'layout-header-shell');
            const sticky = helpers.toBoolean(params.sticky, false);
            const serverAddress = String(state.global?.server_address || headerShell?.dataset?.teServerAddress || '').trim();

            element.classList.toggle('sticky-top', sticky);
            helpers.applyHeaderButtonStyles(headerShell, params.button_styles, serverAddress);
        },

        hero(context) {
            const { params, state, helpers } = context;
            const serverAddress = String(params.ip_address || state.global?.server_address || '').trim();

            helpers.setText('badge_text', 'Serveur en ligne');
            helpers.setText('title', 'Le serveur Minecraft');
            helpers.setText('highlight', 'sans compromis.');
            helpers.setText('subtitle', 'Survie, PvP, Skyblock — une communauté active.');
            helpers.setText('ip_label', 'IP');
            helpers.setText('ip_status', 'En ligne');

            const ipNode = helpers.queryAttrValue('node', 'landing-hero-ip');
            if (ipNode) {
                ipNode.textContent = serverAddress;
            }

            const primaryButton = helpers.queryAttrValue('node', 'landing-hero-primary-button');
            helpers.applyLandingButton(primaryButton, {
                variant: params.primary_button_variant,
                text: params.primary_button_text,
                url: params.primary_button_url,
                fallbackText: 'Commencer à jouer',
                fallbackUrl: '#join',
                serverAddress,
            });

            const secondaryButton = helpers.queryAttrValue('node', 'landing-hero-secondary-button');
            helpers.applyLandingButton(secondaryButton, {
                variant: params.secondary_button_variant,
                text: params.secondary_button_text,
                url: params.secondary_button_url,
                fallbackText: 'Voir les serveurs',
                fallbackUrl: '#servers',
                serverAddress,
            });
        },

        features(context) {
            const { params, helpers } = context;
            if (Array.isArray(params.items) && params.items.length === 0) {
                helpers.resetElementFromTemplate();
            }

            helpers.setText('badge', 'Pourquoi nous ?');
            helpers.setText('title', 'Conçu pour une expérience sans friction.');
            helpers.setText('subtitle', 'Performances, équité, communauté.');

            const container = helpers.queryAttrValue('param_list', 'items');
            if (container && Array.isArray(params.items) && params.items.length > 0) {
                container.innerHTML = params.items.map((item) => `
                    <article class="card h-100">
                        <div class="card-body">
                            <span class="te-landing-feature-icon">${helpers.renderIconMarkup(helpers.resolveTemplateVariables(String(item.icon || '')))}</span>
                            <h3 class="h5 mb-2">${helpers.escapeHtml(helpers.resolveTemplateVariables(String(item.title || 'Feature')))}</h3>
                            <p class="text-body-secondary mb-0">${helpers.escapeHtml(helpers.resolveTemplateVariables(String(item.text || '')))}</p>
                        </div>
                    </article>
                `).join('');
            }
        },

        servers(context) {
            context.helpers.resetElementFromTemplate();
        },

        news(context) {
            context.helpers.resetElementFromTemplate();
        },

        steps(context) {
            const { params, helpers } = context;
            if (Array.isArray(params.items) && params.items.length === 0) {
                helpers.resetElementFromTemplate();
            }

            helpers.setText('badge', 'Comment rejoindre');
            helpers.setText('title', 'En ligne en moins de 60 secondes.');
            helpers.setText('subtitle', 'Accessible sur Java et Bedrock.');

            const container = helpers.queryAttrValue('param_list', 'items');
            if (container && Array.isArray(params.items) && params.items.length > 0) {
                container.innerHTML = params.items.map((item, index) => `
                    <article class="card">
                        <div class="card-body d-flex gap-3">
                            <span class="badge rounded-pill bg-primary font-monospace d-inline-flex align-items-center justify-content-center" style="min-width: 2.15rem;">${String(index + 1).padStart(2, '0')}</span>
                            <div>
                                <h3 class="h5 mb-1">${helpers.escapeHtml(helpers.resolveTemplateVariables(String(item.title || 'Étape')))}</h3>
                                <p class="text-body-secondary mb-0">${helpers.escapeHtml(helpers.resolveTemplateVariables(String(item.text || '')))}</p>
                            </div>
                        </div>
                    </article>
                `).join('');
            }
        },

        stats(context) {
            const { params, helpers } = context;
            if (Array.isArray(params.items) && params.items.length === 0) {
                helpers.resetElementFromTemplate();
            }

            helpers.setText('badge', 'En chiffres');
            helpers.setText('title', 'Un serveur solide depuis 2021.');

            const container = helpers.queryAttrValue('param_list', 'items');
            if (container && Array.isArray(params.items) && params.items.length > 0) {
                container.innerHTML = params.items.map((item) => `
                    <article class="card text-center">
                        <div class="card-body">
                            <h3 class="display-6 mb-1 fw-bold">${helpers.escapeHtml(helpers.resolveTemplateVariables(String(item.value || '0')))}</h3>
                            <p class="text-body-secondary text-uppercase small mb-0">${helpers.escapeHtml(helpers.resolveTemplateVariables(String(item.label || 'Stat')))}</p>
                        </div>
                    </article>
                `).join('');
            }
        },

        cta(context) {
            const { params, state, helpers } = context;
            const serverAddress = String(state.global?.server_address || '').trim();

            helpers.setText('badge', 'Prêt ?');
            helpers.setText('title', 'Rejoins l’aventure dès aujourd’hui.');
            helpers.setText('subtitle', 'Gratuit. Sans inscription.');

            const primaryButton = helpers.queryAttrValue('node', 'landing-cta-primary-button');
            helpers.applyLandingButton(primaryButton, {
                variant: params.primary_button_variant,
                text: params.primary_button_text,
                url: params.primary_button_url,
                fallbackText: 'Commencer à jouer',
                fallbackUrl: '#join',
                serverAddress,
            });

            const secondaryButton = helpers.queryAttrValue('node', 'landing-cta-secondary-button');
            helpers.applyLandingButton(secondaryButton, {
                variant: params.secondary_button_variant,
                text: params.secondary_button_text,
                url: params.secondary_button_url,
                fallbackText: 'Rejoindre le Discord',
                fallbackUrl: String(state.global?.discord_link || '#'),
                serverAddress,
            });
        },

        footer(context) {
            const { params, helpers } = context;
            const logoNode = helpers.queryAllAttr('footer_logo')[0] || null;
            if (logoNode) {
                logoNode.hidden = !Boolean(params.show_logo);
            }

            helpers.setText('description', '');
            const descriptionNode = helpers.queryAttrValue('param', 'description');
            if (descriptionNode) {
                descriptionNode.hidden = !String(params.description || '').trim();
            }

            const socialNode = helpers.queryAllAttr('footer_social')[0] || null;
            if (socialNode) {
                socialNode.hidden = !Boolean(params.show_social_links);
            }

            const dixeptNode = helpers.queryAttrValue('node', 'footer-dixept-copyright');
            if (dixeptNode) {
                const showDixeptOption = helpers.toBoolean(params.show_dixept_copyright, true);
                const shouldShow = helpers.isAdvancedModeActive() ? showDixeptOption : true;
                dixeptNode.hidden = !shouldShow;
            }
        },
    };

    window.ThemeEditorBlockHandlers = {
        ...currentHandlers,
        ...handlers,
    };
})();
