function GlobalSections(editor) {
    const t = (key, fallback = null, params = null) => {
        if (typeof window.trans === 'function') {
            return window.trans(key, params, fallback);
        }

        return fallback ?? key;
    };

    const escapeHtml = (value) => String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const getSections = () => {
        if (typeof window.pagebuilderGetGlobalSections === 'function') {
            return window.pagebuilderGetGlobalSections();
        }

        return {
            headers: { active_id: null, templates: {} },
            footers: { active_id: null, templates: {} },
        };
    };

    const setSections = (sections) => {
        if (typeof window.pagebuilderSetGlobalSections === 'function') {
            return window.pagebuilderSetGlobalSections(sections);
        }

        return sections;
    };

    const getScope = () => {
        if (typeof window.pagebuilderGetEditorScope === 'function') {
            return window.pagebuilderGetEditorScope();
        }

        return { type: 'page', sectionType: null, templateId: null };
    };

    const setScope = (scope) => {
        if (typeof window.pagebuilderSetEditorScope === 'function') {
            return window.pagebuilderSetEditorScope(scope);
        }

        return scope;
    };

    const refreshModal = (ed) => {
        ed.Modal.close();
        setTimeout(() => ed.runCommand('open-global-sections'), 0);
    };

    const renderOptions = (templates, activeId) => {
        const entries = Object.entries(templates || {});
        if (entries.length === 0) {
            return '<option value="">Aucun template</option>';
        }

        return entries.map(([templateId, template]) => {
            const selected = templateId === activeId ? ' selected' : '';
            const label = template?.name || templateId;
            return `<option value="${escapeHtml(templateId)}"${selected}>${escapeHtml(label)}</option>`;
        }).join('');
    };

    const createTemplate = (sections, sectionType) => {
        const bucketKey = sectionType === 'header' ? 'headers' : 'footers';
        const defaultName = sectionType === 'header' ? 'Header global' : 'Footer global';
        const nameInput = window.prompt(`Nom du template ${sectionType === 'header' ? 'header' : 'footer'} :`, defaultName);
        const name = String(nameInput || '').trim();
        if (!name) {
            return false;
        }

        const templateId = `${sectionType}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
        sections[bucketKey].templates[templateId] = {
            name,
            components: {},
            css: '',
            metadata: {
                scope: 'global',
                section_type: sectionType,
                template_id: templateId,
                created_at: new Date().toISOString(),
            },
        };
        sections[bucketKey].active_id = templateId;

        return true;
    };

    const ensureSectionShape = (sections) => {
        const safe = sections && typeof sections === 'object' ? sections : {};
        safe.headers = safe.headers && typeof safe.headers === 'object' ? safe.headers : { active_id: null, templates: {} };
        safe.footers = safe.footers && typeof safe.footers === 'object' ? safe.footers : { active_id: null, templates: {} };
        safe.headers.templates = safe.headers.templates && typeof safe.headers.templates === 'object' ? safe.headers.templates : {};
        safe.footers.templates = safe.footers.templates && typeof safe.footers.templates === 'object' ? safe.footers.templates : {};

        return safe;
    };

    editor.Panels.addButton('options', {
        id: 'open-global-sections',
        className: 'fa fa-clone',
        attributes: { title: 'Global Header/Footer' },
        command: 'open-global-sections',
    });

    editor.Commands.add('open-global-sections', {
        run(ed) {
            const sections = ensureSectionShape(getSections());
            const scope = getScope();
            const scopeLabel = scope.type === 'global'
                ? `Edition globale: ${scope.sectionType} (${scope.templateId})`
                : 'Edition page courante';

            const wrapper = document.createElement('div');
            wrapper.innerHTML = `
                <div class="container-fluid p-3" style="max-height:72vh;overflow:auto">
                    <div class="alert alert-info mb-3">${escapeHtml(scopeLabel)}</div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Header global</h5>
                                    <label class="form-label">Template actif</label>
                                    <select class="form-select mb-3" id="pb-global-header-select">
                                        ${renderOptions(sections.headers.templates, sections.headers.active_id)}
                                    </select>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-action="create" data-section="header">Créer</button>
                                        <button type="button" class="btn btn-primary btn-sm" data-action="edit" data-section="header">Éditer</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-action="delete" data-section="header">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Footer global</h5>
                                    <label class="form-label">Template actif</label>
                                    <select class="form-select mb-3" id="pb-global-footer-select">
                                        ${renderOptions(sections.footers.templates, sections.footers.active_id)}
                                    </select>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-action="create" data-section="footer">Créer</button>
                                        <button type="button" class="btn btn-primary btn-sm" data-action="edit" data-section="footer">Éditer</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-action="delete" data-section="footer">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="pb-back-page-edit" class="btn btn-outline-secondary">Retour édition page</button>
                        <button type="button" id="pb-apply-globals" class="btn btn-success">${t('theme::pagebuilder.save', 'Save')}</button>
                    </div>
                </div>
            `;

            ed.Modal.open({
                title: 'Global Header/Footer',
                content: wrapper,
            });

            const getSelect = (sectionType) => {
                return wrapper.querySelector(sectionType === 'header' ? '#pb-global-header-select' : '#pb-global-footer-select');
            };

            const updateActiveFromSelects = () => {
                const nextSections = ensureSectionShape(getSections());
                const headerSelect = getSelect('header');
                const footerSelect = getSelect('footer');

                nextSections.headers.active_id = headerSelect?.value || null;
                nextSections.footers.active_id = footerSelect?.value || null;

                setSections(nextSections);

                return nextSections;
            };

            wrapper.querySelectorAll('button[data-action]').forEach((button) => {
                button.addEventListener('click', () => {
                    const action = button.getAttribute('data-action');
                    const sectionType = button.getAttribute('data-section');
                    const bucketKey = sectionType === 'header' ? 'headers' : 'footers';

                    const nextSections = ensureSectionShape(getSections());
                    const sectionSelect = getSelect(sectionType);
                    const selectedId = sectionSelect?.value || null;

                    if (action === 'create') {
                        if (!createTemplate(nextSections, sectionType)) {
                            return;
                        }

                        setSections(nextSections);
                        refreshModal(ed);
                        return;
                    }

                    if (action === 'delete') {
                        if (!selectedId || !nextSections[bucketKey].templates[selectedId]) {
                            window.alert('Aucun template sélectionné.');
                            return;
                        }

                        delete nextSections[bucketKey].templates[selectedId];
                        const templateIds = Object.keys(nextSections[bucketKey].templates);
                        nextSections[bucketKey].active_id = templateIds[0] || null;
                        setSections(nextSections);

                        const scopeNow = getScope();
                        if (scopeNow.type === 'global' && scopeNow.sectionType === sectionType && scopeNow.templateId === selectedId) {
                            setScope({ type: 'page' });
                        }

                        refreshModal(ed);
                        return;
                    }

                    if (action === 'edit') {
                        if (!selectedId || !nextSections[bucketKey].templates[selectedId]) {
                            window.alert('Aucun template sélectionné.');
                            return;
                        }

                        nextSections[bucketKey].active_id = selectedId;
                        setSections(nextSections);
                        setScope({ type: 'global', sectionType, templateId: selectedId });
                        ed.Modal.close();
                    }
                });
            });

            wrapper.querySelector('#pb-back-page-edit')?.addEventListener('click', () => {
                setScope({ type: 'page' });
                ed.Modal.close();
            });

            wrapper.querySelector('#pb-apply-globals')?.addEventListener('click', () => {
                const updatedSections = updateActiveFromSelects();
                const scopeNow = getScope();

                if (scopeNow.type === 'global') {
                    const bucketKey = scopeNow.sectionType === 'header' ? 'headers' : 'footers';
                    const nextTemplateId = updatedSections[bucketKey]?.active_id || null;
                    if (nextTemplateId) {
                        setScope({
                            type: 'global',
                            sectionType: scopeNow.sectionType,
                            templateId: nextTemplateId,
                        });
                    } else {
                        setScope({ type: 'page' });
                    }
                }

                if (typeof window.pagebuilderRequestSave === 'function') {
                    window.pagebuilderRequestSave();
                }

                ed.Modal.close();
            });
        }
    });
}
