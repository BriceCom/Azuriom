function StyleManagerEnhancements(editor){
  // Build palette from theme (localStorage) or defaults
  function getThemeColors(){
    const def = { primary:'#0d6efd', secondary:'#6c757d', success:'#198754', info:'#0dcaf0', warning:'#ffc107', danger:'#dc3545' };
    try{
      const saved = localStorage.getItem('pagebuilder-bs-theme');
      const theme = saved ? JSON.parse(saved) : {};
      const mode = theme?.mode === 'dark' ? 'dark' : 'light';
      const palette = mode === 'dark' ? (theme.colorsDark || theme.colors || {}) : (theme.colorsLight || theme.colors || {});
      return { ...def, ...palette };
    }catch(e){ return def; }
  }

  function applyPalette(){
    const colors = getThemeColors();
    const palette = Object.values(colors);
    const cfg = editor.getConfig();
    cfg.colorPicker = cfg.colorPicker || {};
    cfg.colorPicker.customClass = 'gjs-color-picker';
    cfg.colorPicker.palette = palette;
  }

  function ensureFlexGap(){
    const sm = editor.StyleManager;
    const sector = sm.getSector('flex') || sm.addSector('flex', { name: 'Flex', open: false });
    const props = sector.getProperties && sector.getProperties() || [];
    const hasGap = props.some(p => p.get && p.get('property') === 'gap');
    if (!hasGap){
      sm.addProperty('flex', { property: 'gap', type: 'integer', units: ['px','rem'], defaults: '0', min: 0 });
      sm.addProperty('flex', { property: 'row-gap', type: 'integer', units: ['px','rem'], defaults: '0', min: 0 });
      sm.addProperty('flex', { property: 'column-gap', type: 'integer', units: ['px','rem'], defaults: '0', min: 0 });
    }
  }

  applyPalette();
  ensureFlexGap();

  // If other modules fire theme:updated, refresh palette
  editor.on('theme:updated', () => applyPalette());
}
