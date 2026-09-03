<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
==================== */

// файл новый i18n.extrafields.php
// Путь: plugins/i18n/i18n.extrafields.php
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