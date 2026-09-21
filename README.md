# i18n modified - Upgraded multilingual plugin for Cotonti 
Modification features: enhanced integration with additional fields (extrapolations), improved interactivity of page translation management, generation of hrefl SEO tags

<a id="intro-en"></a>
## Introduction

The **i18n modified** plugin is a modified version of the standard extension for multilingualism of the site interface and articles, running as part of CMF Cotonti. The plugin provides support for multilingual content in the Pages module, in the core, and in other extensions. The plugin is aimed at sites where it is required not only to change the interface language, but also to maintain full translations of articles, categories, and additional fields.

The version indicated in the files is 2.10-1.0.13. Date — September 19, 2026. Authors — Cotonti Team and webitproff. The plugin is distributed under the BSD license. The required module is `page`, and the recommended plugins are `search` and `tags`. This immediately defines the scope: primarily content sites, catalogs, articles, documentation, and multilingual projects built on the Pages module.

The main feature of the modification is extended integration with additional fields, improved handling of language versions of pages, support for selecting a locale when editing a translation, generation of SEO tags `hreflang` and `x-default`, as well as fixes for the correct operation of the language switcher in the administrative panel.

Below is a detailed overview of the functionality, based solely on the provided files. I will not speculate about things that are not in them, and I will not assume the existence of capabilities that are not confirmed by the code or language strings. All conclusions are made on the basis of an analysis of the plugin structure, the language file, functions, page handlers, template tags, and configuration.

<a id="philosophy-en"></a>
## General philosophy and purpose

The plugin solves two major tasks. The first is interface multilingualism. This means that the user can switch the site language, and interface strings, category names, page titles, and other elements are displayed in the selected language. The second task is multilingual content. This means that the same article or page can have several language versions, each stored separately and editable independently.

At the same time, the plugin does not try to automatically translate content. It provides tools for manually creating translations. The administrator or translator selects a language, fills in the translation fields, and saves them. The original page remains unchanged, and the translation is stored in a separate table. This is a classic approach that allows preserving the integrity of the main content while at the same time giving visitors the ability to read the site in different languages.

It is important that the plugin can work not only with pages, but also with the structure — that is, with categories. This means that you can translate not only the titles and texts of articles, but also section names and their descriptions. For sites with a large number of categories, this is critical, because without translating the structure, navigation in another language looks incomplete.

Another important feature is integration with additional fields. The plugin allows creating translations not only for the standard page fields (title, description, text), but also for arbitrary additional fields that were added through the extrafields system. This opens up the possibility of maintaining multilingual catalogs where product characteristics, technical descriptions, properties, and other structured data are translated.

Finally, the plugin takes care of SEO. In the provided files, there is generation of `alternate` tags with the `hreflang` attribute, as well as the `x-default` tag. This helps search engines understand which language versions of a page exist and which one to show to users with certain language preferences. A full IETF tag is also generated for the `lang` attribute in the `html` tag, which complies with modern standards.

<a id="architecture-en"></a>
## Plugin composition and architecture

Judging by the files, the plugin has a modular structure. Several layers can be distinguished in it.

The first layer is the language file. It contains information about the plugin, settings, and interface strings. In the provided Russian localization file, there is a name, description, note, as well as strings for configuration and the user interface. Separately listed are strings for translating pages, structure, deletion, addition, editing, locale selection, error messages, and successful actions.

The second layer is API functions. In the functions file, the main operations are defined: loading locales, loading structure translations, getting a category translation, getting a page translation, the list of locales for a category and page, checking whether internationalization is enabled for a category, building a category path taking translation into account, saving a translation, and integration with tags. These functions form the core of the plugin and are used by other parts.

The third layer is page handlers. There is a separate file for page translation that handles adding, editing, and deleting translations. There is a file for structure translation that works in the administrative part. There are files that connect to hooks and add tags to templates: `header.tpl`, `page.tpl`, and also override page tags in the generation function.

