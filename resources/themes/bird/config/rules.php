<?php

$themeEditorRulesPath = dirname(__DIR__).'/theme-editor/rules.php';

if (is_file($themeEditorRulesPath)) {
    return require $themeEditorRulesPath;
}

return [];
