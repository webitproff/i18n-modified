<?php
/**
 * ============================================================
 * ДОКУМЕНТАЦИЯ ПО INSTALL-ХЕНДЛЕРУ i18n.install.php
 * ============================================================
 *
 * Файл представляет собой install-handler плагина i18n modified.
 * Вызывается автоматически ядром Cotonti в момент установки плагина
 * — сразу после того, как cot_extension_install() выполнит
 * cot_config_add() и создаст записи параметров конфигурации
 * в таблице config.
 *
 * Точка вызова:
 *
 *   cot_extension_install() из system/extensions.php
 *   → после cot_config_add()
 *   → ищет файл setup/<код_плагина>.install.php
 *   → выполняет его через include
 *
 * Назначение хендлера:
 *
 *   1) Перезаписать значение параметра `locales` на многострочное.
 *      Формат каждой строки: код|Название.
 *      Разбор выполняется в cot_i18n_load_locales() через
 *      preg_split('#\r?\n#') — то есть по переносам строк.
 *
 *   2) На данном этапе в БД уже лежат однострочные значения
 *      из секции [BEGIN_COT_EXT_CONFIG] setup-файла
 *      (для `locales` — «en|English»).
 *      Хендлер заменяет их на полный список локалей.
 *
 * Почему это делается именно здесь:
 *
 *   Формат setup-строки однострочный. Переносы строк внутри значения
 *   физически разорвут структуру ключ=значение и сломают чтение
 *   через cot_infoget(). Поэтому многострочные значения нельзя
 *   объявить в setup-файле — только через PHP-код после установки.
 *
 * Что меняется в БД:
 *
 *   UPDATE <db_config>
 *   SET    config_value   = <локали>,
 *          config_default = <локали>
 *   WHERE  config_owner = 'plug'
 *          AND config_cat = 'i18n'
 *          AND config_name = 'locales';
 *
 *   config_value   — текущее значение, которое видят плагин и админка;
 *   config_default — значение по умолчанию (используется при сбросе).
 *
 * Интеграция с плагином tags:
 *
 *   Если плагин tags установлен, вызывается
 *   cot_i18n_installTagsIntegration(). Она:
 *
 *     - проверяет наличие колонки tag_locale в таблице tag_references;
 *     - при отсутствии — добавляет её (ALTER TABLE ... ADD COLUMN);
 *     - удаляет старый первичный ключ;
 *     - создаёт новый первичный ключ с включением tag_locale.
 *
 *   Это позволяет хранить теги отдельно для каждой локали.
 *
 * Побочные эффекты и окружение:
 *
 *   - файл подключается ядром, а не пользователем; защита COT_CODE
 *     обязательна;
 *   - объект Cot::$db доступен и инициализирован к моменту вызова;
 *   - глобальные массивы $L и $R пробрасываются в включаемый файл,
 *     если подключение tags требует их наличия.
 *
 * Совместимость и происхождение:
 *
 *   Файл — часть модификации i18n modified. Он не заменяет ядро
 *   Cotonti и не переопределяет его функции, а использует штатную
 *   точку расширения — install-handler.
 *
 * ============================================================
 *
 * Filename: plugins/i18n/setup/i18n.install.php
 * Path:     plugins/i18n/setup/i18n.install.php
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

use cot\extensions\ExtensionsService;

defined('COT_CODE') or die('Wrong URL');

// Многострочный список локалей: по одной в строке, формат "код|Название".
// Разбор — в cot_i18n_load_locales() через preg_split('#\r?\n#').
$locales = "en|English\nru|Русский\nua|Українська";

Cot::$db->update(
    Cot::$db->config,
    [
        'config_value'   => $locales,
        'config_default' => $locales,
    ],
    "config_owner = 'plug' AND config_cat = 'i18n' AND config_name = 'locales'"
);

// Интеграция с плагином tags: добавляет колонку tag_locale
// в таблицу tag_references и меняет первичный ключ.
if (ExtensionsService::getInstance()->isInstalled('tags')) {
    global $L, $R;

    require_once cot_incfile('i18n', 'plug');

    cot_i18n_installTagsIntegration();
}