The fourth layer is configuration. The installation file lists the parameters: `cats`, `locales`, `omitmain`, `rewrite`, `cookie`. These parameters determine which categories participate in multilingualism, which locales are available, how the URL is built, and whether the language should be remembered in a cookie.

The fifth layer is integration with extrafields. There is a file that adds the page translations table to the whitelist of additional fields. This allows the administrator to create additional fields specifically for translations.

The sixth layer is integration with tags. If the tags plugin is installed, i18n modified adds a locale column to the tag relations table and changes the primary key. This allows tags to be stored separately for each language.

The seventh layer is integration with trashcan. If the trashcan plugin is active and configured for the page trash can, then when a translation is deleted, it is first placed in the trash can.

This architecture makes the plugin quite flexible. It is not monolithic: each part is responsible for its own task. At the same time, all parts are connected through common functions and tables.

<a id="entities-en"></a>
## Key entities

To understand how the plugin works, you need to understand several key entities.

- **Locale** — this is a language code, for example, `ru`, `en`, `ua`, `pl`. In the plugin settings, locales are specified as a list, each line of which has the format `code|Name`. For example, `en|English`. The name is used for display in the language switcher. The code is used in the URL and in the database.
- **Default language** — this is the main language of the site. It is taken from the general Cotonti configuration. The plugin automatically adds it to the list of locales if it is not there. Special rules may apply to the default language: for example, the language parameter may be omitted in the URL if the corresponding setting is enabled.
- **Fallback language** — this is the language used if there is no translation for the current locale. In the files it is mentioned as `i18n_fallback`. Judging by the logic, if there is no translation, the original in the default language is displayed. This is standard behavior for multilingual systems.
- **Active locale** — this is the language selected by the user at the moment. It is passed through the `l` parameter in the URL and can be stored in a cookie if the corresponding setting is enabled.
- **Page translation** — this is a record in a separate table that contains the title, description, text, and additional fields for a specific page and a specific locale. Page translations can be added, edited, and deleted. Each translation has an author, date, and locale.
- **Structure translation** — this is a record in another table that contains the title and description of a category for a specific locale. Structure translations are managed only by the administrator.
- **Additional translation fields** — these are fields created through extrafields for the page translations table. They allow storing arbitrary data in different languages.
- **Categories participating in i18n** — these are the root categories listed in the `cats` setting. If a category is not included in this list, then multilingual mechanisms may not apply to it. The check is performed by determining the category's parents.
- **Original** — this is the source page or category in the default language. The original is not overwritten by the translation. The translation exists in parallel.
- **Localized** — this is the translation of a page or category. In the translation interface, both variants are shown: the original and the localized value.

<a id="settings-en"></a>
## Plugin settings

The installation file lists five main settings. Let's consider them in detail.

- **cats** — "Category codes". This is a list of category codes for which internationalization is enabled. In the Russian language file, the hint clarifies: "Category codes separated by commas." That is, the administrator specifies which categories should support translations. If a category is not specified, it probably will not participate in multilingualism. This allows not overloading with translation those sections where it is not needed.
- **locales** — "Site locales". This is the list of site locales. In the Russian file, the hint is: "Each locale on a new line, format: `locale_code|Locale title`." That is, each line contains a code and a display name separated by a vertical bar. For example, `en|English`. This list is used to build the language switcher, to select a locale during translation, and to validate the locale.
- **omitmain** — "Omit language parameter in the URL if pointing to main language". This is a toggle. If it is enabled, then for the main language the language parameter may not be added to the URL. This makes links in the main language cleaner. If it is disabled, the language parameter is always added. In the Russian file, the setting is described as "Omit the language parameter in the URL if it points to the main language."
- **rewrite** — "Enable URL overwrite for language parameter". Enables SEO-friendly URLs for the language parameter. In the Russian file, the hint is: "Requires manual updating of `.htaccess`." That is, if the administrator wants the language in the URL to look like part of the path rather than a parameter, they need to enable this setting and manually update the redirect rules on the server. This is an important point: the plugin does not do this automatically.
- **cookie** — "Remember language selection in cookie". If enabled, the selected language is remembered in a cookie. Then on the next visit the user will automatically see the site in the selected language. In the Russian file: "Remember the selected language in a cookie."

