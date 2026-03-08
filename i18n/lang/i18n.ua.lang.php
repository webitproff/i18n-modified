<?php
/**
 * Ukrainian Language File for extention: i18n Content Internationalization Plugin (plugins/i18n/lang/i18n.ua.lang.php) 
 *
 * i18n plugin for Cotonti 0.9.26, PHP 8.4+
 * Version: 1.0.13  
 * Date: Feb 15th, 2026
 * The translation has been adapted: webitproff, 2026 | https://github.com/webitproff 
 *
 * @package i18n
 * @copyright (c) Cotonti Team
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */
 
defined('COT_CODE') or die('Wrong URL.');
// приклад використання апострофа без екранування:
// - $L['name'] = 'Ім’я'; правильно
// - $L['name'] = "Ім'я"; правильно (подвійні лапки)
// НЕ правильно $L['name'] = 'Ім'я';
// Екранування правильно для спецсимволів $L['name'] = 'Ім\'я'; (зворотний слеш)


// Plugin configuration

$L['cfg_cats'] = 'Кореневі категорії для застосування i18n';
$L['cfg_cats_hint'] = 'Коди категорій через кому';
$L['cfg_locales'] = 'Список локалей сайту';
$L['cfg_locales_hint'] = 'Кожна локаль з нового рядка, формат: locale_code|Назва локалі';
$L['cfg_omitmain'] = 'Пропускати параметр мови в URL, якщо він вказує на основну мову';
$L['cfg_rewrite'] = 'Увімкнути ЧПУ для параметра мови в посиланнях';
$L['cfg_rewrite_hint'] = 'Потребує ручного оновлення .htaccess';
$L['cfg_cookie'] = 'Запам’ятовувати обрану мову в cookie';


/**
 * Plugin Information
 */

$L['info_name'] = 'Багатомовність статей та інтерфейсу';
$L['info_desc'] = 'Підтримка багатомовного контенту та категорій модуля Pages, ядро системи щодо багатомовності інтерфейсу.';
$L['info_notes'] = 'Плагін не перекладає контент в інших модулях та плагінах.';


/**
 * Plugin Title & Subtitle
 */



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
