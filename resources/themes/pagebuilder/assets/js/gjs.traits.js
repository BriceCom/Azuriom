function Traits(editor) {
    const tr = editor.TraitManager;

    tr.addType('pb-textarea', {
        createInput({ trait }) {
            const input = document.createElement('textarea');
            const rows = Number(trait.get('rows') || 8);

            input.className = 'gjs-field gjs-field-textarea';
            input.rows = Number.isFinite(rows) && rows > 0 ? rows : 8;
            input.placeholder = trait.get('placeholder') || '';

            return input;
        },
        onEvent({ elInput, component, trait }) {
            const name = trait.get('name');
            if (!name) {
                return;
            }

            component.addAttributes({
                [name]: elInput.value,
            });
        },
        onUpdate({ elInput, component, trait }) {
            const name = trait.get('name');
            if (!name) {
                return;
            }

            const attributes = component.getAttributes ? component.getAttributes() : {};
            const nextValue = typeof attributes[name] === 'string' ? attributes[name] : '';

            if (elInput.value !== nextValue) {
                elInput.value = nextValue;
            }
        }
    });
}