These five settings form the basic configuration. From the language file it is also clear that there are strings for explanations of these settings, that is, the administrator sees hints in Russian.

<a id="locales-en"></a>
## Working with locales

Locales are loaded by a special function. It splits the string into lines, splits each line by the vertical bar, trims spaces, checks that the code and name are not empty, and adds the locale to the array. If the default language is not in the list, it is added automatically. In this case, the name is taken from the general Cotonti language list if present there; otherwise, the code itself is used.

This means that the administrator may not specify the default language in the settings, and the plugin will still know about its existence. But for a complete picture, it is better to specify all languages used on the site.

The list of locales is used in several places. First, for the language switcher in the header. Second, for selecting a locale when adding or editing a page translation. Third, for selecting a locale when translating the structure. Fourth, for checking that the passed locale is valid.

In the language switcher, a link is generated for each locale while preserving the current GET parameters. This is important: if the user is on a page with filters or parameters, they are not lost when switching languages. If the `omitmain` setting is enabled and the current locale matches the fallback language, the `l` parameter is removed from the URL. If cookie is enabled and the language is saved in a cookie, the `omitmain` logic may not apply. This is done to avoid URL duplication and conflicts.

The switcher also determines the `selected` class for the active language. This allows styling the current language in the template.

<a id="cat-i18n-en"></a>
## Determining whether i18n is enabled for a category

The plugin checks whether internationalization is enabled for a specific category. To do this, it gets the list of categories from the `cats` setting, splits it by commas, trims spaces, and checks whether the first parent of the category is in this list. If it is, internationalization is enabled. If not, it is disabled.

This logic allows enabling multilingualism only for certain root sections. For example, you can make a product catalog multilingual, but leave the blog or news untouched. This is convenient because not all sections of the site need translation.

The check function may be called multiple times, so it caches the list of categories in a static variable. This reduces the load on the database and speeds up operation.

<a id="structure-translation-en"></a>
## Structure translation

Structure translation is available only to the administrator. This follows from the rights check: before executing the scenario, a block is triggered if the user does not have i18n administrator rights.

The structure translation workflow looks like this. First, the administrator selects a locale. If no locale is selected or it is equal to the default language, a list of locales is displayed for selection. If a locale is selected, a table of categories with fields for translation is displayed.

In the table, for each category, the original title and description are shown, as well as fields for entering the translation of the title and description. The administrator can change the translation and save. When saving, the plugin iterates over all passed category codes and compares the new values with the old ones. If the translation was empty and remained empty, nothing is done. If the translation was empty and became filled, an insert is performed. If the translation was filled and became empty, a delete is performed. If the translation changed, an update is performed.

After saving, messages are generated about the number of added, updated, and deleted elements. These messages use language file strings with number substitution. Logging is also maintained: addition, editing, and deletion of category translations.

The structure translation table has pagination. The number of elements per page is taken from the general `maxrowsperpage` setting if it is set and positive; otherwise, the default value of 15 is used. This allows comfortable work with a large number of categories.

Before displaying the table, the plugin loads structure translations from the database and saves them to cache if caching is enabled. This speeds up subsequent requests.

If no categories are specified in the `cats` setting, the administrator is shown a warning with a link to the plugin settings page. This helps to quickly fix the configuration.

Thus, structure translation is a full-fledged administrative tool with pagination, bulk saving, messages, and logging.

<a id="page-translation-en"></a>
## Page translation

Page translation is a more complex process because it is available not only to the administrator, but also to translators and authors. In the page handler file, there are three main branches: adding, editing, and deleting.

**Adding a translation.** First, it checks that the page exists and the identifier is correct. If the page does not exist, a 404 is issued. Then the page data is loaded. If the action is adding, the translation is not loaded; an empty array is created. If the action is editing, the existing translation for the specified locale is loaded.

