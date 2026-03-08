<?php
/**
 * Polish Language File for extension: i18n Content Internationalization Plugin (plugins/i18n/lang/i18n.pl.lang.php)
 *
 * i18n plugin for Cotonti 0.9.26, PHP 8.4+
 * Version: 1.0.13
 * Date: March 06th, 2026
 * The translation has been adapted: webitproff, 2026 | https://github.com/webitproff
 * Polish localization: 2026
 *
 * @package i18n
 * @copyright (c) Cotonti Team
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */
defined('COT_CODE') or die('Wrong URL.');

// Plugin configuration
$L['cfg_cats'] = 'Kategorie główne do zastosowania i18n';
$L['cfg_cats_hint'] = 'Kody kategorii oddzielone przecinkami';
$L['cfg_locales'] = 'Lista lokalizacji witryny';
$L['cfg_locales_hint'] = 'Każda lokalizacja w nowej linii, format: locale_code|Nazwa lokalizacji';
$L['cfg_omitmain'] = 'Pomijać parametr języka w URL, jeśli wskazuje na język główny';
$L['cfg_rewrite'] = 'Włączyć przyjazne adresy URL dla parametru języka w linkach';
$L['cfg_rewrite_hint'] = 'Wymaga ręcznej aktualizacji pliku .htaccess';
$L['cfg_cookie'] = 'Zapamiętywać wybrany język w cookie';

/**
 * Plugin Information
 */
$L['info_name'] = 'Wielojęzyczność artykułów i interfejsu';
$L['info_desc'] = 'Wsparcie dla wielojęzycznej treści i kategorii modułu Pages, rdzeń systemu wielojęzyczności interfejsu.';
$L['info_notes'] = 'Plugin nie tłumaczy treści w innych modułach i wtyczkach.';

/**
 * Plugin Title & Subtitle
 */
// Plugin strings
$L['i18n_adding'] = 'Dodawanie nowego tłumaczenia';
$L['i18n_confirm_delete'] = 'Czy na pewno chcesz usunąć tłumaczenie?';
$L['i18n_delete'] = 'Usuń tłumaczenie';
$L['i18n_editing'] = 'Edycja tłumaczenia';
$L['i18n_incorrect_locale'] = 'Nieprawidłowa lokalizacja';
$L['i18n_items_added'] = 'Dodano {$cnt} elementów';
$L['i18n_items_removed'] = 'Usunięto {$cnt} elementów';
$L['i18n_items_updated'] = 'Zaktualizowano {$cnt} elementów';
$L['i18n_locale_selection'] = 'Wybór lokalizacji';
$L['i18n_localized'] = 'Zlokalizowano';
$L['i18n_no_categories'] = 'Nie wybrano kategorii do tłumaczenia. Można je ustawić w <a href="%s">ustawieniach internacjonalizacji</a>';
$L['i18n_original'] = 'Oryginał';
$L['i18n_structure'] = 'Internacjonalizacja struktury';
$L['i18n_translate'] = 'Przetłumacz';
$L['i18n_translation'] = 'Tłumaczenie';