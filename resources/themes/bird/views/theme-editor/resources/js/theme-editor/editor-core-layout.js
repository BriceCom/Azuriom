window.ThemeEditorCoreLayout = function createThemeEditorCoreLayout(context) {
    const {
        runtime,
        root,
        state,
        defaultState,
        blockCatalog,
        imageUrlByFile,
        ui,
        t,
        attr,
        selectorForAttr,
        selectorForAttrValue,
        queryAllAttr,
        queryAttrValue,
        readAttrValue,
        setAttrValue,
        deepClone,
        normalizeHex,
        toRgb,
        contrastColor,
        normalizeBlockId,
        normalizeBlocksList,
        findBlockContainer,
        getCurrentRouteKey,
        getCurrentRouteLabel,
        getRouteBlocks,
        reindexBlocksList,
        nextBlockOrder,
        toBoolean,
        isAdvancedModeActive,
        resolveTemplateVariables,
        setDirty,
        setPhase,
        isPanelOpen,
        onRouteBlocksMutated,
        onSystemVariablesRefresh,
        onPageHistoryMutated,
    } = context;

    let modalBlockIndex = null;
    let scrollHandler = null;

    const getCatalogItem = (blockId) => blockCatalog.find((item) => item.id === blockId);

    const getFixedCatalogItems = () => blockCatalog.filter((item) => item && item.fixed === true && typeof item.id === 'string');
    const getRequiredCatalogItems = () => blockCatalog.filter((item) => item && item.required === true && typeof item.id === 'string');

    const isFixedBlockId = (blockId) => Boolean(getCatalogItem(blockId)?.fixed);
    const isUniqueBlockId = (blockId) => Boolean(getCatalogItem(blockId)?.unique || getCatalogItem(blockId)?.fixed);
    const isRequiredBlockId = (blockId) => Boolean(getCatalogItem(blockId)?.required);

    const isExternalBlockId = (blockId) => Boolean(getCatalogItem(blockId)?.external);
    const isBlockAddable = (blockId) => getCatalogItem(blockId)?.addable !== false;
    const canMoveBlockId = (blockId) => getCatalogItem(blockId)?.movable !== false;
    const canEditBlockId = (blockId) => getCatalogItem(blockId)?.editable !== false;
    const canDeleteBlockId = (blockId) => getCatalogItem(blockId)?.deletable !== false && !isRequiredBlockId(blockId);
    const canDuplicateBlockId = (blockId) => getCatalogItem(blockId)?.duplicable !== false;

    const getBlockAnchor = (blockId) => {
        const rawAnchor = String(getCatalogItem(blockId)?.anchor || '').trim().toLowerCase();
        if (rawAnchor === 'start' || rawAnchor === 'end') {
            return rawAnchor;
        }

        return null;
    };

    const withSystemBlocks = (blockIds) => {
        const ids = Array.isArray(blockIds) ? blockIds.filter((id) => typeof id === 'string' && id.length > 0) : [];
        const sanitized = ids.filter((id) => id !== 'header' && id !== 'footer');

        if (getCatalogItem('header')) {
            sanitized.unshift('header');
        }
        if (getCatalogItem('footer')) {
            sanitized.push('footer');
        }

        return sanitized;
    };

    let pageDragSourceIndex = null;
    let pageDragTargetIndex = null;
    let pageDragTargetPosition = 'before';

    const clearPageDragState = () => {
        pageDragSourceIndex = null;
        pageDragTargetIndex = null;
        pageDragTargetPosition = 'before';
    };

    const syncPageDragState = () => {
        if (!ui.activeBlocksContainer) {
            return;
        }

        Array.from(ui.activeBlocksContainer.querySelectorAll('.te-block-item')).forEach((item, index) => {
            item.classList.toggle('is-dragging', pageDragSourceIndex === index);
            item.classList.toggle('is-drop-target-before', pageDragTargetIndex === index && pageDragTargetPosition === 'before');
            item.classList.toggle('is-drop-target-after', pageDragTargetIndex === index && pageDragTargetPosition === 'after');
        });
    };

    const reorderRouteBlock = (sourceIndex, destinationIndex) => {
        const routeBlocks = getRouteBlocks();
        if (!Array.isArray(routeBlocks) || sourceIndex < 0 || sourceIndex >= routeBlocks.length) {
            return false;
        }

        if (destinationIndex < 0) {
            destinationIndex = 0;
        }
        if (destinationIndex > routeBlocks.length) {
            destinationIndex = routeBlocks.length;
        }

        const [moved] = routeBlocks.splice(sourceIndex, 1);
        if (!moved) {
            return false;
        }

        const adjustedIndex = sourceIndex < destinationIndex ? destinationIndex - 1 : destinationIndex;
        routeBlocks.splice(Math.max(0, Math.min(adjustedIndex, routeBlocks.length)), 0, moved);

        reindexBlocksList(routeBlocks);
        enforceRouteBlockConstraints(getCurrentRouteKey());
        if (typeof onRouteBlocksMutated === 'function') {
            onRouteBlocksMutated();
        }
        renderActiveBlocks();
        applyLivePreview({
            markDirty: true,
            message: t('messages.blocks_reordered', 'Ordre des blocs mis à jour sur {route}', {
                route: getCurrentRouteLabel(),
            }),
        });

        return true;
    };

    const enrichParamsWithDefaults = (block) => {
        const catalogItem = getCatalogItem(block.id);
        const defaultParams = deepClone(catalogItem?.default_params || {});
        const params = block.params && typeof block.params === 'object' ? block.params : {};

        return {
            ...block,
            params: {
                ...defaultParams,
                ...params,
            },
        };
    };

    const enforceRouteBlockConstraints = (routeKey = getCurrentRouteKey()) => {
        const fixedCatalogItems = getFixedCatalogItems();
        const requiredCatalogItems = getRequiredCatalogItems();
        const catalogOrder = new Map(
            blockCatalog
                .filter((item) => item && typeof item.id === 'string')
                .map((item, index) => [item.id, index]),
        );

        const uniqueIds = new Set();
        const blocks = normalizeBlocksList(getRouteBlocks(routeKey))
            .filter((block) => Boolean(getCatalogItem(block.id)))
            .map((block) => {
                if (isUniqueBlockId(block.id) && uniqueIds.has(block.id)) {
                    return null;
                }

                if (isUniqueBlockId(block.id)) {
                    uniqueIds.add(block.id);
                }

                return enrichParamsWithDefaults(block);
            })
            .filter(Boolean);

        requiredCatalogItems.forEach((item) => {
            if (uniqueIds.has(item.id)) {
                return;
            }

            uniqueIds.add(item.id);
            blocks.push({
                id: item.id,
                order: 0,
                params: deepClone(item.default_params || {}),
            });
        });

        const startBlocks = [];
        const endBlocks = [];
        const dynamicBlocks = [];

        blocks.forEach((block) => {
            if (!isFixedBlockId(block.id)) {
                dynamicBlocks.push(block);
                return;
            }

            const anchor = getBlockAnchor(block.id);
            if (anchor === 'start') {
                startBlocks.push(block);
                return;
            }

            endBlocks.push(block);
        });

        const sortByCatalogOrder = (a, b) => (catalogOrder.get(a.id) ?? 0) - (catalogOrder.get(b.id) ?? 0);
        startBlocks.sort(sortByCatalogOrder);
        endBlocks.sort(sortByCatalogOrder);

        const constrained = [...startBlocks, ...dynamicBlocks, ...endBlocks];
        reindexBlocksList(constrained);
        state.page.blocks[routeKey] = constrained;
    };

    const fallbackBlockIdsForRoute = (routeKey = getCurrentRouteKey()) => {
        const defaultBlocks = normalizeBlocksList(defaultState.page?.blocks?.[routeKey] || []);
        if (defaultBlocks.length > 0) {
            return withSystemBlocks(
                defaultBlocks
                    .map((block) => block.id)
                    .filter((id) => Boolean(getCatalogItem(id)))
            );
        }

        return withSystemBlocks(['page_content'].filter((id) => Boolean(getCatalogItem(id))));
    };

    const seedCurrentRouteBlocks = () => {
        const routeKey = getCurrentRouteKey();
        const rawBlocks = normalizeBlocksList(getRouteBlocks(routeKey));
        const defaultIdsForRoute = fallbackBlockIdsForRoute(routeKey);
        const shouldIncludePageContent = defaultIdsForRoute.includes('page_content');
        const currentBlocks = rawBlocks
            .filter((block) => Boolean(getCatalogItem(block.id)))
            .filter((block) => shouldIncludePageContent || block.id !== 'page_content');
        const hasPageContentBlock = currentBlocks.some((block) => block.id === 'page_content');
        if (shouldIncludePageContent && !hasPageContentBlock && getCatalogItem('page_content')) {
            currentBlocks.push({
                id: 'page_content',
                order: currentBlocks.length + 1,
                params: deepClone(getCatalogItem('page_content')?.default_params || {}),
            });
        }
        const hadInvalidBlocks = rawBlocks.length !== currentBlocks.length;
        const hasContentBlocks = currentBlocks.some((block) => !isFixedBlockId(block.id));

        if (currentBlocks.length > 0 && (hasContentBlocks || !hadInvalidBlocks)) {
            state.page.blocks[routeKey] = currentBlocks;
            return false;
        }

        const blockIds = [];
        const seen = new Set();
        const container = findBlockContainer();

        if (container) {
            queryAllAttr(container, 'block').forEach((element) => {
                const id = normalizeBlockId(readAttrValue(element, 'block'));
                if (!id || seen.has(id) || !getCatalogItem(id)) {
                    return;
                }

                seen.add(id);
                blockIds.push(id);
            });
        }

        if (!blockIds.length) {
            fallbackBlockIdsForRoute(routeKey)
                .filter((id) => Boolean(getCatalogItem(id)))
                .forEach((id) => blockIds.push(id));
        } else {
            withSystemBlocks(blockIds).forEach((id) => {
                if (!blockIds.includes(id) && getCatalogItem(id)) {
                    blockIds.push(id);
                }
            });
        }

        if (!blockIds.length) {
            return false;
        }

        state.page.blocks[routeKey] = blockIds.map((id, index) => ({
            id,
            order: index + 1,
            params: deepClone(getCatalogItem(id)?.default_params || {}),
        }));

        enforceRouteBlockConstraints(routeKey);

        return true;
    };

    const renderCatalog = () => {
        ui.catalogContainer.innerHTML = '';
        const activeBlockIds = new Set(getRouteBlocks().map((block) => String(block.id || '')));

        blockCatalog.forEach((item) => {
            const isAddable = isBlockAddable(item.id);
            const isUniqueAndAlreadyAdded = isUniqueBlockId(item.id) && activeBlockIds.has(String(item.id || ''));
            const column = document.createElement('div');
            column.className = 'col-12 col-md-6';
            const article = document.createElement('article');
            article.className = 'te-block-item';
            article.innerHTML = `
                <div class="te-block-head">
                    <strong class="te-block-name">${item.label}</strong>
                    <small class="te-block-id">${item.id}</small>
                </div>
                <div class="te-block-actions">
                    <button type="button" class="te-btn te-btn-success">${t('common.add', 'Ajouter')}</button>
                </div>
            `;

            const addButton = article.querySelector('button');
            if (!addButton) {
                column.appendChild(article);
                ui.catalogContainer.appendChild(column);
                return;
            }

            if (!isAddable || isUniqueAndAlreadyAdded) {
                addButton.disabled = true;
                addButton.classList.remove('te-btn-success');
                addButton.classList.add('te-btn-ghost');
                addButton.textContent = isUniqueAndAlreadyAdded
                    ? t('messages.already_added', 'Déjà ajouté')
                    : t('common.system', 'Système');
                column.appendChild(article);
                ui.catalogContainer.appendChild(column);
                return;
            }

            addButton.addEventListener('click', () => {
                const blocks = getRouteBlocks();
                const params = deepClone(item.default_params || {});
                blocks.push({
                    id: item.id,
                    order: nextBlockOrder(),
                    params,
                });

                reindexBlocksList(blocks);
                enforceRouteBlockConstraints(getCurrentRouteKey());
                if (typeof onRouteBlocksMutated === 'function') {
                    onRouteBlocksMutated();
                }
                renderActiveBlocks();
                applyLivePreview({
                    markDirty: true,
                    message: t('messages.block_added', 'Bloc "{label}" ajouté sur {route}', {
                        label: item.label,
                        route: getCurrentRouteLabel(),
                    }),
                });
                closeCatalogModal();
            });

            column.appendChild(article);
            ui.catalogContainer.appendChild(column);
        });
    };

    const renderActiveBlocks = () => {
        renderCatalog();
        ui.activeBlocksContainer.innerHTML = '';
        const blocks = getRouteBlocks();

        if (!blocks.length) {
            const empty = document.createElement('p');
            empty.className = 'te-help';
            empty.textContent = t('messages.no_active_block_for_route', 'Aucun bloc actif pour {route}.', {
                route: getCurrentRouteLabel(),
            });
            ui.activeBlocksContainer.appendChild(empty);
            clearPageDragState();
            return;
        }

        blocks.forEach((block, index) => {
            const catalogItem = getCatalogItem(block.id);
            const fragment = ui.activeBlockTemplate.content.cloneNode(true);
            const article = fragment.querySelector('.te-block-item');
            const canMove = canMoveBlockId(block.id);
            const canEdit = canEditBlockId(block.id);
            const canDelete = canDeleteBlockId(block.id);
            const canDuplicate = canDuplicateBlockId(block.id);

            article.querySelector('.te-block-name').textContent = catalogItem ? catalogItem.label : block.id;
            article.querySelector('.te-block-id').textContent = t('page.block_number', 'Bloc {index}', {
                index: index + 1,
            });
            article.draggable = canMove;
            article.title = canMove
                ? t('page.block_actions.drag', 'Déplacer le bloc')
                : '';
            article.classList.toggle('is-draggable', canMove);
            article.classList.toggle('is-dragging', pageDragSourceIndex === index);
            article.classList.toggle('is-drop-target-before', pageDragTargetIndex === index && pageDragTargetPosition === 'before');
            article.classList.toggle('is-drop-target-after', pageDragTargetIndex === index && pageDragTargetPosition === 'after');

            article.querySelectorAll('[data-action]').forEach((button) => {
                const action = button.dataset.action;
                if ((action === 'up' || action === 'down') && !canMove) {
                    button.hidden = true;
                }
                if (action === 'edit' && !canEdit) {
                    button.hidden = true;
                }
                if (action === 'delete' && !canDelete) {
                    button.hidden = true;
                }
                if (action === 'duplicate' && !canDuplicate) {
                    button.hidden = true;
                }

                button.addEventListener('click', () => {
                    const actionName = button.dataset.action;
                    const routeBlocks = getRouteBlocks();

                    if ((actionName === 'up' || actionName === 'down') && !canMove) {
                        return;
                    }
                    if (actionName === 'edit' && !canEdit) {
                        return;
                    }
                    if (actionName === 'delete' && !canDelete) {
                        return;
                    }
                    if (actionName === 'duplicate' && !canDuplicate) {
                        return;
                    }

                    if (actionName === 'up' && index > 0) {
                        const moved = routeBlocks.splice(index, 1)[0];
                        routeBlocks.splice(index - 1, 0, moved);
                    }

                    if (actionName === 'down' && index < routeBlocks.length - 1) {
                        const moved = routeBlocks.splice(index, 1)[0];
                        routeBlocks.splice(index + 1, 0, moved);
                    }

                    if (actionName === 'delete') {
                        routeBlocks.splice(index, 1);
                    }

                    if (actionName === 'duplicate') {
                        const duplicated = deepClone(routeBlocks[index]);
                        duplicated.order = nextBlockOrder();
                        routeBlocks.splice(index + 1, 0, duplicated);
                    }

                    if (actionName === 'edit') {
                        openBlockModal(index);
                        return;
                    }

                    reindexBlocksList(routeBlocks);
                    enforceRouteBlockConstraints(getCurrentRouteKey());
                    if (typeof onRouteBlocksMutated === 'function') {
                        onRouteBlocksMutated();
                    }
                    renderActiveBlocks();
                    applyLivePreview({
                        markDirty: true,
                        message: t('messages.blocks_reordered', 'Ordre des blocs mis à jour sur {route}', {
                            route: getCurrentRouteLabel(),
                        }),
                    });
                });
            });

            if (canMove) {
                article.addEventListener('dragstart', (event) => {
                    pageDragSourceIndex = index;
                    pageDragTargetIndex = index;
                    pageDragTargetPosition = 'before';
                    syncPageDragState();

                    if (event.dataTransfer) {
                        event.dataTransfer.effectAllowed = 'move';
                        event.dataTransfer.setData('text/plain', String(block.id || ''));
                    }
                });

                article.addEventListener('dragover', (event) => {
                    if (pageDragSourceIndex == null || pageDragSourceIndex === index) {
                        return;
                    }

                    event.preventDefault();
                    const rect = article.getBoundingClientRect();
                    const position = event.clientY - rect.top > rect.height / 2 ? 'after' : 'before';
                    pageDragTargetIndex = index;
                    pageDragTargetPosition = position;
                    syncPageDragState();
                });

                article.addEventListener('drop', (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    if (pageDragSourceIndex == null) {
                        return;
                    }

                    const sourceIndex = pageDragSourceIndex;
                    const destinationIndex = pageDragTargetPosition === 'after' ? index + 1 : index;
                    clearPageDragState();
                    reorderRouteBlock(sourceIndex, destinationIndex);
                });

                article.addEventListener('dragend', () => {
                    clearPageDragState();
                    syncPageDragState();
                });
            }

            ui.activeBlocksContainer.appendChild(fragment);
        });

        if (!ui.activeBlocksContainer.dataset.pageDragBound) {
            ui.activeBlocksContainer.dataset.pageDragBound = '1';

            ui.activeBlocksContainer.addEventListener('dragover', (event) => {
                if (pageDragSourceIndex == null) {
                    return;
                }

                if (event.target === ui.activeBlocksContainer) {
                    event.preventDefault();
                    const routeBlocks = getRouteBlocks();
                    pageDragTargetIndex = Math.max(0, routeBlocks.length - 1);
                    pageDragTargetPosition = 'after';
                    syncPageDragState();
                }
            });

            ui.activeBlocksContainer.addEventListener('drop', (event) => {
                if (pageDragSourceIndex == null) {
                    return;
                }

                if (event.target === ui.activeBlocksContainer) {
                    event.preventDefault();
                    const sourceIndex = pageDragSourceIndex;
                    const routeBlocks = getRouteBlocks();
                    clearPageDragState();
                    reorderRouteBlock(sourceIndex, routeBlocks.length);
                }
            });
        }
    };

    const openCatalogModal = () => {
        if (!ui.catalogModal) {
            return;
        }

        ui.catalogModal.hidden = false;
    };

    const closeCatalogModal = () => {
        if (!ui.catalogModal) {
            return;
        }

        ui.catalogModal.hidden = true;
    };

    const closeBlockModal = () => {
        modalBlockIndex = null;
        ui.modal.hidden = true;
        ui.modalBody.innerHTML = '';
    };

    const escapeHtml = (value) => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#39;');

    const renderIconMarkup = (value) => {
        const raw = String(value || '').trim();
        if (!raw) {
            return '★';
        }

        const isBootstrapIcon = /(^|\s)bi(\s|$)/.test(raw);
        if (isBootstrapIcon) {
            return `<i class="${escapeHtml(raw)}" aria-hidden="true"></i>`;
        }

        return escapeHtml(raw);
    };

    const findDomBlockForRouteIndex = (routeIndex) => {
        const blocks = getRouteBlocks();
        const block = blocks[routeIndex];
        if (!block) {
            return null;
        }

        const selector = selectorForAttrValue('block', block.id);
        const sameIdElements = selector ? Array.from(document.querySelectorAll(selector)) : [];
        if (!sameIdElements.length) {
            return null;
        }

        let occurrence = 0;
        for (let i = 0; i <= routeIndex; i++) {
            if (blocks[i]?.id === block.id) {
                occurrence++;
            }
        }

        return sameIdElements[occurrence - 1] || sameIdElements[0] || null;
    };

    const parseJsonDataset = (value, fallback) => {
        if (typeof value !== 'string' || value.trim() === '') {
            return deepClone(fallback);
        }

        try {
            return JSON.parse(value);
        } catch (error) {
            return deepClone(fallback);
        }
    };

    const getBlockFormTemplate = (blockId) => {
        if (!ui.blockForms || typeof blockId !== 'string' || blockId.trim() === '') {
            return null;
        }

        const safeBlockId = String(blockId).replace(/"/g, '\\"');
        return ui.blockForms.querySelector(`template[data-te-block-form="${safeBlockId}"]`);
    };

    const updateListItemTitles = (listEditor) => {
        Array.from(listEditor.querySelectorAll('[data-list-item]')).forEach((itemNode, index) => {
            const titleNode = itemNode.querySelector('.te-list-item-title');
            if (titleNode) {
                titleNode.textContent = t('modal.item_number', 'Élément {index}', {
                    index: index + 1,
                });
            }
        });
    };

    const getListEditorDefinitions = (listEditor) => {
        const parsed = parseJsonDataset(listEditor.dataset.listDefinitions, []);
        return Array.isArray(parsed)
            ? parsed.filter((item) => item && typeof item === 'object' && typeof item.key === 'string' && item.key.length > 0)
            : [];
    };

    const getListEditorDefaults = (listEditor) => {
        const parsed = parseJsonDataset(listEditor.dataset.listDefaults, {});
        return parsed && typeof parsed === 'object' && !Array.isArray(parsed)
            ? parsed
            : {};
    };

    const createListItemNode = (listEditor, itemValue = {}) => {
        const itemDefinitions = getListEditorDefinitions(listEditor);
        const itemDefaults = getListEditorDefaults(listEditor);
        const mergedItem = {
            ...itemDefaults,
            ...(itemValue && typeof itemValue === 'object' ? itemValue : {}),
        };

        const itemNode = document.createElement('article');
        itemNode.className = 'te-list-item';
        itemNode.dataset.listItem = '1';

        const itemHead = document.createElement('div');
        itemHead.className = 'te-list-item-head';

        const itemTitle = document.createElement('strong');
        itemTitle.className = 'te-list-item-title';
        itemTitle.textContent = t('modal.item', 'Élément');

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'te-btn te-btn-danger';
        removeButton.dataset.listRemove = '1';
        removeButton.textContent = t('common.delete', 'Supprimer');

        itemHead.append(itemTitle, removeButton);
        itemNode.appendChild(itemHead);

        const itemBody = document.createElement('div');
        itemBody.className = 'te-list-item-body';

        itemDefinitions.forEach((itemDefinition) => {
            const fieldKey = String(itemDefinition.key || '').trim();
            if (!fieldKey) {
                return;
            }

            const fieldType = String(itemDefinition.type || 'text').trim() || 'text';
            const wrapper = document.createElement('label');
            wrapper.className = fieldType === 'toggle' ? 'te-field te-field-inline' : 'te-field';

            const label = document.createElement('span');
            label.className = 'te-field-label';
            label.textContent = String(itemDefinition.label || fieldKey);
            wrapper.appendChild(label);

            let input;
            if (fieldType === 'textarea') {
                input = document.createElement('textarea');
                input.rows = 3;
                input.value = mergedItem[fieldKey] == null ? '' : String(mergedItem[fieldKey]);
            } else if (fieldType === 'select') {
                input = document.createElement('select');
                const options = Array.isArray(itemDefinition.options) ? itemDefinition.options : [];
                const currentValue = mergedItem[fieldKey] == null ? '' : String(mergedItem[fieldKey]);

                options.forEach((optionValue) => {
                    const option = document.createElement('option');
                    option.value = String(optionValue);
                    option.textContent = String(optionValue);
                    option.selected = String(optionValue) === currentValue;
                    input.appendChild(option);
                });

                if (currentValue && !options.some((optionValue) => String(optionValue) === currentValue)) {
                    const fallbackOption = document.createElement('option');
                    fallbackOption.value = currentValue;
                    fallbackOption.textContent = currentValue;
                    fallbackOption.selected = true;
                    input.appendChild(fallbackOption);
                }
            } else {
                input = document.createElement('input');
                input.type = fieldType === 'toggle' ? 'checkbox' : (fieldType === 'number' ? 'number' : 'text');

                if (fieldType === 'number') {
                    if (itemDefinition.min != null) {
                        input.min = String(itemDefinition.min);
                    }
                    if (itemDefinition.max != null) {
                        input.max = String(itemDefinition.max);
                    }
                    input.value = mergedItem[fieldKey] == null ? '' : String(mergedItem[fieldKey]);
                } else if (fieldType === 'toggle') {
                    input.checked = Boolean(mergedItem[fieldKey]);
                } else {
                    input.value = mergedItem[fieldKey] == null ? '' : String(mergedItem[fieldKey]);
                }
            }

            input.className = 'te-input';
            input.dataset.listField = fieldKey;
            input.dataset.listFieldType = fieldType;
            wrapper.appendChild(input);
            itemBody.appendChild(wrapper);
        });

        itemNode.appendChild(itemBody);
        return itemNode;
    };

    const hydrateListEditor = (listEditor, value) => {
        const itemsContainer = listEditor.querySelector('[data-list-items]');
        if (!itemsContainer) {
            return;
        }

        itemsContainer.innerHTML = '';
        const normalizedItems = Array.isArray(value) ? value : [];
        normalizedItems.forEach((item) => {
            itemsContainer.appendChild(createListItemNode(listEditor, item));
        });

        updateListItemTitles(listEditor);
    };

    const bindListEditor = (listEditor) => {
        if (listEditor.dataset.listBound === '1') {
            return;
        }
        listEditor.dataset.listBound = '1';

        const addButton = listEditor.querySelector('[data-list-add]');
        if (addButton) {
            addButton.addEventListener('click', (event) => {
                event.preventDefault();
                const itemsContainer = listEditor.querySelector('[data-list-items]');
                if (!itemsContainer) {
                    return;
                }

                const defaults = getListEditorDefaults(listEditor);
                itemsContainer.appendChild(createListItemNode(listEditor, defaults));
                updateListItemTitles(listEditor);
            });
        }

        listEditor.addEventListener('click', (event) => {
            const removeButton = event.target instanceof Element
                ? event.target.closest('[data-list-remove]')
                : null;
            if (!removeButton || !listEditor.contains(removeButton)) {
                return;
            }

            event.preventDefault();
            const itemNode = removeButton.closest('[data-list-item]');
            if (itemNode) {
                itemNode.remove();
                updateListItemTitles(listEditor);
            }
        });
    };

    const collectListEditorValue = (listEditor) => {
        const itemDefinitions = getListEditorDefinitions(listEditor);
        const itemNodes = Array.from(listEditor.querySelectorAll('[data-list-item]'));

        return itemNodes.map((itemNode) => {
            const item = {};
            itemDefinitions.forEach((itemDefinition) => {
                const fieldKey = String(itemDefinition.key || '').trim();
                if (!fieldKey) {
                    return;
                }

                const input = itemNode.querySelector(`[data-list-field="${fieldKey}"]`);
                if (!input) {
                    return;
                }

                const fieldType = String(itemDefinition.type || input.dataset.listFieldType || 'text').trim() || 'text';
                if (fieldType === 'toggle') {
                    item[fieldKey] = Boolean(input.checked);
                    return;
                }

                if (fieldType === 'number') {
                    const numberValue = Number(input.value);
                    item[fieldKey] = Number.isFinite(numberValue) ? numberValue : 0;
                    return;
                }

                item[fieldKey] = String(input.value || '');
            });
            return item;
        });
    };

    const hydrateBlockModalFields = (catalogItem, blockParams) => {
        const definitions = Array.isArray(catalogItem?.params) ? catalogItem.params : [];
        const params = blockParams && typeof blockParams === 'object' ? blockParams : {};

        definitions.forEach((definition) => {
            if (!definition || typeof definition !== 'object' || typeof definition.key !== 'string') {
                return;
            }

            const field = ui.modalBody.querySelector(`[data-block-param="${definition.key}"]`);
            if (!field) {
                return;
            }

            const type = String(field.dataset.blockType || definition.type || 'text').trim() || 'text';
            const value = Object.prototype.hasOwnProperty.call(params, definition.key)
                ? params[definition.key]
                : undefined;

            if (type === 'toggle') {
                field.checked = Boolean(value);
                return;
            }

            if (type === 'number') {
                field.value = value == null ? '' : String(value);
                return;
            }

            if (type === 'list') {
                bindListEditor(field);
                hydrateListEditor(field, value);
                return;
            }

            if (type === 'select' || type === 'image') {
                const normalized = value == null ? '' : String(value);
                const options = Array.from(field.options || []);
                const exists = options.some((option) => String(option.value) === normalized);
                if (!exists && normalized) {
                    const fallbackOption = document.createElement('option');
                    fallbackOption.value = normalized;
                    fallbackOption.textContent = `${normalized} (valeur actuelle)`;
                    fallbackOption.selected = true;
                    field.appendChild(fallbackOption);
                }
                field.value = normalized;
                if (type === 'image') {
                    updateImagePreviewForSelect(field);
                }
                return;
            }

            field.value = value == null ? '' : String(value);
        });

        Array.from(ui.modalBody.querySelectorAll('.te-field-advanced')).forEach((node) => {
            node.hidden = !isAdvancedModeActive();
        });
    };

    const openBlockModal = (index) => {
        const blocks = getRouteBlocks();
        const block = blocks[index];
        const catalogItem = block ? getCatalogItem(block.id) : null;

        if (!block || !catalogItem || !canEditBlockId(block.id)) {
            return;
        }

        modalBlockIndex = index;
        ui.modalTitle.textContent = t('modal.configure_block', 'Configurer le bloc');
        ui.modalBody.innerHTML = '';

        const formTemplate = getBlockFormTemplate(block.id);
        if (formTemplate instanceof HTMLTemplateElement) {
            ui.modalBody.appendChild(formTemplate.content.cloneNode(true));
        } else {
            const empty = document.createElement('p');
            empty.className = 'te-help mb-0';
            empty.textContent = t('messages.empty_block_form', 'Aucun formulaire disponible pour ce bloc.');
            ui.modalBody.appendChild(empty);
        }

        hydrateBlockModalFields(catalogItem, block.params || {});
        ui.modal.hidden = false;
        refreshImagePreviews();
    };

    const saveBlockModal = () => {
        if (modalBlockIndex == null) {
            return;
        }

        const blocks = getRouteBlocks();
        const block = blocks[modalBlockIndex];
        const catalogItem = block ? getCatalogItem(block.id) : null;
        if (!block || !catalogItem || !canEditBlockId(block.id)) {
            closeBlockModal();
            return;
        }

        const params = {};

        for (const definition of catalogItem.params || []) {
            if (!definition || typeof definition !== 'object' || typeof definition.key !== 'string') {
                continue;
            }

            const field = ui.modalBody.querySelector(`[data-block-param="${definition.key}"]`);
            if (!field) {
                continue;
            }

            const type = String(field.dataset.blockType || definition.type || 'text').trim() || 'text';
            if (type === 'toggle') {
                params[definition.key] = Boolean(field.checked);
                continue;
            }

            if (type === 'number') {
                const numberValue = Number(field.value);
                params[definition.key] = Number.isFinite(numberValue) ? numberValue : 0;
                continue;
            }

            if (type === 'list') {
                params[definition.key] = collectListEditorValue(field);
                continue;
            }

            params[definition.key] = String(field.value || '');
        }

        block.params = params;
        updateBlockDomPreview(modalBlockIndex);
        closeBlockModal();
        renderActiveBlocks();
        applyLivePreview({
            markDirty: true,
            message: t('messages.block_updated', 'Bloc "{label}" mis à jour sur {route}', {
                label: catalogItem.label,
                route: getCurrentRouteLabel(),
            }),
        });
    };

    const ensureLiveStyleTag = () => {
        const styleId = runtime.runtime_ids.live_style || 'theme-editor-live';
        let styleTag = document.getElementById(styleId);
        if (!styleTag) {
            styleTag = document.createElement('style');
            styleTag.id = styleId;
            document.head.appendChild(styleTag);
        }
        return styleTag;
    };

    const resolveBackground = (value) => {
        if (!value || typeof value !== 'string' || value.trim().length === 0) {
            return 'none';
        }

        const cleaned = value.trim();
        const resolved = imageUrlByFile.get(cleaned) || cleaned;
        return `url("${resolved.replace(/"/g, '\\"')}")`;
    };

    const buildThemeVariableMap = (colors, backgroundValue) => {
        const primary = normalizeHex(colors.primary, '#00b7ff');
        const secondary = normalizeHex(colors.secondary, '#c8cccd');
        const tertiary = normalizeHex(colors.tertiary, '#f8ca47');
        const quaternary = normalizeHex(colors.quaternary, '#ecaf2d');
        const background = normalizeHex(colors.background, '#f2f2f2');
        const darkTone1 = normalizeHex(colors.dark_tone_1, '#111827');
        const darkTone2 = normalizeHex(colors.dark_tone_2, '#0f172a');
        const lightTone1 = normalizeHex(colors.light_tone_1, '#f8fafc');
        const textBackground = normalizeHex(colors.text_background, '#ffffff');
        const textColor = normalizeHex(colors.text, '#111111');
        const textColorRgb = toRgb(textColor);
        const success = normalizeHex(colors.alert_success, '#16a34a');
        const info = normalizeHex(colors.alert_info, '#0ea5e9');
        const warning = normalizeHex(colors.alert_warning, '#f59e0b');
        const error = normalizeHex(colors.alert_error, '#dc2626');

        return {
            '--bs-primary': primary,
            '--bs-primary-rgb': toRgb(primary),
            '--bs-primary-text-emphasis': contrastColor(primary),
            '--bs-secondary': secondary,
            '--bs-secondary-rgb': toRgb(secondary),
            '--bs-secondary-text-emphasis': contrastColor(secondary),
            '--bs-tertiary': tertiary,
            '--bs-tertiary-rgb': toRgb(tertiary),
            '--bs-tertiary-text-emphasis': contrastColor(tertiary),
            '--bs-quaternary': quaternary,
            '--bs-quaternary-rgb': toRgb(quaternary),
            '--bs-quaternary-text-emphasis': contrastColor(quaternary),
            '--bs-success': success,
            '--bs-success-rgb': toRgb(success),
            '--bs-info': info,
            '--bs-info-rgb': toRgb(info),
            '--bs-warning': warning,
            '--bs-warning-rgb': toRgb(warning),
            '--bs-danger': error,
            '--bs-danger-rgb': toRgb(error),
            '--bs-light': lightTone1,
            '--bs-light-rgb': toRgb(lightTone1),
            '--bs-dark': darkTone1,
            '--bs-dark-rgb': toRgb(darkTone1),
            '--bs-body-bg': background,
            '--bs-body-bg-rgb': toRgb(background),
            '--bs-body-color': textColor,
            '--bs-body-color-rgb': textColorRgb,
            '--bs-white': textColor,
            '--bs-white-rgb': textColorRgb,
            '--bs-emphasis-color': textColor,
            '--bs-emphasis-color-rgb': textColorRgb,
            '--bs-heading-color': textColor,
            '--bs-secondary-color': `rgba(${textColorRgb}, 0.78)`,
            '--bs-secondary-color-rgb': textColorRgb,
            '--bs-tertiary-color': `rgba(${textColorRgb}, 0.62)`,
            '--bs-tertiary-color-rgb': textColorRgb,
            '--bs-secondary-bg': lightTone1,
            '--bs-secondary-bg-rgb': toRgb(lightTone1),
            '--bs-tertiary-bg': textBackground,
            '--bs-tertiary-bg-rgb': toRgb(textBackground),
            '--bs-border-color': darkTone2,
            '--te-dark-tone-1': darkTone1,
            '--te-dark-tone-2': darkTone2,
            '--bs-link-color': primary,
            '--bs-link-color-rgb': toRgb(primary),
            '--bs-link-hover-color': quaternary,
            '--bs-link-hover-color-rgb': toRgb(quaternary),
            '--te-live-tertiary': tertiary,
            '--te-bg-image': backgroundValue,
        };
    };

    const buildBootstrapBridgeCss = () => `
.text-primary {
    color: var(--bs-primary) !important;
}

.bg-primary {
    background-color: var(--bs-primary) !important;
}

.border-primary {
    border-color: var(--bs-primary) !important;
}

.link-primary {
    color: var(--bs-primary) !important;
}

.link-primary:hover,
.link-primary:focus {
    color: var(--bs-link-hover-color) !important;
}
`;

    const buildThemeCss = (themeName, colors, backgroundValue) => {
        const variables = buildThemeVariableMap(colors, backgroundValue);
        const variableLines = Object.entries(variables)
            .map(([name, value]) => `    ${name}: ${value};`)
            .join('\n');

        return `
[data-bs-theme="${themeName}"] {
${variableLines}
}
`;
    };

    const renderLiveCss = () => {
        const light = state.styles.colors.light || {};
        const dark = state.styles.colors.dark || {};
        const bgLight = resolveBackground(state.styles.bg_light);
        const bgDark = resolveBackground(state.styles.bg_dark);
        const advancedEnabled = isAdvancedModeActive();

        const bodyFontName = String(state.styles.font_body_name || '').trim();
        const headingFontName = String(state.styles.font_heading_name || '').trim();
        const bodyFontFamily = advancedEnabled && state.styles.font_custom_enabled && bodyFontName
            ? `"${bodyFontName.replace(/"/g, '\\"')}", sans-serif`
            : 'var(--bs-font-sans-serif)';
        const headingFontFamily = advancedEnabled && state.styles.font_custom_enabled && headingFontName
            ? `"${headingFontName.replace(/"/g, '\\"')}", sans-serif`
            : 'var(--bs-font-sans-serif)';

        const styleTag = ensureLiveStyleTag();
        styleTag.textContent = `
:root {
    --te-font-body: ${bodyFontFamily};
    --te-font-heading: ${headingFontFamily};
    --bs-main-font: var(--te-font-body);
    --bs-body-font-family: var(--te-font-body);
    --bs-btn-font-family: var(--te-font-body);
    --te-bg-light: ${bgLight};
    --te-bg-dark: ${bgDark};
}
${buildThemeCss('light', light, 'var(--te-bg-light)')}
${buildThemeCss('dark', dark, 'var(--te-bg-dark)')}
${buildBootstrapBridgeCss()}
body {
    font-family: var(--te-font-body);
    color: var(--bs-body-color);
    background-color: var(--bs-body-bg);
    background-image: var(--te-bg-image);
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}
h1, h2, h3, h4, h5, h6,
.h1, .h2, .h3, .h4, .h5, .h6 {
    font-family: var(--te-font-heading);
}
button, input, select, textarea,
.btn, .form-control, .form-select {
    font-family: var(--te-font-body);
}
`;
    };

    const applyThemeMode = () => {
        const darkLightDisabled = toBoolean(state.styles.theme_dark_disabled, false);
        if (!darkLightDisabled) {
            return;
        }

        const forcedMode = state.styles.theme_priority === 'light' ? 'light' : 'dark';
        document.body.setAttribute('data-bs-theme', forcedMode);
    };

    const applyFontLink = () => {
        const linkIdBase = runtime.runtime_ids.font_link || 'theme-editor-font-link';
        const previousBody = document.getElementById(`${linkIdBase}-body`);
        const previousHeading = document.getElementById(`${linkIdBase}-heading`);
        if (previousBody) {
            previousBody.remove();
        }
        if (previousHeading) {
            previousHeading.remove();
        }

        if (!isAdvancedModeActive() || !state.styles.font_custom_enabled) {
            return;
        }

        const bodyFontName = String(state.styles.font_body_name || '').trim();
        const headingFontName = String(state.styles.font_heading_name || '').trim();
        const bodyUrl = String(state.styles.font_body_url || '').trim();
        const headingUrl = String(state.styles.font_heading_url || '').trim();
        const urls = Array.from(new Set([
            bodyFontName && bodyUrl ? bodyUrl : '',
            headingFontName && headingUrl ? headingUrl : '',
        ].filter((value) => value.length > 0)));

        urls.forEach((url, index) => {
            const link = document.createElement('link');
            link.id = index === 0 ? `${linkIdBase}-body` : `${linkIdBase}-heading`;
            link.rel = 'stylesheet';
            link.href = url;
            document.head.appendChild(link);
        });
    };

    const resolveTopStackContainer = () => {
        const selector = selectorForAttrValue('node', 'layout-top-stack');
        const node = selector ? document.querySelector(selector) : null;

        return node instanceof HTMLElement ? node : document.body;
    };

    const applyAnnounceBar = () => {
        const id = runtime.runtime_ids.announce_bar || 'theme-editor-announce-bar';
        const existing = document.getElementById(id);
        const config = state.modules.announce_bar || {};
        const advancedEnabled = isAdvancedModeActive();

        if (!advancedEnabled || !config.enabled) {
            if (existing) {
                existing.remove();
            }
            return;
        }

        const bar = existing || document.createElement('div');
        const topStack = resolveTopStackContainer();
        const progressId = runtime.runtime_ids.scroll_progress || 'theme-editor-scroll-progress';
        const progressNode = topStack.querySelector(`#${progressId}`);
        bar.id = id;
        bar.style.position = 'relative';
        bar.style.top = '';
        bar.style.left = '';
        bar.style.right = '';
        bar.style.width = '100%';
        bar.style.padding = '0.5rem 1rem';
        bar.style.textAlign = 'center';
        bar.style.fontSize = '0.85rem';
        bar.style.background = normalizeHex(config.background_color, '#1a1a2e');
        bar.style.color = '#ffffff';
        bar.style.zIndex = '1050';
        bar.style.boxShadow = '0 6px 20px rgba(15, 23, 42, 0.25)';
        const announceText = typeof config.text === 'string' && config.text.trim().length > 0
            ? config.text
            : 'Barre d’annonce';
        bar.textContent = resolveTemplateVariables(announceText);

        if (bar.parentElement !== topStack) {
            topStack.prepend(bar);
        }

        if (progressNode instanceof HTMLElement) {
            progressNode.insertAdjacentElement('afterend', bar);
        } else if (topStack.firstElementChild !== bar) {
            topStack.prepend(bar);
        }
    };

    const applyScrollProgress = () => {
        const id = runtime.runtime_ids.scroll_progress || 'theme-editor-scroll-progress';
        let rootBar = document.getElementById(id);
        const topStack = resolveTopStackContainer();
        const config = state.modules.scroll_progress || {};
        const advancedEnabled = isAdvancedModeActive();

        if (!advancedEnabled || !config.enabled) {
            if (rootBar) {
                rootBar.remove();
            }
            if (scrollHandler) {
                window.removeEventListener('scroll', scrollHandler);
                scrollHandler = null;
            }
            return;
        }

        if (!rootBar) {
            rootBar = document.createElement('div');
            rootBar.id = id;
            rootBar.innerHTML = '<span></span>';
            topStack.prepend(rootBar);
        }

        if (rootBar.parentElement !== topStack) {
            topStack.prepend(rootBar);
        } else if (topStack.firstElementChild !== rootBar) {
            topStack.prepend(rootBar);
        }

        rootBar.style.position = 'sticky';
        rootBar.style.top = '0';
        rootBar.style.left = '';
        rootBar.style.right = '';
        rootBar.style.width = '100%';
        rootBar.style.height = `${Math.max(2, Math.min(20, Number(config.height) || 8))}px`;
        rootBar.style.background = normalizeHex(config.background_color, '#1a1a2e');
        rootBar.style.zIndex = '1060';

        const indicator = rootBar.querySelector('span');
        indicator.style.display = 'block';
        indicator.style.width = '0';
        indicator.style.height = '100%';
        indicator.style.background = normalizeHex(config.color, '#6c63ff');

        if (scrollHandler) {
            window.removeEventListener('scroll', scrollHandler);
        }

        scrollHandler = () => {
            const scrollable = document.documentElement.scrollHeight - window.innerHeight;
            const ratio = scrollable > 0 ? (window.scrollY / scrollable) * 100 : 0;
            indicator.style.width = `${Math.max(0, Math.min(100, ratio))}%`;
        };

        window.addEventListener('scroll', scrollHandler, { passive: true });
        scrollHandler();
    };

    const toBoundedNumber = (value, fallback, min, max) => {
        const parsed = Number(value);
        if (!Number.isFinite(parsed)) {
            return fallback;
        }

        return Math.max(min, Math.min(max, parsed));
    };

    const resolveImageUrl = (value) => {
        if (!value || typeof value !== 'string') {
            return '';
        }

        const cleaned = value.trim();
        if (!cleaned) {
            return '';
        }

        return String(imageUrlByFile.get(cleaned) || cleaned);
    };

    const ensureImagePreviewNode = (select) => {
        if (!(select instanceof HTMLSelectElement)) {
            return null;
        }

        const field = select.closest('.te-field');
        if (!field) {
            return null;
        }

        let preview = field.querySelector('[data-te-image-preview]');
        if (!preview) {
            preview = document.createElement('figure');
            preview.className = 'te-image-preview';
            preview.dataset.teImagePreview = 'true';

            const frame = document.createElement('div');
            frame.className = 'te-image-preview-frame';
            const image = document.createElement('img');
            image.className = 'te-image-preview-img';
            image.alt = '';
            image.loading = 'lazy';
            frame.appendChild(image);

            const caption = document.createElement('figcaption');
            caption.className = 'te-image-preview-caption';
            caption.textContent = t('messages.no_image_selected', 'Aucune image sélectionnée');

            preview.appendChild(frame);
            preview.appendChild(caption);
            preview.hidden = true;
            field.appendChild(preview);
        }

        return preview;
    };

    const updateImagePreviewForSelect = (select) => {
        const preview = ensureImagePreviewNode(select);
        if (!preview) {
            return;
        }

        const image = preview.querySelector('.te-image-preview-img');
        const caption = preview.querySelector('.te-image-preview-caption');

        const rawValue = typeof select.value === 'string' ? select.value.trim() : '';
        if (!rawValue) {
            preview.hidden = true;
            if (image) {
                image.removeAttribute('src');
                image.alt = '';
            }
            if (caption) {
                caption.textContent = t('messages.no_image_selected', 'Aucune image sélectionnée');
            }
            return;
        }

        const imageUrl = resolveImageUrl(rawValue);
        if (!imageUrl) {
            preview.hidden = true;
            if (image) {
                image.removeAttribute('src');
                image.alt = '';
            }
            if (caption) {
                caption.textContent = rawValue;
            }
            return;
        }

        if (image) {
            image.src = imageUrl;
            image.alt = t('messages.image_preview', 'Prévisualisation {image}', {
                image: rawValue,
            });
        }
        if (caption) {
            caption.textContent = rawValue;
        }
        preview.hidden = false;
    };

    const refreshImagePreviews = () => {
        Array.from(root.querySelectorAll('select[data-te-image-select], select[data-block-type="image"]'))
            .forEach((select) => updateImagePreviewForSelect(select));
    };

    const getBlockPreviewHandlers = () => {
        const handlers = window.ThemeEditorBlockHandlers;
        return handlers && typeof handlers === 'object' ? handlers : {};
    };

    const updateBlockDomPreview = (routeIndex) => {
        const blocks = getRouteBlocks();
        const block = blocks[routeIndex];
        if (!block || !block.params || typeof block.params !== 'object') {
            return;
        }

        let element = findDomBlockForRouteIndex(routeIndex);
        if (!element) {
            return;
        }

        const params = block.params;
        const resetElementFromTemplate = () => {
            const fresh = createBlockFromTemplate(block.id);
            if (!(fresh instanceof HTMLElement) || !element.parentNode) {
                return false;
            }

            element.replaceWith(fresh);
            element = fresh;
            return true;
        };
        const setText = (key, fallback = '') => {
            const node = queryAttrValue(element, 'param', key);
            if (node) {
                const resolved = resolveTemplateVariables(String(params[key] || fallback));
                node.textContent = resolved;
            }
        };
        const applyBlockAos = () => {
            const value = String(params.aos || '').trim();
            if (!value || value === 'none') {
                element.removeAttribute('data-aos');
                return;
            }

            element.setAttribute('data-aos', value);
        };

        const normalizeButtonVariant = (value, fallback = 'primary') => {
            const allowed = new Set(['server', 'primary', 'secondary', 'tertiary', 'quaternary']);
            return allowed.has(String(value || '').trim()) ? String(value).trim() : fallback;
        };

        const normalizeTextKey = (value) => String(value || '')
            .normalize('NFKD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/\s+/g, ' ')
            .trim()
            .toLowerCase();

        const applyHeaderButtonStyles = (headerShell, rules, serverAddress) => {
            if (!(headerShell instanceof HTMLElement)) {
                return;
            }

            const normalizedRules = Array.isArray(rules)
                ? rules.filter((rule) => rule && typeof rule === 'object')
                : [];
            const links = Array.from(headerShell.querySelectorAll('.navbar .navbar-nav.me-auto .nav-item > a'));
            const variantClassByType = {
                primary: 'btn-primary',
                secondary: 'btn-secondary',
                tertiary: 'btn-tertiary',
                quaternary: 'btn-quaternary',
                server: 'btn-server',
            };

            links.forEach((link) => {
                if (!(link instanceof HTMLAnchorElement)) {
                    return;
                }

                const originalText = String(link.dataset.teOriginalText || link.textContent || '').trim();
                if (!link.dataset.teOriginalText) {
                    link.dataset.teOriginalText = originalText;
                }
                if (!link.dataset.teOriginalHref) {
                    link.dataset.teOriginalHref = link.getAttribute('href') || '#';
                }
                if (!link.dataset.teOriginalClass) {
                    link.dataset.teOriginalClass = link.className;
                }

                const originalHref = String(link.dataset.teOriginalHref || '#');
                const originalClass = String(link.dataset.teOriginalClass || '');
                const match = normalizedRules.find((rule) => {
                    const normalizedLabel = normalizeTextKey(rule.label);
                    const normalizedOriginalText = normalizeTextKey(originalText);
                    return normalizedLabel.length > 0 && (
                        normalizedLabel === normalizedOriginalText
                        || normalizedOriginalText.includes(normalizedLabel)
                    );
                }) || null;

                link.className = originalClass;
                link.classList.remove('btn', 'btn-primary', 'btn-secondary', 'btn-tertiary', 'btn-quaternary', 'btn-server');
                link.textContent = originalText;
                link.setAttribute('href', originalHref);
                link.removeAttribute('data-copyboard');
                link.removeAttribute('data-copyboard-text');
                link.removeAttribute('data-bs-toggle');
                link.removeAttribute('data-bs-title');

                if (!match) {
                    return;
                }

                const variant = normalizeButtonVariant(match.variant, 'primary');
                link.classList.remove('nav-link');
                link.classList.add('btn', variantClassByType[variant] || 'btn-primary');
                link.dataset.teButtonVariant = variant;

                if (variant === 'server') {
                    const resolvedAddress = String(serverAddress || '').trim();
                    link.textContent = resolvedAddress || t('messages.server_unavailable', 'Serveur indisponible');
                    link.setAttribute('href', '#');
                    link.setAttribute('data-copyboard', 'true');
                    link.setAttribute('data-copyboard-text', resolvedAddress);
                    link.setAttribute('data-bs-toggle', 'tooltip');
                    link.setAttribute('data-bs-title', t('messages.copied', 'Copié !'));
                }
            });

            if (typeof window.initCopyboard === 'function') {
                window.initCopyboard();
            }
        };

        const applyLandingButton = (node, options) => {
            if (!node) {
                return;
            }

            const variantClassByType = {
                primary: 'btn-primary',
                secondary: 'btn-secondary',
                tertiary: 'btn-tertiary',
                quaternary: 'btn-quaternary',
                server: 'btn-server',
            };

            const variant = normalizeButtonVariant(options.variant, 'primary');
            const serverAddress = String(options.serverAddress || '').trim();
            const text = variant === 'server'
                ? (serverAddress || t('messages.server_unavailable', 'Serveur indisponible'))
                : String(options.text || options.fallbackText || t('messages.learn_more', 'En savoir plus'));
            const href = variant === 'server'
                ? '#'
                : String(options.url || options.fallbackUrl || '#');

            node.textContent = resolveTemplateVariables(text);
            node.setAttribute('href', href);
            node.dataset.teButtonVariant = variant;
            node.dataset.teServerIp = serverAddress;

            node.classList.remove('btn-primary', 'btn-secondary', 'btn-tertiary', 'btn-quaternary', 'btn-server');
            node.classList.add(variantClassByType[variant] || 'btn-primary');

            if (variant === 'server') {
                node.setAttribute('data-copyboard', 'true');
                node.setAttribute('data-copyboard-text', serverAddress);
                node.setAttribute('data-bs-toggle', 'tooltip');
                node.setAttribute('data-bs-title', t('messages.copied', 'Copié !'));
            } else {
                node.removeAttribute('data-copyboard');
                node.removeAttribute('data-copyboard-text');
                node.removeAttribute('data-bs-toggle');
                node.removeAttribute('data-bs-title');
            }
        };

        Object.entries(params).forEach(([key, value]) => {
            const isScalar = typeof value === 'string'
                || typeof value === 'number'
                || typeof value === 'boolean';
            if (isScalar) {
                const paramSelector = selectorForAttrValue('param', key);
                const paramNodes = paramSelector ? Array.from(element.querySelectorAll(paramSelector)) : [];
                paramNodes.forEach((node) => {
                    const resolvedValue = typeof value === 'string'
                        ? resolveTemplateVariables(value)
                        : String(value);
                    node.textContent = resolvedValue;
                });
            }

            if (typeof value === 'string') {
                const hrefSelector = selectorForAttrValue('param_href', key);
                const hrefNodes = hrefSelector ? Array.from(element.querySelectorAll(hrefSelector)) : [];
                hrefNodes.forEach((node) => {
                    node.setAttribute('href', resolveTemplateVariables(value) || '#');
                });

                const classSelector = selectorForAttrValue('param_class', key);
                const classNodes = classSelector ? Array.from(element.querySelectorAll(classSelector)) : [];
                classNodes.forEach((node) => {
                    node.className = value;
                });

                const imageSelector = selectorForAttrValue('param_image', key);
                const imageNodes = imageSelector ? Array.from(element.querySelectorAll(imageSelector)) : [];
                imageNodes.forEach((node) => {
                    const resolved = resolveImageUrl(value);
                    if (resolved) {
                        node.setAttribute('src', resolved);
                        node.hidden = false;
                    } else {
                        node.removeAttribute('src');
                        node.hidden = true;
                    }
                });
            }
        });

        const blockPreviewHandlers = getBlockPreviewHandlers();
        const handler = typeof blockPreviewHandlers[block.id] === 'function'
            ? blockPreviewHandlers[block.id]
            : null;
        if (handler) {
            handler({
                block,
                params,
                state,
                element,
                routeIndex,
                helpers: {
                    toBoolean,
                    isAdvancedModeActive,
                    resetElementFromTemplate,
                    setText,
                    queryAttrValue: (attrKey, value) => queryAttrValue(element, attrKey, value),
                    queryAllAttr: (attrKey) => queryAllAttr(element, attrKey),
                    escapeHtml,
                    renderIconMarkup,
                    normalizeButtonVariant,
                    normalizeTextKey,
                    applyHeaderButtonStyles,
                    applyLandingButton,
                    resolveTemplateVariables,
                },
            });
        }

        if (block.id !== 'header' && block.id !== 'footer') {
            applyBlockAos();
        }
    };

    const applyParticlesPreview = () => {
        window.THEME = window.THEME || {};
        window.THEME.particles = {
            ...(window.THEME.particles || {}),
            enabled: Boolean(state.global?.particles_enabled),
            count: toBoundedNumber(state.global?.particles_count, 80, 10, 500),
            density: toBoundedNumber(state.global?.particles_density, 50, 1, 100),
            speed: toBoundedNumber(state.global?.particles_speed, 3, 1, 10),
            size: toBoundedNumber(state.global?.particles_size, 3, 1, 20),
            image: resolveImageUrl(state.global?.particles_image),
            color: 'rgba(255, 255, 255, 0.8)',
        };

        if (typeof window.initBackgroundParticles === 'function') {
            window.initBackgroundParticles();
        }
    };

    const createBlockFromTemplate = (blockId) => {
        if (typeof blockId !== 'string' || blockId.length === 0) {
            return null;
        }

        const safeBlockId = String(blockId).replace(/"/g, '\\"');
        const templateSelectors = [];
        const primaryAttr = attr('template_block');
        if (primaryAttr) {
            templateSelectors.push(`template[${primaryAttr}="${safeBlockId}"]`);
        }
        const template = templateSelectors.length > 0 ? root.querySelector(templateSelectors.join(', ')) : null;
        if (!(template instanceof HTMLTemplateElement)) {
            return null;
        }

        const fragment = template.content.cloneNode(true);
        const blockSelector = selectorForAttr('block');
        const blockElement = blockSelector ? fragment.querySelector(blockSelector) : null;
        if (!(blockElement instanceof HTMLElement)) {
            return null;
        }

        return blockElement;
    };

    const createFallbackBlockElement = (blockId) => {
        const section = document.createElement('section');
        setAttrValue(section, 'block', blockId);
        section.className = 'container content my-5';
        section.innerHTML = `
            <div class="alert alert-warning mb-0">
                Le template du bloc <strong>${escapeHtml(blockId)}</strong> est introuvable.
            </div>
        `;
        return section;
    };

    const applyDomBlockOrder = () => {
        const container = findBlockContainer();
        if (!container) {
            return false;
        }

        enforceRouteBlockConstraints(getCurrentRouteKey());
        const routeBlocks = getRouteBlocks().filter((block) => !isExternalBlockId(block.id));
        const domBlocks = queryAllAttr(container, 'block');

        const domBuckets = new Map();
        domBlocks.forEach((element) => {
            const id = String(readAttrValue(element, 'block') || '');
            if (!domBuckets.has(id)) {
                domBuckets.set(id, []);
            }
            domBuckets.get(id).push(element);
        });

        const orderedBlocks = routeBlocks.map((block) => {
            const bucket = domBuckets.get(block.id);
            if (Array.isArray(bucket) && bucket.length > 0) {
                return bucket.shift();
            }

            const fromTemplate = createBlockFromTemplate(block.id);
            if (fromTemplate) {
                return fromTemplate;
            }

            return createFallbackBlockElement(block.id);
        });

        domBlocks.forEach((element) => {
            element.remove();
        });

        orderedBlocks.forEach((element) => {
            container.appendChild(element);
        });

        return orderedBlocks.length > 0;
    };

    const renderBlocksPreview = () => {
        const preview = document.getElementById('theme-editor-page-preview');
        if (preview) {
            preview.remove();
        }

        applyDomBlockOrder();
        getRouteBlocks().forEach((_, index) => {
            updateBlockDomPreview(index);
        });
    };

    const applyLivePreview = ({ markDirty = true, message = t('status.preview_applied', 'Prévisualisation appliquée') } = {}) => {
        renderLiveCss();
        applyThemeMode();
        applyFontLink();
        applyAnnounceBar();
        applyScrollProgress();
        applyParticlesPreview();
        renderBlocksPreview();
        if (typeof onSystemVariablesRefresh === 'function') {
            onSystemVariablesRefresh();
        }

        if (window.AOS && typeof window.AOS.refreshHard === 'function') {
            window.AOS.refreshHard();
        } else if (window.AOS && typeof window.AOS.refresh === 'function') {
            window.AOS.refresh();
        } else if (window.AOS && typeof window.AOS.init === 'function') {
            window.AOS.init({
                duration: 650,
                once: true,
                offset: 40,
                easing: 'ease-out-cubic',
            });
        }
        if (typeof window.initCopyboard === 'function') {
            window.initCopyboard();
        }

        if (markDirty) {
            if (typeof onPageHistoryMutated === 'function') {
                onPageHistoryMutated();
            }
            setDirty(true);
            setPhase('dirty', message);
        } else if (isPanelOpen()) {
            setPhase('open', message);
        } else {
            setPhase('idle', message);
        }
    };

    return {
        getCatalogItem,
        enforceRouteBlockConstraints,
        fallbackBlockIdsForRoute,
        seedCurrentRouteBlocks,
        renderActiveBlocks,
        openCatalogModal,
        closeCatalogModal,
        closeBlockModal,
        saveBlockModal,
        refreshImagePreviews,
        updateImagePreviewForSelect,
        updateBlockDomPreview,
        applyLivePreview,
    };
};