When adding a translation, the request method is checked first. If it is POST, the selected locale is imported. It checks that the locale is in the list of available ones. If not — the error "Invalid locale". Then it checks whether a translation already exists for this page and this locale. If it does — the error "Translation already exists". Then an array of translation data is formed: page identifier, locale, translator identifier, translator name, date, title, description, text. Additional fields are also imported if they exist. The title length is checked: if it is less than two characters — the error "Title is too short". If there are no errors, the record is inserted into the database. Then hooks are executed, the message "Added" is displayed, logging is performed, the page URL is formed taking the locale into account, and a redirect is performed.

If the request is not POST or there are errors, the add translation form is displayed. In the form there is a locale selector that excludes the default language and already existing translations. The original title, description, and text of the page are shown, as well as fields for entering the translation. A text editor is used for the text. Additional fields are output into the template as separate blocks.

**Editing a translation.** Editing is available if the translation exists and the user is an i18n administrator, or has edit rights, or is the author of the translation. On POST, the new locale is imported. Its validity is checked. If the locale has changed, it checks whether a translation already exists for the new locale. If it does — error. Then the date, title, description, and text are updated. If the locale has changed, it is also updated. Additional fields are imported with old values passed. If there are errors, the form is displayed again with filled fields. If there are no errors, the database record is updated. Then hooks, the message "Updated", logging, URL formation, and redirect.

The edit form also has a locale selector. It excludes the default language and occupied locales except the current one. The selector value is taken from POST on error or from the current locale. The form fields are filled with the entered data on error or with the current translation data. Additional fields are output similarly to adding.

**Deleting a translation.** Deletion is available to the administrator or the author of the translation. If the trashcan plugin is active and configured for the page trash can, the translation is first placed in the trash can. Then the record is deleted from the database. Hooks are executed, the message "Deleted" is displayed, logging is performed, the page URL is formed, and a redirect is performed.

If the action is not recognized or rights are insufficient, an error message is issued.

Thus, page translation is a full-fledged CRUD interface with checks, messages, logging, support for additional fields, and integration with the trash can.

<a id="extrafields-en"></a>
## Additional fields in translations

One of the key features of the modification is deep integration with additional fields. In the page handler file, it can be seen that when adding and editing a translation, the configuration of additional fields for the page translations table is loaded. Then, in a loop over each field, a field name with a prefix is formed, the value is imported from POST taking the old value into account, and saved into the translation data array.

In the translation form, an input element and a title are generated for each additional field. This data is passed to the template. For each field, tags with the field name in uppercase are formed, as well as general `EXTRAFLD` tags. This allows outputting additional fields in the template both individually and in a loop.

In the file that adds the translations table to the whitelist of additional fields, it is stated that additional fields can be created for the `i18n_pages` table. The description states that the template tags are `I18N_PAGE_FORM_XXXXX` and `I18N_PAGE_FORM_XXXXX_TITLE`. This means that the administrator can create an additional field, for example, "material", and in the translation template use the tag `I18N_PAGE_FORM_MATERIAL`.

In addition, additional translation fields are output in the header and in `page.tags`. In the header, the tags `I18N_HEADER_XXXXX`, `I18N_HEADER_XXXXX_TITLE`, `I18N_HEADER_XXXXX_VALUE` are formed. In `page.tags`, the tags `I18N_XXXXX_TITLE`, `I18N_XXXXX`, `I18N_XXXXX_VALUE` are formed, as well as the dynamic `EXTRAFLD` block.

In `pagetags.main`, additional translation fields are added to the page tags array with the prefix `I18N_PAGE_`. If there is no translation, the tags are reset to empty values.

Thus, additional fields can be used not only in the translation form, but also anywhere in the template: in the header, in the page card, in lists, in SEO tags. This makes the system very flexible.

<a id="header-switcher-en"></a>
## Language switcher in header

