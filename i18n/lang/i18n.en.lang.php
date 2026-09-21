<?php
/**
 * English Language File for i18n modified Plugin for CMF Cotonti, PHP v.8.5+, MySQL v.8.4
 *
 * - module name and description (info_name, info_desc, info_notes)
 * - admin panel settings (cfg_…)
 * - field hints (cfg_…_hint)
 *
 * Filename: plugins/i18n/lang/i18n.en.lang.php
 *
 * Source and updates   https://github.com/webitproff/i18n-modified
 * ReadMeMore:          https://abuyfile.com/ru/market/cotonti/plugs/i18n-modified
 * Support:             https://abuyfile.com/ru/forums/cotonti/lang-localiz
 *
 * Date: Sep 19, 2026
 *
 * @package i18n
 * @version 2.10-1.0.13
 * @author Cotonti Team, webitproff
 * @copyright (c) Cotonti Team, webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// ========================
// EXTENSION INFORMATION
// ========================
$L['info_name']  = 'i18n modified';
$L['info_desc']  = 'Modified plugin for multilingual interface and articles. Support for multilingual content in Pages module, core and extensions.';
$L['info_notes'] = 'More: <a href="https://github.com/webitproff/i18n-modified" target="_blank">documentation and links</a>.';

$L['i18n_title']       = $L['info_name'];
$L['i18n_desc']        = $L['info_desc'];

// Plugin configuration

$L['cfg_cats'] = 'Root categories to apply i18n on';
$L['cfg_cats_hint'] = 'Comma separated category codes';
$L['cfg_locales'] = 'List of site locales';
$L['cfg_locales_hint'] = 'Each locale on new line, format: locale_code|Locale title';
$L['cfg_omitmain'] = 'Omit language parameter in URLs if pointing to main language';
$L['cfg_rewrite'] = 'Enable URL overwrite for language parameter';
$L['cfg_rewrite_hint'] = 'Requires manual .htaccess update';
$L['cfg_cookie'] = 'Remember language selection in cookie';



// Plugin strings

$L['i18n_adding'] = 'Adding new translation';
$L['i18n_confirm_delete'] = 'Are you sure you want to delete the translation?';
$L['i18n_delete'] = 'Delete translation';
$L['i18n_editing'] = 'Editing a translation';
$L['i18n_incorrect_locale'] = 'Incorrect locale';
$L['i18n_items_added'] = '{$cnt} items added';
$L['i18n_items_removed'] = '{$cnt} items removed';
$L['i18n_items_updated'] = '{$cnt} items updated';
$L['i18n_locale_selection'] = 'Locale Selection';
$L['i18n_localized'] = 'Localized';
$L['i18n_no_categories'] = 'No categories selected for translation. You can set them in <a href="%s">Internationalization settings<a>';
$L['i18n_original'] = 'Original';
$L['i18n_structure'] = 'Structure Internationalization';
$L['i18n_translate'] = 'Translate';
$L['i18n_translation'] = 'Translation';
$L['i18n_pages'] = 'i18n pages translations';
