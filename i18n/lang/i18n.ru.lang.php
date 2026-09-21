<?php
/**
 * Russian Language File for i18n modified Plugin for CMF Cotonti, PHP v.8.5+, MySQL v.8.4
 *
 * - название и описание модуля (info_name, info_desc, info_notes)
 * - настройки в админ-панели (cfg_…)
 * - подсказки к полям (cfg_…_hint)
 *
 * Filename: plugins/i18n/lang/i18n.ru.lang.php
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
// ИНФОРМАЦИЯ О РАСШИРЕНИИ
// ========================
$L['info_name']  = 'i18n modified';
$L['info_desc']  = 'Модифицированный плагин мультиязычности интерфейса сайта и статей. Поддержка многоязычного контента в модуле Pages, в ядре и расширениях';
$L['info_notes'] = 'Подробнее: <a href="https://github.com/webitproff/i18n-modified" target="_blank">документация и ссылки на неё</a>.';

$L['i18n_title']       = $L['info_name'];
$L['i18n_desc']        = $L['info_desc'];


// Plugin configuration

$L['cfg_cats'] = 'Корневые категории для применения i18n';
$L['cfg_cats_hint'] = 'Коды категорий через запятую';
$L['cfg_locales'] = 'Список локалей сайта';
$L['cfg_locales_hint'] = 'Каждая локаль с новой строки, формат: locale_code|Заголовок локали';
$L['cfg_omitmain'] = 'Опускать параметр языка в URL, если он указывает на основной язык';
$L['cfg_rewrite'] = 'Включить ЧПУ для параметра языка в ссылках';
$L['cfg_rewrite_hint'] = 'Требует ручного обновления .htaccess';
$L['cfg_cookie'] = 'Запоминать выбранный язык в cookie';

$L['info_desc'] = 'Поддержка многоязычного контента в ядре и расширениях';

// Plugin strings

$L['i18n_adding'] = 'Добавление нового перевода';
$L['i18n_confirm_delete'] = 'Вы действительно хотите удалить перевод?';
$L['i18n_delete'] = 'Удалить перевод';
$L['i18n_editing'] = 'Редактирование перевода';
$L['i18n_incorrect_locale'] = 'Неверная локаль';
$L['i18n_items_added'] = '{$cnt} элементов добавлено';
$L['i18n_items_removed'] = '{$cnt} элементов удалено';
$L['i18n_items_updated'] = '{$cnt} элементов обновлено';
$L['i18n_locale_selection'] = 'Выбор локали';
$L['i18n_localized'] = 'Локализованное';
$L['i18n_no_categories'] = 'Не выбраны категории для перевода. Установить их можно в <a href="%s">настройках интернационализации<a>';
$L['i18n_original'] = 'Оригинал';
$L['i18n_structure'] = 'Интернационализация структуры';
$L['i18n_translate'] = 'Перевести';
$L['i18n_translation'] = 'Перевод';

$L['i18n_pages'] = 'Переводы страниц';