In the `header.tags.php` file, the language switcher and SEO tag generation are implemented. Let's consider its capabilities.

First, a drop-down list of languages is built. For each locale, the `selected` class is determined if it matches the current one. All GET parameters are preserved. If the `omitmain` setting is enabled and the locale matches the fallback language, the `l` parameter is removed. If cookie is enabled and the language is saved in a cookie, the `omitmain` condition may not apply. It determines whether we are inside the plugin and forms the URL. If we are in the admin panel, the URL is built with the `admin` prefix. This fix is important because without it, switching the language in the admin panel could lead to an incorrect URL.

Then tags are passed to the template: URL, locale code, flag (for English, the UK flag is used), title, class, selected. These tags can be used in `header.tpl` to render the switcher.

Next, the full IETF tag for the `lang` attribute is set. For this, a map of correspondence between short codes and full tags is used. For example, `ua` is converted to `uk-UA`. If there is no correspondence, the short code is used. The resulting value is passed to the template as `HTML_LANG`. This allows using `<html lang="{HTML_LANG}">` in `header.tpl`.

Then `alternate` `hreflang` tags are generated for translated pages. If we are on a page of the `page` module and there is an identifier, the list of locales into which the page has been translated is obtained. For each locale except the default language, a URL with the `l` parameter and a `link` tag with the `hreflang` attribute are generated. An `x-default` tag is also generated. If `omitmain` is enabled, `x-default` points to the URL without the language prefix. If disabled, it points to the URL with the default language prefix. All tags are passed to the template as `ALTERNATE_TAGS`.

Finally, additional translation fields are passed to the header. If a translation exists and there are additional fields, then for each field the tags `I18N_HEADER_XXXXX`, `I18N_HEADER_XXXXX_TITLE`, `I18N_HEADER_XXXXX_VALUE` are formed. The value is processed through the parser and escaped. If there is no translation, the tags are reset.

Thus, the header receives everything necessary: the switcher, the correct `lang`, `hreflang`, `x-default`, and additional fields.

<a id="page-tags-en"></a>
## Page tags

In the `page.tags.php` file, tags for the page are assigned. If internationalization is enabled, a list of locales for the page is formed. If there are translations, a language switcher for the page is built. For each locale, a URL is formed taking the alias or identifier into account, the `l` parameter is added if necessary. The tags URL, code, title, class, selected are passed.

If the user has write permission, tags for translation are added. If a translation exists and the user can edit it, an edit link is added. If there is no translation and the number of locales is less than the total number, a "Translate" button is added.

If the user is an administrator, a delete translation button with confirmation is added.

Additional translation fields are also output: for each field, the tags `I18N_XXXXX_TITLE`, `I18N_XXXXX`, `I18N_XXXXX_VALUE` are formed, as well as the dynamic `EXTRAFLD` block.

This allows `page.tpl` to output the language switcher, translation management buttons, and additional fields.

<a id="pagetags-override-en"></a>
## Overriding page tags

In the `pagetags.main.php` file, page tags are overridden in the generation function. If internationalization is enabled and the current language is not the main one, the category translation is loaded. If there is a category translation, the category URL, validation URL, edit URL, category path, breadcrumbs, category title, category description are formed. Administrator links are also added: edit, approve, submit for approval. If there is no category translation, the original is used.

If there is a page translation, the page URL, title, breadcrumbs, description, text, trimmed text, trim flag, "Read more" link, update date are formed. Additional translation fields are also added.

If there is no translation, the additional field tags are reset.

If the user has write permission and a translation exists, an edit translation link is added.

All these tags are merged with the main page tags. This allows page templates to use translated values automatically.

<a id="title-override-en"></a>
## Overriding title and description

In the `page.main.php` file, it is shown how the page title, subtitle, and description are overridden. If internationalization is enabled and the current language is not the main one, the page translation and category translation are loaded. If there is a page translation, title parameters are formed taking the translated title and translated category into account. The subtitle and description are set. Then the translation data is merged with the page data. This means that all subsequent handlers see already translated values.

