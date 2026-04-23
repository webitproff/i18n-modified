<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
==================== */

/** 
 * whitelist[$db_i18n_pages] for API extrafields
 *
 * Compatibility: [CMF/CMS Cotonti Siena v0.9.26+](https://github.com/Cotonti/Cotonti); PHP-8.4 & MySQL-8.0+ 
 * File: i18n.extrafields.php
 * Placement: plugins/i18n/i18n.extrafields.php 
 * Description: register the `cot_i18n_pages` table in the admin panel’s extra fields system (API extrafields).
 *              add the localized pages table information to the whitelist (`$extra_whitelist`).
 * Created: 22 Apr 2026  
 * Updated: 23 Apr 2026
 * Source code: https://github.com/webitproff/i18n-modified
 * Support & Help: https://abuyfile.com/ru/forums/cotonti/original/extrafields
 * ReadMeMore: https://abuyfile.com/ru/cotonti/authorial-plugins/integraciya-extrafields-v-plagin-i18n-v-cotonti-cmf
 * 
 * @package i18n 
 * @version 1.0.2  
 * @author webitproff 
 * @copyright (c) 2026 webitproff | https://github.com/webitproff 
 * @license BSD (Free using and distribution with saving copyrights)   
 */ 

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('i18n', 'plug');

$extra_whitelist[$db_i18n_pages] = [
    'name'    => $db_i18n_pages,
    'caption' => $L['i18n_pages'],
    'type'    => 'plug',
    'code'    => 'i18n',
    'tags'    => [
        'i18n.page.tpl' => '{I18N_PAGE_FORM_XXXXX}, {I18N_PAGE_FORM_XXXXX_TITLE}',
    ]
];