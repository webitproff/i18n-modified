<?php
/**
 * Ukrainian Language File for i18n modified Plugin for CMF Cotonti, PHP v.8.5+, MySQL v.8.4
 *
 * - назва та опис модуля (info_name, info_desc, info_notes)
 * - налаштування в адмін-панелі (cfg_…)
 * - підказки до полів (cfg_…_hint)
 *
 * Filename: plugins/i18n/lang/i18n.ua.lang.php
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
 
// приклад використання апострофа без екранування:
// - $L['name'] = 'Ім’я'; правильно
// - $L['name'] = "Ім'я"; правильно (подвійні лапки)
// НЕ правильно $L['name'] = 'Ім'я';
// Екранування правильно для спецсимволів $L['name'] = 'Ім\'я'; (зворотний слеш)

defined('COT_CODE') or die('Wrong URL.');

// ========================
// ІНФОРМАЦІЯ ПРО РОЗШИРЕННЯ
// ========================
$L['info_name']  = 'i18n modified';
$L['info_desc']  = 'Модифікований плагін мультимовності інтерфейсу сайту та статей. Підтримка багатомовного контенту в модулі Pages, ядрі та розширеннях';
$L['info_notes'] = 'Детальніше: <a href="https://github.com/webitproff/i18n-modified" target="_blank">документація та посилання на неї</a>.';

$L['i18n_title']       = $L['info_name'];
$L['i18n_desc']        = $L['info_desc'];
/**
 * Plugin Title & Subtitle
 */
$L['i18n_pages'] = 'Переклади сторінок';


// Plugin configuration

$L['cfg_cats'] = 'Кореневі категорії для застосування i18n';
$L['cfg_cats_hint'] = 'Коди категорій через кому';
$L['cfg_locales'] = 'Список локалей сайту';
$L['cfg_locales_hint'] = 'Кожна локаль з нового рядка, формат: locale_code|Назва локалі';
$L['cfg_omitmain'] = 'Пропускати параметр мови в URL, якщо він вказує на основну мову';
$L['cfg_rewrite'] = 'Увімкнути ЧПУ для параметра мови в посиланнях';
$L['cfg_rewrite_hint'] = 'Потребує ручного оновлення .htaccess';
$L['cfg_cookie'] = 'Запам’ятовувати обрану мову в cookie';






// Plugin strings

$L['i18n_adding'] = 'Додавання нового перекладу';
$L['i18n_confirm_delete'] = 'Ви дійсно хочете видалити переклад?';
$L['i18n_delete'] = 'Видалити переклад';
$L['i18n_editing'] = 'Редагування перекладу';
$L['i18n_incorrect_locale'] = 'Невірна локаль';
$L['i18n_items_added'] = '{$cnt} елементів додано';
$L['i18n_items_removed'] = '{$cnt} елементів видалено';
$L['i18n_items_updated'] = '{$cnt} елементів оновлено';
$L['i18n_locale_selection'] = 'Вибір локалі';
$L['i18n_localized'] = 'Локалізовано';
$L['i18n_no_categories'] = 'Не обрано категорії для перекладу. Їх можна встановити в <a href="%s">налаштуваннях інтернаціоналізації<a>';
$L['i18n_original'] = 'Оригінал';
$L['i18n_structure'] = 'Інтернаціоналізація структури';
$L['i18n_translate'] = 'Перекласти';
$L['i18n_translation'] = 'Переклад';