This is an important point: the plugin does not just add separate tags, it replaces the page data with the translation if one exists. This ensures consistency across all modules and templates.

<a id="tags-integration-en"></a>
## Integration with tags

If the tags plugin is installed, i18n modified adds locale support to tags. In the integration installation function, it checks whether tags is installed. If yes, the tags API is connected. Then it checks whether the `tag_locale` column exists in the tag relations table. If not, it is added. After that, the primary key is dropped and a new one is created that includes `tag_locale`. This allows tags to be stored separately for each language.

This means that on a multilingual site, tags can be translated or at least tied to a language. This is useful for SEO and navigation.

<a id="trashcan-integration-en"></a>
## Integration with trashcan

If the trashcan plugin is active and configured for the page trash can, when deleting a page translation it is first placed in the trash can. To do this, the translation record is loaded, a description is formed, and the trash can service is called. Only after that is the record deleted from the translations table. This allows restoring a deleted translation if it was deleted by mistake.

<a id="rights-en"></a>
## Rights and security

The plugin uses several levels of rights. The variables `i18n_admin`, `i18n_write`, `i18n_read`, `i18n_edit`, `i18n_notmain`, `i18n_locale`, `i18n_fallback` determine what the user can do.

The i18n administrator can translate the structure, edit and delete any translations. A user with write permission can add translations and edit their own translations. The author of a translation can edit and delete their own translation. A guest can only read.

Rights checks are performed before executing actions. If rights are insufficient, an error message or redirect is issued.

The validity of the locale, duplicate translations, and title length are also checked. This prevents incorrect data.

<a id="urls-en"></a>
## Multilingual URLs

The plugin supports several URL modes. The language parameter can be passed as `l` in the query string. If the `rewrite` setting is enabled, the language can be part of a SEO-friendly URL. If the `omitmain` setting is enabled, the parameter may be omitted for the main language. If cookie is enabled, the selected language is remembered.

This gives flexibility: you can make simple URLs for the main language and language prefixes for the others. You can use SEO-friendly URLs, but for this you need to manually update `.htaccess`.

<a id="templates-en"></a>
## Templates and tags

The plugin uses several templates: `i18n.page.tpl` for the page translation form, `i18n.structure.tpl` for the structure translation table, `i18n.locales.tpl` for locale selection. It also adds tags to `header.tpl` and `page.tpl`.

In `header.tpl`, the tags `I18N_LANG_ROW_URL`, `I18N_LANG_ROW_CODE`, `I18N_LANG_ROW_TITLE`, `I18N_LANG_ROW_CLASS`, `I18N_LANG_ROW_SELECTED`, `HTML_LANG`, `ALTERNATE_TAGS`, `I18N_HEADER_XXXXX` can be used.

In `page.tpl`, the tags `I18N_LANG_ROW_*`, `PAGE_I18N_TRANSLATE`, `PAGE_I18N_DELETE`, `I18N_XXXXX`, `I18N_EXTRAFIELD_TITLE`, `I18N_EXTRAFIELD_VALUE` can be used.

In the page translation template, the tags `I18N_ACTION`, `I18N_TITLE`, `I18N_ORIGINAL_LANG`, `I18N_LOCALIZED_LANG`, `I18N_PAGE_TITLE`, `I18N_PAGE_DESC`, `I18N_PAGE_TEXT`, `I18N_IPAGE_TITLE`, `I18N_IPAGE_DESC`, `I18N_IPAGE_TEXT`, `I18N_PAGE_FORM_XXXXX`, `I18N_PAGE_FORM_XXXXX_TITLE`, `I18N_PAGE_FORM_EXTRAFLD`, `I18N_PAGE_FORM_EXTRAFLD_TITLE` are used.

