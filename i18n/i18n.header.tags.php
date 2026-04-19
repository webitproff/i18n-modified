<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.tags
Tags=header.tpl:{I18N_LANG_ROW_URL},{I18N_LANG_ROW_CODE},{I18N_LANG_ROW_TITLE},{I18N_LANG_ROW_CLASS},{I18N_LANG_ROW_SELECTED}
[END_COT_EXT]
==================== */
// Смотреть здесь https://abuyfile.com/ru/forums/cotonti/custom/lifehack/topic199
/**
 * Renders language selector
 *
 * @package I18n
 * @copyright (c) Cotonti Team
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

defined('COT_CODE') or die('Wrong URL');

if (count($i18n_locales) > 0) {
    foreach ($i18n_locales as $lc => $lc_title) {
        if ($lc === $i18n_locale) {
            $lc_class = 'selected';
            $lc_selected = 'selected="selected"';
        } else {
            $lc_class = '';
            $lc_selected = '';
        }

        $i18n_urlparams = $_GET;

        // Управление параметром языка в URL
        if ($cfg['plugin']['i18n']['omitmain'] 
            && $lc === $i18n_fallback 
            && (!$cfg['plugin']['i18n']['cookie'] || !cot_import('i18n_locale', 'COOKIE', 'ALP'))
        ) {
            unset($i18n_urlparams['l']);
        } else {
            $i18n_urlparams['l'] = $lc;
        }

        // Определение расширения для роутинга
        if (defined('COT_PLUG')) {
            $i18n_ext = 'plug';
        } else {
            $i18n_ext = $env['ext'];
            unset($i18n_urlparams['e']);
        }

        if (isset($i18n_urlparams['rwr'])) {
            unset($i18n_urlparams['rwr']);
        }

        // === ИСПРАВЛЕНИЕ ДЛЯ АДМИН-ПАНЕЛИ ===
        // При смене языка в админ-панели строим URL с префиксом /admin/
        // Пример: https://cotonti.local/en/admin/page вместо ошибочного https://cotonti.local/en/page?m=page
        if (defined('COT_ADMIN') && COT_ADMIN) {
            $url = cot_url('admin', $i18n_urlparams, '', false, true);
        } else {
            // старый I18N_LANG_ROW_URL из $t->assign переносим сюда в else самого условия if (defined('COT_ADMIN') && COT_ADMIN) {
            // 'I18N_LANG_ROW_URL' => cot_url($i18n_ext, $i18n_urlparams, '', false, true),
            $url = cot_url($i18n_ext, $i18n_urlparams, '', false, true);
        }

        $t->assign([
            'I18N_LANG_ROW_URL'      => $url,
            'I18N_LANG_ROW_CODE'     => $lc,
            'I18N_LANG_ROW_FLAG'     => $lc === 'en' ? 'gb' : $lc,
            'I18N_LANG_ROW_TITLE'    => htmlspecialchars($lc_title),
            'I18N_LANG_ROW_CLASS'    => $lc_class,
            'I18N_LANG_ROW_SELECTED' => $lc_selected,
        ]);

        $t->parse('HEADER.I18N_LANG.I18N_LANG_ROW');
    }

    $t->parse('HEADER.I18N_LANG');
}
