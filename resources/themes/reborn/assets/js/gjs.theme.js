(function () {
  const t = (key, fallback = null, params = null) => {
    if (typeof window.trans === 'function') {
      return window.trans(key, params, fallback);
    }

    return fallback || key;
  };

  const colorDefaults = {
    primary: '#0d6efd',
    secondary: '#6c757d',
    success: '#198754',
    info: '#0dcaf0',
    warning: '#ffc107',
    danger: '#dc3545',
    light: '#f8f9fa',
    dark: '#212529',
    body: '#ffffff',
    text: '#212529',
  };

  const buttonTextColors = {
    primary: '#ffffff',
    secondary: '#ffffff',
    success: '#ffffff',
    info: '#000000',
    warning: '#000000',
    danger: '#ffffff',
    light: '#000000',
    dark: '#ffffff',
  };

  function ensureHostHasBootstrap() {
    if (!document.querySelector('link[data-gjs-host-bs="1"]')) {
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css';
      link.setAttribute('data-gjs-host-bs', '1');
      document.head.appendChild(link);
    }
  }

  function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
  }

  function toNumber(value, fallback) {
    const parsed = parseFloat(value);
    return Number.isFinite(parsed) ? parsed : fallback;
  }

  function hexToRgb(hex) {
    const normalized = String(hex || '').trim().replace('#', '');

    if (/^[0-9a-fA-F]{3}$/.test(normalized)) {
      const r = parseInt(normalized[0] + normalized[0], 16);
      const g = parseInt(normalized[1] + normalized[1], 16);
      const b = parseInt(normalized[2] + normalized[2], 16);
      return `${r}, ${g}, ${b}`;
    }

    if (/^[0-9a-fA-F]{6}$/.test(normalized)) {
      const r = parseInt(normalized.slice(0, 2), 16);
      const g = parseInt(normalized.slice(2, 4), 16);
      const b = parseInt(normalized.slice(4, 6), 16);
      return `${r}, ${g}, ${b}`;
    }

    return '13, 110, 253';
  }

  function shadowValue(level, type = 'card') {
    const normalizedLevel = clamp(parseInt(level, 10) || 0, 0, 3);
    const cardShadows = [
      'none',
      '0 .125rem .25rem rgba(0, 0, 0, .075)',
      '0 .5rem 1rem rgba(0, 0, 0, .12)',
      '0 1rem 2.5rem rgba(0, 0, 0, .18)',
    ];
    const buttonShadows = [
      'none',
      '0 .125rem .25rem rgba(0, 0, 0, .10)',
      '0 .35rem .8rem rgba(0, 0, 0, .16)',
      '0 .75rem 1.4rem rgba(0, 0, 0, .2)',
    ];

    return (type === 'button' ? buttonShadows : cardShadows)[normalizedLevel];
  }

  function normalizePalette(input) {
    return {
      ...colorDefaults,
      ...(input && typeof input === 'object' && !Array.isArray(input) ? input : {}),
    };
  }

  function normalizeTheme(theme) {
    const parsed = theme && typeof theme === 'object' && !Array.isArray(theme) ? theme : {};
    const legacyColors = parsed.colors && !parsed.colorsLight && !parsed.colorsDark ? parsed.colors : null;

    const mode = parsed.mode === 'dark' ? 'dark' : 'light';
    const colorsLight = normalizePalette(parsed.colorsLight || legacyColors);
    const colorsDark = normalizePalette(parsed.colorsDark || legacyColors);
    const fonts = {
      primary: parsed?.fonts?.primary || 'system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif',
      secondary: parsed?.fonts?.secondary || '',
      accent: parsed?.fonts?.accent || '',
    };
    const borders = {
      radius: clamp(parseInt(parsed?.borders?.radius ?? 6, 10) || 6, 0, 64),
      radiusSm: clamp(parseInt(parsed?.borders?.radiusSm ?? 4, 10) || 4, 0, 64),
      radiusLg: clamp(parseInt(parsed?.borders?.radiusLg ?? 10, 10) || 10, 0, 64),
    };
    const buttons = {
      radius: clamp(parseInt(parsed?.buttons?.radius ?? borders.radius, 10) || borders.radius, 0, 64),
      font: parsed?.buttons?.font || 'default',
      defaultVariant: parsed?.buttons?.defaultVariant || 'primary',
      defaultSize: parsed?.buttons?.defaultSize || 'default',
      defaultOutline: !!parsed?.buttons?.defaultOutline,
    };
    const basics = {
      buttonPaddingY: clamp(toNumber(parsed?.basics?.buttonPaddingY, 6), 0, 32),
      buttonPaddingX: clamp(toNumber(parsed?.basics?.buttonPaddingX, 12), 0, 48),
      buttonFontWeight: clamp(toNumber(parsed?.basics?.buttonFontWeight, 400), 100, 900),
      cardPaddingY: clamp(toNumber(parsed?.basics?.cardPaddingY, 16), 0, 64),
      cardPaddingX: clamp(toNumber(parsed?.basics?.cardPaddingX, 16), 0, 64),
      tablePaddingY: clamp(toNumber(parsed?.basics?.tablePaddingY, 8), 0, 32),
      tablePaddingX: clamp(toNumber(parsed?.basics?.tablePaddingX, 8), 0, 32),
    };
    const forms = {
      controlRadius: clamp(toNumber(parsed?.forms?.controlRadius, borders.radiusSm), 0, 64),
      controlPaddingY: clamp(toNumber(parsed?.forms?.controlPaddingY, 0.5), 0, 2),
      controlPaddingX: clamp(toNumber(parsed?.forms?.controlPaddingX, 0.75), 0, 3),
      focusRingOpacity: clamp(toNumber(parsed?.forms?.focusRingOpacity, 0.25), 0, 0.8),
    };
    const navigation = {
      navLinkPaddingY: clamp(toNumber(parsed?.navigation?.navLinkPaddingY, 0.5), 0, 2),
      navLinkPaddingX: clamp(toNumber(parsed?.navigation?.navLinkPaddingX, 0.75), 0, 3),
      alertRadius: clamp(toNumber(parsed?.navigation?.alertRadius, borders.radius), 0, 64),
      badgeRadius: clamp(toNumber(parsed?.navigation?.badgeRadius, borders.radiusSm), 0, 64),
      listGroupRadius: clamp(toNumber(parsed?.navigation?.listGroupRadius, borders.radiusSm), 0, 64),
    };
    const effects = {
      cardShadowLevel: clamp(parseInt(parsed?.effects?.cardShadowLevel, 10) || 1, 0, 3),
      buttonShadowLevel: clamp(parseInt(parsed?.effects?.buttonShadowLevel, 10) || 0, 0, 3),
    };
    const links = {
      color: parsed?.links?.color || '',
      hoverColor: parsed?.links?.hoverColor || '',
    };

    return {
      mode,
      colorsLight,
      colorsDark,
      fonts,
      borders,
      buttons,
      basics,
      forms,
      navigation,
      effects,
      links,
    };
  }

  function fontVarForButton(choice) {
    if (choice === 'secondary') return 'var(--bs-font-secondary)';
    if (choice === 'accent') return 'var(--bs-font-accent)';
    return 'var(--bs-font-primary)';
  }

  function buildCssVariables(colors, theme) {
    const keys = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'];
    const vars = [];
    const linkColor = theme.links.color || colors.primary || colorDefaults.primary;
    const linkHoverColor = theme.links.hoverColor || linkColor;

    keys.forEach((key) => {
      const value = colors[key] || colorDefaults[key];
      vars.push(`--bs-${key}: ${value}`);
      vars.push(`--bs-${key}-rgb: ${hexToRgb(value)}`);
    });

    vars.push(`--bs-body-bg: ${colors.body || colorDefaults.body}`);
    vars.push(`--bs-body-color: ${colors.text || colorDefaults.text}`);
    vars.push(`--bs-link-color: ${linkColor}`);
    vars.push(`--bs-link-hover-color: ${linkHoverColor}`);

    vars.push(`--bs-font-primary: ${theme.fonts.primary}`);
    vars.push(`--bs-font-secondary: ${theme.fonts.secondary}`);
    vars.push(`--bs-font-accent: ${theme.fonts.accent}`);
    vars.push(`--bs-border-radius: ${theme.borders.radius}px`);
    vars.push(`--bs-border-radius-sm: ${theme.borders.radiusSm}px`);
    vars.push(`--bs-border-radius-lg: ${theme.borders.radiusLg}px`);
    vars.push(`--bs-btn-radius: ${theme.buttons.radius}px`);
    vars.push(`--bs-btn-font: ${fontVarForButton(theme.buttons.font)}`);
    vars.push(`--pb-btn-padding-y: ${theme.basics.buttonPaddingY}px`);
    vars.push(`--pb-btn-padding-x: ${theme.basics.buttonPaddingX}px`);
    vars.push(`--pb-btn-font-weight: ${theme.basics.buttonFontWeight}`);
    vars.push(`--pb-card-padding-y: ${theme.basics.cardPaddingY}px`);
    vars.push(`--pb-card-padding-x: ${theme.basics.cardPaddingX}px`);
    vars.push(`--pb-table-padding-y: ${theme.basics.tablePaddingY}px`);
    vars.push(`--pb-table-padding-x: ${theme.basics.tablePaddingX}px`);
    vars.push(`--pb-form-control-radius: ${theme.forms.controlRadius}px`);
    vars.push(`--pb-form-control-padding-y: ${theme.forms.controlPaddingY}rem`);
    vars.push(`--pb-form-control-padding-x: ${theme.forms.controlPaddingX}rem`);
    vars.push(`--pb-focus-ring-opacity: ${theme.forms.focusRingOpacity}`);
    vars.push(`--pb-nav-link-padding-y: ${theme.navigation.navLinkPaddingY}rem`);
    vars.push(`--pb-nav-link-padding-x: ${theme.navigation.navLinkPaddingX}rem`);
    vars.push(`--pb-alert-radius: ${theme.navigation.alertRadius}px`);
    vars.push(`--pb-badge-radius: ${theme.navigation.badgeRadius}px`);
    vars.push(`--pb-list-group-radius: ${theme.navigation.listGroupRadius}px`);
    vars.push(`--pb-card-shadow: ${shadowValue(theme.effects.cardShadowLevel, 'card')}`);
    vars.push(`--pb-btn-shadow: ${shadowValue(theme.effects.buttonShadowLevel, 'button')}`);

    return vars.join(';');
  }

  function buildVariantOverrides() {
    const variants = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'];

    return variants.map((variant) => {
      const textColor = buttonTextColors[variant] || '#ffffff';

      return `
.btn-${variant}{
  --bs-btn-color:${textColor};
  --bs-btn-bg:var(--bs-${variant});
  --bs-btn-border-color:var(--bs-${variant});
  --bs-btn-hover-color:${textColor};
  --bs-btn-hover-bg:color-mix(in srgb, var(--bs-${variant}) 85%, #000);
  --bs-btn-hover-border-color:color-mix(in srgb, var(--bs-${variant}) 80%, #000);
  --bs-btn-active-color:${textColor};
  --bs-btn-active-bg:color-mix(in srgb, var(--bs-${variant}) 78%, #000);
  --bs-btn-active-border-color:color-mix(in srgb, var(--bs-${variant}) 72%, #000);
}
.btn-outline-${variant}{
  --bs-btn-color:var(--bs-${variant});
  --bs-btn-border-color:var(--bs-${variant});
  --bs-btn-hover-color:${textColor};
  --bs-btn-hover-bg:var(--bs-${variant});
  --bs-btn-hover-border-color:var(--bs-${variant});
  --bs-btn-active-color:${textColor};
  --bs-btn-active-bg:var(--bs-${variant});
  --bs-btn-active-border-color:var(--bs-${variant});
}
.text-${variant}{color:var(--bs-${variant}) !important}
.bg-${variant}{background-color:var(--bs-${variant}) !important}
.border-${variant}{border-color:var(--bs-${variant}) !important}
.text-bg-${variant}{background-color:var(--bs-${variant}) !important;color:${textColor} !important}
.alert-${variant}{
  --bs-alert-color:color-mix(in srgb, var(--bs-${variant}) 50%, #000);
  --bs-alert-bg:color-mix(in srgb, var(--bs-${variant}) 14%, transparent);
  --bs-alert-border-color:color-mix(in srgb, var(--bs-${variant}) 35%, transparent);
}
`;
    }).join('\n');
  }

  function buildThemeCss(theme) {
    const lightVars = buildCssVariables(theme.colorsLight, theme);
    const darkVars = buildCssVariables(theme.colorsDark, theme);

    return `
:root,[data-bs-theme="light"]{${lightVars}}
[data-bs-theme="dark"]{${darkVars}}
body{
  font-family:var(--bs-font-primary);
  background-color:var(--bs-body-bg);
  color:var(--bs-body-color);
}
a{color:var(--bs-link-color)}
a:hover{color:var(--bs-link-hover-color)}
.font-primary{font-family:var(--bs-font-primary)!important}
.font-secondary{font-family:var(--bs-font-secondary)!important}
.font-accent{font-family:var(--bs-font-accent)!important}
.btn{
  border-radius:var(--bs-btn-radius)!important;
  font-family:var(--bs-btn-font)!important;
  --bs-btn-padding-y:var(--pb-btn-padding-y);
  --bs-btn-padding-x:var(--pb-btn-padding-x);
  --bs-btn-font-weight:var(--pb-btn-font-weight);
  padding:var(--pb-btn-padding-y) var(--pb-btn-padding-x)!important;
  font-weight:var(--pb-btn-font-weight)!important;
  box-shadow:var(--pb-btn-shadow);
}
.card{
  --bs-card-spacer-y:var(--pb-card-padding-y);
  --bs-card-spacer-x:var(--pb-card-padding-x);
  box-shadow:var(--pb-card-shadow);
}
.card-body{
  padding:var(--pb-card-padding-y) var(--pb-card-padding-x)!important;
}
.form-control,
.form-select,
.input-group-text{
  border-radius:var(--pb-form-control-radius)!important;
}
.form-control,
.form-select{
  padding:var(--pb-form-control-padding-y) var(--pb-form-control-padding-x)!important;
}
.form-control:focus,
.form-select:focus,
.btn:focus,
.btn:focus-visible{
  box-shadow:0 0 0 .25rem rgba(var(--bs-primary-rgb), var(--pb-focus-ring-opacity))!important;
}
.table{
  --bs-table-cell-padding-y:var(--pb-table-padding-y);
  --bs-table-cell-padding-x:var(--pb-table-padding-x);
}
.table > :not(caption) > * > *,
.table th,
.table td{
  padding:var(--pb-table-padding-y) var(--pb-table-padding-x)!important;
}
.nav-link,
.navbar-nav .nav-link{
  padding:var(--pb-nav-link-padding-y) var(--pb-nav-link-padding-x)!important;
}
.alert{
  border-radius:var(--pb-alert-radius)!important;
}
.badge{
  border-radius:var(--pb-badge-radius)!important;
}
.list-group{
  --bs-list-group-active-bg:var(--bs-primary);
  --bs-list-group-active-border-color:var(--bs-primary);
  --bs-list-group-active-color:#fff;
  border-radius:var(--pb-list-group-radius);
}
.list-group > .list-group-item:first-child{
  border-top-left-radius:var(--pb-list-group-radius);
  border-top-right-radius:var(--pb-list-group-radius);
}
.list-group > .list-group-item:last-child{
  border-bottom-left-radius:var(--pb-list-group-radius);
  border-bottom-right-radius:var(--pb-list-group-radius);
}
${buildVariantOverrides()}
`;
  }

  function applyGlobalBootstrapTheme(editor, rawTheme) {
    const theme = normalizeTheme(rawTheme);
    const doc = editor.Canvas.getDocument();
    if (!doc) {
      if (typeof editor.once === 'function') {
        editor.once('load', () => applyGlobalBootstrapTheme(editor, rawTheme));
      }
      return;
    }

    doc.documentElement.setAttribute('data-bs-theme', theme.mode);
    if (doc.body) {
      doc.body.setAttribute('data-bs-theme', theme.mode);
    }

    document.documentElement.setAttribute('data-bs-theme', theme.mode);
    if (document.body) {
      document.body.setAttribute('data-bs-theme', theme.mode);
    }

    const finalCss = buildThemeCss(theme);

    let style = doc.getElementById('bs-theme');
    if (!style) {
      style = doc.createElement('style');
      style.id = 'bs-theme';
      doc.head.appendChild(style);
    }
    style.textContent = finalCss;

    editor.trigger('theme:updated', { ...theme });
  }

  function colorsSection(colors, dataPrefix, title) {
    const fields = Object.entries(colors).map(([key, value]) => {
      const label = key.charAt(0).toUpperCase() + key.slice(1);
      return `<div class="col-sm-6 col-lg-4"><label class="form-label">${label}</label><input class="form-control form-control-color w-100" type="color" data-${dataPrefix}-color="${key}" value="${value}"></div>`;
    }).join('');

    const titleHtml = title ? `<h6 class="mb-3">${title}</h6>` : '';
    return `<div class="mb-0">${titleHtml}<div class="row g-3">${fields}</div></div>`;
  }

  function addGlobalThemePanel(editor) {
    ensureHostHasBootstrap();

    const pn = editor.Panels;
    const globalThemeTitle = t('theme::pagebuilder.global_theme_bootstrap', 'Global Theme (Bootstrap)');
    const globalThemeButtonLabel = t('theme::pagebuilder.theme_global_bootstrap', 'Theme');

    pn.addButton('options', {
      id: 'open-global-theme',
      className: 'bi bi-sliders',
      label: globalThemeButtonLabel,
      attributes: { title: globalThemeTitle },
      command: 'open-global-theme'
    });

    editor.Commands.add('open-global-theme', {
      run(ed) {
        let storedTheme = {};
        try {
          storedTheme = JSON.parse(localStorage.getItem('pagebuilder-bs-theme') || '{}');
        } catch (error) {
          storedTheme = {};
        }

        const theme = normalizeTheme(storedTheme);
        const defaultPalette = normalizePalette({});

        const wrapper = document.createElement('div');
        wrapper.innerHTML = `
          <div class="container-fluid p-3" style="max-height:72vh;overflow:auto">
            <div class="alert alert-info py-2 mb-3">
              Active mode is managed by the moon/sun toggle in the editor top bar.
            </div>

            <div class="row g-3 mb-4">
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <h5 class="card-title mb-0">Light palette</h5>
                      <button type="button" class="btn btn-outline-secondary btn-sm" data-reset-colors="light">Reset</button>
                    </div>
                    ${colorsSection(theme.colorsLight, 'light', '')}
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <h5 class="card-title mb-0">Dark palette</h5>
                      <button type="button" class="btn btn-outline-secondary btn-sm" data-reset-colors="dark">Reset</button>
                    </div>
                    ${colorsSection(theme.colorsDark, 'dark', '')}
                  </div>
                </div>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title mb-3">${t('theme::pagebuilder.global_variables', 'Global variables')}</h5>
                <div class="row g-3">
                  <div class="col-sm-6 col-lg-3">
                    <label class="form-label">${t('theme::pagebuilder.border_radius', 'Border radius')}</label>
                    <input type="number" class="form-control" data-border-radius value="${theme.borders.radius}" min="0" max="64">
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <label class="form-label">${t('theme::pagebuilder.border_radius_sm', 'Border radius sm')}</label>
                    <input type="number" class="form-control" data-border-radius-sm value="${theme.borders.radiusSm}" min="0" max="64">
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <label class="form-label">${t('theme::pagebuilder.border_radius_lg', 'Border radius lg')}</label>
                    <input type="number" class="form-control" data-border-radius-lg value="${theme.borders.radiusLg}" min="0" max="64">
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <label class="form-label">${t('theme::pagebuilder.button_radius', 'Button radius')}</label>
                    <input type="number" class="form-control" data-btn-radius value="${theme.buttons.radius}" min="0" max="64">
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">${t('theme::pagebuilder.buttons_section', 'Buttons')}</h5>
                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.button_padding_y', 'Button padding Y')}</label>
                        <input type="number" class="form-control" data-basic-btn-padding-y value="${theme.basics.buttonPaddingY}" min="0" max="32" step="0.5">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.button_padding_x', 'Button padding X')}</label>
                        <input type="number" class="form-control" data-basic-btn-padding-x value="${theme.basics.buttonPaddingX}" min="0" max="48" step="0.5">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.button_font_weight', 'Button font weight')}</label>
                        <input type="number" class="form-control" data-basic-btn-font-weight value="${theme.basics.buttonFontWeight}" min="100" max="900" step="100">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">${t('theme::pagebuilder.cards_section', 'Cards')}</h5>
                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.card_padding_y', 'Card padding Y')}</label>
                        <input type="number" class="form-control" data-basic-card-padding-y value="${theme.basics.cardPaddingY}" min="0" max="64" step="1">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.card_padding_x', 'Card padding X')}</label>
                        <input type="number" class="form-control" data-basic-card-padding-x value="${theme.basics.cardPaddingX}" min="0" max="64" step="1">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">${t('theme::pagebuilder.tables_section', 'Tables')}</h5>
                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.table_padding_y', 'Table cell padding Y')}</label>
                        <input type="number" class="form-control" data-basic-table-padding-y value="${theme.basics.tablePaddingY}" min="0" max="32" step="0.5">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.table_padding_x', 'Table cell padding X')}</label>
                        <input type="number" class="form-control" data-basic-table-padding-x value="${theme.basics.tablePaddingX}" min="0" max="32" step="0.5">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">${t('theme::pagebuilder.forms_section', 'Forms')}</h5>
                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.form_control_radius', 'Form field radius')}</label>
                        <input type="number" class="form-control" data-form-control-radius value="${theme.forms.controlRadius}" min="0" max="64" step="1">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.form_control_padding_y', 'Form field padding Y')}</label>
                        <input type="number" class="form-control" data-form-control-padding-y value="${theme.forms.controlPaddingY}" min="0" max="2" step="0.05">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.form_control_padding_x', 'Form field padding X')}</label>
                        <input type="number" class="form-control" data-form-control-padding-x value="${theme.forms.controlPaddingX}" min="0" max="3" step="0.05">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.focus_ring_opacity', 'Focus ring opacity')}</label>
                        <input type="number" class="form-control" data-form-focus-opacity value="${theme.forms.focusRingOpacity}" min="0" max="0.8" step="0.05">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">${t('theme::pagebuilder.navigation_section', 'Navigation')}</h5>
                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.nav_link_padding_y', 'Nav link padding Y')}</label>
                        <input type="number" class="form-control" data-nav-link-padding-y value="${theme.navigation.navLinkPaddingY}" min="0" max="2" step="0.05">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.nav_link_padding_x', 'Nav link padding X')}</label>
                        <input type="number" class="form-control" data-nav-link-padding-x value="${theme.navigation.navLinkPaddingX}" min="0" max="3" step="0.05">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.alert_radius', 'Alert radius')}</label>
                        <input type="number" class="form-control" data-alert-radius value="${theme.navigation.alertRadius}" min="0" max="64" step="1">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.badge_radius', 'Badge radius')}</label>
                        <input type="number" class="form-control" data-badge-radius value="${theme.navigation.badgeRadius}" min="0" max="64" step="1">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.list_group_radius', 'List group radius')}</label>
                        <input type="number" class="form-control" data-list-group-radius value="${theme.navigation.listGroupRadius}" min="0" max="64" step="1">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">${t('theme::pagebuilder.effects_section', 'Effects')}</h5>
                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.card_shadow_level', 'Card shadow level')}</label>
                        <select class="form-select" data-card-shadow-level>
                          <option value="0" ${theme.effects.cardShadowLevel === 0 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_none', 'None')}</option>
                          <option value="1" ${theme.effects.cardShadowLevel === 1 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_light', 'Light')}</option>
                          <option value="2" ${theme.effects.cardShadowLevel === 2 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_medium', 'Medium')}</option>
                          <option value="3" ${theme.effects.cardShadowLevel === 3 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_strong', 'Strong')}</option>
                        </select>
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.button_shadow_level', 'Button shadow level')}</label>
                        <select class="form-select" data-button-shadow-level>
                          <option value="0" ${theme.effects.buttonShadowLevel === 0 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_none', 'None')}</option>
                          <option value="1" ${theme.effects.buttonShadowLevel === 1 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_light', 'Light')}</option>
                          <option value="2" ${theme.effects.buttonShadowLevel === 2 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_medium', 'Medium')}</option>
                          <option value="3" ${theme.effects.buttonShadowLevel === 3 ? 'selected' : ''}>${t('theme::pagebuilder.shadow_strong', 'Strong')}</option>
                        </select>
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.link_color', 'Link color')}</label>
                        <input type="color" class="form-control form-control-color w-100" data-link-color value="${theme.links.color || theme.colorsLight.primary}">
                      </div>
                      <div class="col-12">
                        <label class="form-label">${t('theme::pagebuilder.link_hover_color', 'Link hover color')}</label>
                        <input type="color" class="form-control form-control-color w-100" data-link-hover-color value="${theme.links.hoverColor || theme.colorsLight.primary}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title mb-3">${t('theme::pagebuilder.quick_preview', 'Quick preview')}</h5>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <button type="button" class="btn btn-primary btn-sm">Primary</button>
                  <button type="button" class="btn btn-secondary btn-sm">Secondary</button>
                  <button type="button" class="btn btn-outline-primary btn-sm">Outline</button>
                </div>
                <div class="alert alert-primary py-2 mb-2">Alert preview</div>
                <div class="card mb-2">
                  <div class="card-body">Card preview body</div>
                </div>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <a href="#" class="small">Link preview</a>
                  <span class="badge text-bg-primary">Badge</span>
                </div>
                <input class="form-control form-control-sm mb-2" placeholder="Form control preview">
                <table class="table table-sm mb-2">
                  <tbody>
                    <tr><td>Table cell A</td><td>Table cell B</td></tr>
                  </tbody>
                </table>
                <ul class="list-group">
                  <li class="list-group-item active">List group active</li>
                  <li class="list-group-item">List group item</li>
                </ul>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <button id="global-theme-cancel" class="btn btn-outline-secondary">Cancel</button>
              <button id="global-theme-apply" class="btn btn-primary">${t('theme::pagebuilder.apply', 'Apply')}</button>
            </div>
          </div>
        `;

        ed.Modal.open({ title: globalThemeTitle, content: wrapper });

        wrapper.querySelectorAll('button[data-reset-colors]').forEach((button) => {
          button.addEventListener('click', () => {
            const scheme = button.getAttribute('data-reset-colors');
            wrapper.querySelectorAll(`input[data-${scheme}-color]`).forEach((input) => {
              const colorName = input.getAttribute(`data-${scheme}-color`);
              input.value = defaultPalette[colorName] || '#000000';
            });
          });
        });

        wrapper.querySelector('#global-theme-cancel')?.addEventListener('click', () => {
          ed.Modal.close();
        });

        wrapper.querySelector('#global-theme-apply').addEventListener('click', () => {
          const nextColorsLight = {};
          wrapper.querySelectorAll('input[data-light-color]').forEach((input) => {
            nextColorsLight[input.getAttribute('data-light-color')] = input.value;
          });

          const nextColorsDark = {};
          wrapper.querySelectorAll('input[data-dark-color]').forEach((input) => {
            nextColorsDark[input.getAttribute('data-dark-color')] = input.value;
          });

          let currentTheme = {};
          try {
            currentTheme = JSON.parse(localStorage.getItem('pagebuilder-bs-theme') || '{}');
          } catch (error) {
            currentTheme = {};
          }

          const normalizedCurrentTheme = normalizeTheme(currentTheme);
          const mode = normalizedCurrentTheme.mode === 'dark' ? 'dark' : 'light';

          const nextTheme = {
            ...normalizedCurrentTheme,
            mode,
            colorsLight: normalizePalette(nextColorsLight),
            colorsDark: normalizePalette(nextColorsDark),
            borders: {
              ...(normalizedCurrentTheme.borders || {}),
              radius: clamp(parseInt(wrapper.querySelector('input[data-border-radius]')?.value, 10) || 6, 0, 64),
              radiusSm: clamp(parseInt(wrapper.querySelector('input[data-border-radius-sm]')?.value, 10) || 4, 0, 64),
              radiusLg: clamp(parseInt(wrapper.querySelector('input[data-border-radius-lg]')?.value, 10) || 10, 0, 64),
            },
            buttons: {
              ...(normalizedCurrentTheme.buttons || {}),
              radius: clamp(parseInt(wrapper.querySelector('input[data-btn-radius]')?.value, 10) || 6, 0, 64),
            },
            basics: {
              ...(normalizedCurrentTheme.basics || {}),
              buttonPaddingY: clamp(toNumber(wrapper.querySelector('input[data-basic-btn-padding-y]')?.value, 6), 0, 32),
              buttonPaddingX: clamp(toNumber(wrapper.querySelector('input[data-basic-btn-padding-x]')?.value, 12), 0, 48),
              buttonFontWeight: clamp(toNumber(wrapper.querySelector('input[data-basic-btn-font-weight]')?.value, 400), 100, 900),
              cardPaddingY: clamp(toNumber(wrapper.querySelector('input[data-basic-card-padding-y]')?.value, 16), 0, 64),
              cardPaddingX: clamp(toNumber(wrapper.querySelector('input[data-basic-card-padding-x]')?.value, 16), 0, 64),
              tablePaddingY: clamp(toNumber(wrapper.querySelector('input[data-basic-table-padding-y]')?.value, 8), 0, 32),
              tablePaddingX: clamp(toNumber(wrapper.querySelector('input[data-basic-table-padding-x]')?.value, 8), 0, 32),
            },
            forms: {
              ...(normalizedCurrentTheme.forms || {}),
              controlRadius: clamp(toNumber(wrapper.querySelector('input[data-form-control-radius]')?.value, normalizedCurrentTheme.forms.controlRadius), 0, 64),
              controlPaddingY: clamp(toNumber(wrapper.querySelector('input[data-form-control-padding-y]')?.value, normalizedCurrentTheme.forms.controlPaddingY), 0, 2),
              controlPaddingX: clamp(toNumber(wrapper.querySelector('input[data-form-control-padding-x]')?.value, normalizedCurrentTheme.forms.controlPaddingX), 0, 3),
              focusRingOpacity: clamp(toNumber(wrapper.querySelector('input[data-form-focus-opacity]')?.value, normalizedCurrentTheme.forms.focusRingOpacity), 0, 0.8),
            },
            navigation: {
              ...(normalizedCurrentTheme.navigation || {}),
              navLinkPaddingY: clamp(toNumber(wrapper.querySelector('input[data-nav-link-padding-y]')?.value, normalizedCurrentTheme.navigation.navLinkPaddingY), 0, 2),
              navLinkPaddingX: clamp(toNumber(wrapper.querySelector('input[data-nav-link-padding-x]')?.value, normalizedCurrentTheme.navigation.navLinkPaddingX), 0, 3),
              alertRadius: clamp(toNumber(wrapper.querySelector('input[data-alert-radius]')?.value, normalizedCurrentTheme.navigation.alertRadius), 0, 64),
              badgeRadius: clamp(toNumber(wrapper.querySelector('input[data-badge-radius]')?.value, normalizedCurrentTheme.navigation.badgeRadius), 0, 64),
              listGroupRadius: clamp(toNumber(wrapper.querySelector('input[data-list-group-radius]')?.value, normalizedCurrentTheme.navigation.listGroupRadius), 0, 64),
            },
            effects: {
              ...(normalizedCurrentTheme.effects || {}),
              cardShadowLevel: clamp(parseInt(wrapper.querySelector('select[data-card-shadow-level]')?.value, 10) || normalizedCurrentTheme.effects.cardShadowLevel, 0, 3),
              buttonShadowLevel: clamp(parseInt(wrapper.querySelector('select[data-button-shadow-level]')?.value, 10) || normalizedCurrentTheme.effects.buttonShadowLevel, 0, 3),
            },
            links: {
              ...(normalizedCurrentTheme.links || {}),
              color: wrapper.querySelector('input[data-link-color]')?.value || normalizedCurrentTheme.links.color || '',
              hoverColor: wrapper.querySelector('input[data-link-hover-color]')?.value || normalizedCurrentTheme.links.hoverColor || '',
            },
          };

          localStorage.setItem('pagebuilder-bs-theme', JSON.stringify(nextTheme));
          applyGlobalBootstrapTheme(ed, nextTheme);
          ed.Modal.close();
        });
      }
    });
  }

  function addThemeModeToggle(editor) {
    const pn = editor.Panels;

    let optionsPanel = pn.getPanel('options');
    if (!optionsPanel) {
      optionsPanel = pn.addPanel({ id: 'options' });
    }

    try {
      pn.removeButton('options', 'toggle-theme-mode');
    } catch (error) {
      // noop
    }

    let mode = 'light';
    try {
      const saved = JSON.parse(localStorage.getItem('pagebuilder-bs-theme') || '{}');
      mode = saved.mode === 'dark' ? 'dark' : 'light';
    } catch (error) {
      mode = 'light';
    }

    pn.addButton('options', {
      id: 'toggle-theme-mode',
      className: mode === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill',
      label: t('theme::pagebuilder.theme_mode', 'Mode'),
      attributes: { title: t('theme::pagebuilder.toggle_theme_mode', 'Toggle light/dark theme') },
      command: 'cmd:toggle-theme-mode'
    });

    editor.Commands.add('cmd:toggle-theme-mode', {
      run(ed) {
        let saved = {};
        try {
          saved = JSON.parse(localStorage.getItem('pagebuilder-bs-theme') || '{}');
        } catch (error) {
          saved = {};
        }

        const normalized = normalizeTheme(saved);
        normalized.mode = normalized.mode === 'dark' ? 'light' : 'dark';
        localStorage.setItem('pagebuilder-bs-theme', JSON.stringify(normalized));
        applyGlobalBootstrapTheme(ed, normalized);

        const button = pn.getButton('options', 'toggle-theme-mode');
        if (button) {
          const nextClassName = normalized.mode === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
          button.set('className', nextClassName);

          const view = button.view;
          if (view && typeof view.render === 'function') {
            view.render();
          } else if (view && view.el) {
            view.el.className = nextClassName;
          }
        }
      }
    });
  }

  window.applyGlobalBootstrapTheme = applyGlobalBootstrapTheme;
  window.addGlobalThemePanel = addGlobalThemePanel;
  window.addThemeModeToggle = addThemeModeToggle;
})();