In the structure template, the tags `I18N_ACTION`, `I18N_ORIGINAL_LANG`, `I18N_TARGET_LANG`, `I18N_CATEGORY_ROW_TITLE`, `I18N_CATEGORY_ROW_DESC`, `I18N_CATEGORY_ROW_CODE_NAME`, `I18N_CATEGORY_ROW_CODE_VALUE`, `I18N_CATEGORY_ROW_ITITLE_NAME`, `I18N_CATEGORY_ROW_ITITLE_VALUE`, `I18N_CATEGORY_ROW_IDESC_NAME`, `I18N_CATEGORY_ROW_IDESC_VALUE`, `I18N_CATEGORY_ROW_ODDEVEN`, `I18N_PAGINATION_PREV`, `I18N_PAGNAV`, `I18N_PAGINATION_NEXT` are used.

This allows you to fully customize the appearance for a specific template.

<a id="admin-interface-en"></a>
## Administrative interface

The administrative interface includes plugin settings, structure translation, and management of additional fields. The settings are located in the general plugin configuration. Structure translation is available through a separate section. Additional fields for translations are created through the general extrafields interface.

In the settings, the administrator specifies categories, locales, the `omitmain` mode, `rewrite`, and `cookie`. In structure translation, they select a locale and fill in category titles and descriptions. In extrafields, they create fields for the `i18n_pages` table.

<a id="logging-en"></a>
## Logging and messages

The plugin logs actions: adding, editing, and deleting page and category translations. Messages are displayed to the user: "Added", "Updated", "Deleted", "Invalid locale", "Translation already exists", "Title is too short", "No products", and others. The number of added, updated, and deleted structure elements is displayed with number substitution.

This helps the administrator monitor changes and quickly respond to errors.

<a id="seo-en"></a>
## SEO capabilities

The plugin generates a full IETF tag for the `lang` attribute, `alternate` `hreflang` tags for translated pages, and the `x-default` tag. This improves indexing of multilingual pages by search engines. Titles, descriptions, and meta tags are also translated, which has a positive effect on SEO.

<a id="scenarios-en"></a>
## Practical scenarios

- **Adding a new language.** The administrator adds a locale in the settings, specifies the code and name. The language appears in the switcher. Then they translate the structure and pages.
- **Translating an article.** The author opens the page, clicks "Translate", selects a locale, fills in the title, description, text, and additional fields. Saves. The translation appears on the site.
- **Translating a category.** The administrator goes to structure translation, selects a locale, fills in category titles and descriptions. Saves.
- **Configuring SEO-friendly URLs.** The administrator enables `rewrite` and updates `.htaccess`. The language becomes part of the URL.
- **Remembering the language.** The administrator enables cookie. The user selects a language, and it is saved.
- **Deleting a translation.** The administrator or author deletes the translation. If trashcan is active, the translation goes to the trash can.

<a id="limitations-en"></a>
## Features and limitations

The plugin works with the `page` module. Support for other modules may be absent. SEO-friendly URLs require manual updating of `.htaccess`. Locales are specified manually. Categories for i18n are specified comma-separated. Additional fields are created through extrafields. Integration with tags and trashcan is optional.

<a id="conclusion-en"></a>
## Conclusion

i18n modified is a powerful tool for creating multilingual sites on Cotonti. It combines a language switcher, structure translation, page translation, support for additional fields, SEO tags, and integration with tags and trashcan. Flexible settings allow it to be adapted to different scenarios. The administrative interface gives full control over translations. The rights system differentiates access. Logging and messages help track changes. All this makes the plugin suitable for serious multilingual projects where not only interface strings are important, but also full content translation.

[Русский: i18n modified - Модифицированный плагин мультиязычности для Cotonti](https://abuyfile.com/en/market/cotonti/plugs/i18n-modified) 

[Cotonti: Локализация и мультиязычность сайта](https://abuyfile.com/ru/forums/cotonti/lang-localiz) 

[Integrating Extrafields into the I18n plugin in Cotonti CMF](https://abuyfile.com/en/cotonti/authorial-plugins/integraciya-extrafields-v-plagin-i18n-v-cotonti-cmf)


