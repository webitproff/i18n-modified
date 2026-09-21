<?php
/* ====================
[BEGIN_COT_EXT]
Code=i18n
Name=i18n modified
Category=i18n
Description=Enables site contents translation into multiple languages
Version=2.10-1.0.13
Date=2026-09-19
Author=Trustmaster, Cotonti Team, webitproff
Copyright=Copyright (c) Cotonti Team 2010-2025
Notes=BSD License
Auth_guests=R
Lock_guests=12345A
Auth_members=RW
Lock_members=
Requires_modules=page
Recommends_plugins=search,tags
Order=50
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
cats=01:text::news,articles,blog,catalog,products:Category codes
locales=02:text::en|English:Site locales
omitmain=03:radio::1:Omit language parameter in the URL if pointing to main language
rewrite=04:radio::0:Enable URL overwrite for language parameter
cookie=05:radio::0:Remember language selection in cookie
[END_COT_EXT_CONFIG]
==================== */

/**
 * ============================================================
 * ДОКУМЕНТАЦИЯ ПО SETUP-ФАЙЛУ i18n.setup.php
 * ============================================================
 *
 * Setup-файл плагина i18n modified — это точка объявления расширения
 * для системы Cotonti. Через него ядро получает всю метаинформацию
 * о плагине и список конфигурационных параметров.
 *
 * Формат секций:
 *
 *   BEGIN_COT_EXT       — метаданные расширения;
 *   BEGIN_COT_EXT_CONFIG — параметры конфигурации.
 *
 * Обе секции разбираются функцией cot_infoget(), которая извлекает
 * пары «ключ=значение» построчно. Секции должны быть заключены
 * в блочный комментарий /* ... *\/, чтобы PHP не исполнял их содержимое.
 *
 * Метаданные плагина (секция COT_EXT):
 *
 *   Code               — код плагина (совпадает с именем папки и файлов).
 *   Name               — отображаемое имя в списке расширений админки.
 *   Category           — группа в админке (языковой ключ ext_cat_<код>).
 *   Description        — краткое описание плагина.
 *   Version            — версия в формате A.B.C (сравнивается с ct_version
 *                        при обновлении).
 *   Date               — дата релиза.
 *   Author             — авторы расширения.
 *   Copyright          — копирайт.
 *   Notes              — сведения о лицензии.
 *   Auth_guests        — права групп-гостей (R = read, W = write).
 *   Lock_guests        — список групп, для которых право заблокировано.
 *   Auth_members       — права участников.
 *   Lock_members       — список заблокированных групп для участников.
 *   Requires_modules   — обязательные модули (через запятую).
 *   Recommends_plugins — рекомендуемые плагины.
 *   Order              — порядок выполнения хуков по умолчанию.
 *
 * Параметры конфигурации (секция COT_EXT_CONFIG):
 *
 * Формат setup-строки:
 *   имя=порядок:тип:варианты:default:текст
 *
 *   имя      — имя параметра в таблице config (колонка config_name).
 *   порядок  — позиция в списке (config_order).
 *   тип      — тип поля (см. COT_CONFIG_TYPE_* в system/configuration.php):
 *                string   — однострочное поле;
 *                text     — textarea (по умолчанию);
 *                select   — выпадающий список;
 *                radio    — переключатель да/нет;
 *                range    — целочисленный диапазон;
 *                hidden   — скрытое значение;
 *                callback — список из callback-функции;
 *                custom   — пользовательский тип.
 *   варианты — список значений для select / выражение для custom.
 *   default  — значение по умолчанию (config_value и config_default).
 *   текст    — описание (используется как fallback, если нет ключа
 *              cfg_<имя> в языковом файле).
 *
 * Пять параметров плагина:
 *
 *   1) cats      — список кодов категорий, участвующих в мультиязычности.
 *                  Хранится в виде строки с кодами через запятую.
 *   2) locales   — список локалей сайта. Формат значения: код|Название,
 *                  каждое с новой строки.
 *   3) omitmain  — опускать ли параметр языка в URL для основного языка
 *                  сайта (radio yes/no).
 *   4) rewrite   — включать ли ЧПУ для параметра языка. Требует ручного
 *                  обновления .htaccess (radio yes/no).
 *   5) cookie    — запоминать выбранный язык в cookie (radio yes/no).
 *
 * ВАЖНО. Значения default в этой секции — однострочные. Многострочные
 * значения (три локали, пять категорий с переносами строк) записать
 * в setup-файл физически невозможно, потому что формат setup-строки
 * не допускает переносов. Поэтому финальные многострочные значения
 * устанавливаются после cot_config_add() из setup/i18n.install.php.
 *
 * Файл подключается ядром Cotonti при установке или обновлении плагина
 * в функции cot_extension_install(). Прямой запуск через браузер
 * запрещён — в конце файла стоит проверка defined('COT_CODE').
 *
 * ============================================================
 *
 * Filename: i18n.setup.php
 * Path:     plugins/i18n/i18n.setup.php
 *
 * i18n modified plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4
 *
 * Source and updates   https://github.com/webitproff/i18n-modified
 * ReadMeMore:          https://abuyfile.com/ru/market/cotonti/plugs/i18n-modified
 * Support:             https://abuyfile.com/ru/forums/cotonti/lang-localiz
 *
 * Date: Sep 19, 2026
 *
 * @package    i18n
 * @subpackage Setup
 * @version    2.10-1.0.13
 * @author     Trustmaster, Cotonti Team, webitproff
 * @copyright  Copyright (c) Cotonti Team 2010-2025
 * @license    BSD
 * ============================================================
 */

defined('COT_CODE') or die('Wrong URL.');
