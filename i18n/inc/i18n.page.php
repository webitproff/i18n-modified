<?php
/**
 * Page translation tool
 *
 * @package I18n
 * @copyright (c) Cotonti Team
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

use cot\plugins\trashcan\inc\TrashcanService;

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('page', 'module');
require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$l = cot_import('l', 'G', 'ALP');

if (!$id || $id < 1) {
    cot_die_message(404);
}

/* === Hook === */
foreach (cot_getextplugins('i18n.page.first') as $pl) {
    include $pl;
}
/* =============*/

$stmt = Cot::$db->query('SELECT * FROM ' . Cot::$db->pages . ' WHERE page_id = ?', $id);

if ($id > 0 && $stmt->rowCount() == 1) {
    $pag = $stmt->fetch();
    $stmt->closeCursor();

    // Для добавления перевод не загружаем
    if ($a == 'add') {
        $pag_i18n = [];
    } else {
        $stmt = Cot::$db->query('SELECT * FROM ' . Cot::$db->i18n_pages . " WHERE ipage_id = ? AND ipage_locale = ?",
            [$id, $i18n_locale]);
        $pag_i18n = $stmt->rowCount() == 1 ? $stmt->fetch() : [];
        $stmt->closeCursor();
    }

    // ------------------------------------------------------------------
    // ДОБАВЛЕНИЕ НОВОГО ПЕРЕВОДА (без изменений)
    // ------------------------------------------------------------------
    if ($a == 'add' && empty($pag_i18n)) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $selected_locale = cot_import('locale', 'P', 'ALP');
            if (!in_array($selected_locale, array_keys($i18n_locales))) {
                cot_error('i18n_incorrect_locale', 'locale');
            }
            if (empty(cot_error_found())) {
                $checkStmt = Cot::$db->query(
                    'SELECT 1 FROM ' . Cot::$db->i18n_pages . ' WHERE ipage_id = ? AND ipage_locale = ?',
                    [$id, $selected_locale]
                );
                if ($checkStmt->rowCount() > 0) {
                    cot_error('i18n_translation_exists', 'locale');
                }
                $checkStmt->closeCursor();
            }
            $pag_i18n = [
                'ipage_id' => $id,
                'ipage_locale' => $selected_locale,
                'ipage_translatorid' => Cot::$usr['id'],
                'ipage_translatorname' => Cot::$usr['name'],
                'ipage_date' => Cot::$sys['now'],
                'ipage_title' => cot_import('title', 'P', 'TXT'),
                'ipage_desc' => cot_import('desc', 'P', 'TXT'),
                'ipage_text' => cot_import('translate_text', 'P', 'HTM')
            ];
            if (mb_strlen($pag_i18n['ipage_title']) < 2) {
                cot_error('page_titletooshort', 'title');
            }
            if (!cot_error_found()) {
                Cot::$db->insert(Cot::$db->i18n_pages, $pag_i18n);
                foreach (cot_getextplugins('i18n.page.add.done') as $pl) {
                    include $pl;
                }
                cot_message('Added');
                cot_log('Add translate for page #' . $id, 'i18n', 'page', 'add');
                $page_urlp = empty($pag['page_alias']) ? "c={$pag['page_cat']}&id=$id&l=" . $selected_locale
                    : 'c=' . $pag['page_cat'] . '&al=' . $pag['page_alias'] . '&l=' . $selected_locale;
                cot_redirect(cot_url('page', $page_urlp, '', true, false, true));
            }
        }

        Cot::$out['subtitle'] = Cot::$L['i18n_adding'];

        $t = new XTemplate(cot_tplfile('i18n.page', 'plug'));

        $lc_list = $i18n_locales;
        unset($lc_list[Cot::$cfg['defaultlang']]);
        foreach (cot_i18n_list_page_locales($id) as $lc) {
            unset($lc_list[$lc]);
        }
        $lc_values = array_keys($lc_list);
        $lc_names = array_values($lc_list);

        $selected_in_selector = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($pag_i18n['ipage_locale'])) ? $pag_i18n['ipage_locale'] : '';
        $title_val = isset($pag_i18n['ipage_title']) ? $pag_i18n['ipage_title'] : '';
        $desc_val = isset($pag_i18n['ipage_desc']) ? $pag_i18n['ipage_desc'] : '';
        $text_val = isset($pag_i18n['ipage_text']) ? $pag_i18n['ipage_text'] : (isset($pag['page_text']) ? $pag['page_text'] : '');

        $t->assign([
            'I18N_ACTION' => cot_url('plug', "e=i18n&m=page&a=add&id=$id"),
            'I18N_TITLE' => Cot::$L['i18n_adding'],
            'I18N_ORIGINAL_LANG' => $i18n_locales[Cot::$cfg['defaultlang']],
            'I18N_LOCALIZED_LANG' => cot_selectbox($selected_in_selector, 'locale', $lc_values, $lc_names, false),
            'I18N_PAGE_TITLE' => htmlspecialchars($pag['page_title']),
            'I18N_PAGE_DESC' => htmlspecialchars($pag['page_desc']),
            'I18N_PAGE_TEXT' => cot_parse($pag['page_text'], Cot::$cfg['page']['markup']),
            'I18N_IPAGE_TITLE' => htmlspecialchars($title_val),
            'I18N_IPAGE_DESC' => htmlspecialchars($desc_val),
            'I18N_IPAGE_TEXT' => cot_textarea('translate_text', $text_val, 32, 80, '', 'input_textarea_editor')
        ]);

        cot_display_messages($t);

        foreach (cot_getextplugins('i18n.page.translate.tags') as $pl) {
            include $pl;
        }
    }
    // ------------------------------------------------------------------
    // РЕДАКТИРОВАНИЕ (ДОБАВЛЕН СЕЛЕКТОР ЛОКАЛИ)
    // ------------------------------------------------------------------
    elseif (
        $a == 'edit' && !empty($pag_i18n)
        && ($i18n_admin || $i18n_edit || Cot::$usr['id'] == $pag_i18n['ipage_translatorid'])
    ) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Получаем новую локаль из POST
            $new_locale = cot_import('locale', 'P', 'ALP');
            // Проверяем допустимость
            if (!in_array($new_locale, array_keys($i18n_locales))) {
                cot_error('i18n_incorrect_locale', 'locale');
            }
            // Если локаль изменилась, проверяем, нет ли уже перевода для новой локали
            if ($new_locale != $i18n_locale && empty(cot_error_found())) {
                $checkStmt = Cot::$db->query(
                    'SELECT 1 FROM ' . Cot::$db->i18n_pages . ' WHERE ipage_id = ? AND ipage_locale = ?',
                    [$id, $new_locale]
                );
                if ($checkStmt->rowCount() > 0) {
                    cot_error('i18n_translation_exists', 'locale');
                }
                $checkStmt->closeCursor();
            }

            // Обновляем данные перевода
            $pag_i18n['ipage_date'] = Cot::$sys['now'];
            $pag_i18n['ipage_title'] = cot_import('title', 'P', 'TXT');
            if (mb_strlen($pag_i18n['ipage_title']) < 2) {
                cot_error('page_titletooshort', 'rpagetitle');
            }
            $pag_i18n['ipage_desc'] = cot_import('desc', 'P', 'TXT');
            $pag_i18n['ipage_text'] = cot_import('translate_text', 'P', 'HTM');
            // Если локаль изменилась, обновляем и её
            $pag_i18n['ipage_locale'] = $new_locale;

            if (cot_error_found()) {
                // При ошибках не делаем редирект, а покажем форму снова с заполненными полями
                // Для этого нужно сохранить $pag_i18n с новыми данными и $new_locale
                // Просто продолжим выполнение до отрисовки формы
            } else {
                // Если локаль изменилась, удаляем старую запись и вставляем новую? 
                // Или просто обновляем, меняя ipage_locale. 
                // Проще обновить, но условие WHERE должно быть по старой локали.
                Cot::$db->update(Cot::$db->i18n_pages,
                    [
                        'ipage_locale' => $new_locale,
                        'ipage_date' => $pag_i18n['ipage_date'],
                        'ipage_title' => $pag_i18n['ipage_title'],
                        'ipage_desc' => $pag_i18n['ipage_desc'],
                        'ipage_text' => $pag_i18n['ipage_text']
                    ],
                    "ipage_id = ? AND ipage_locale = ?",
                    [$id, $i18n_locale]
                );

                /* === Hook === */
                foreach (cot_getextplugins('i18n.page.edit.update') as $pl) {
                    include $pl;
                }
                /* =============*/

                cot_message('Updated');
                cot_log("Edited translate for page #" . $id, 'i18n', 'page', 'edit');
                $page_urlp = empty($pag['page_alias']) ? 'c=' . $pag['page_cat'] . "&id=$id&l=" . $new_locale
                    : 'c=' . $pag['page_cat'] . '&al=' . $pag['page_alias'] . '&l=' . $new_locale;
                cot_redirect(cot_url('page', $page_urlp, '', true, false, true));
            }
        }

        Cot::$out['subtitle'] = Cot::$L['i18n_editing'];

        $t = new XTemplate(cot_tplfile('i18n.page', 'plug'));

        // Формируем список локалей для селектора
        // Все доступные локали
        $lc_list = $i18n_locales;
        // Исключаем язык оригинала
        unset($lc_list[Cot::$cfg['defaultlang']]);
        // Получаем все существующие переводы для этой страницы
        $existing = cot_i18n_list_page_locales($id);
        // Удаляем из списка те локали, которые уже заняты (кроме текущей)
        foreach ($existing as $lc) {
            if ($lc != $i18n_locale) {
                unset($lc_list[$lc]);
            }
        }
        $lc_values = array_keys($lc_list);
        $lc_names = array_values($lc_list);

        // Значение для селектора: если форма отправлена с ошибкой, берём из POST, иначе текущая локаль
        $selected_in_selector = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($new_locale)) ? $new_locale : $i18n_locale;

        // Для полей формы при ошибке подставляем введённые данные
        $title_val = ($_SERVER['REQUEST_METHOD'] == 'POST') ? cot_import('title', 'P', 'TXT') : $pag_i18n['ipage_title'];
        $desc_val = ($_SERVER['REQUEST_METHOD'] == 'POST') ? cot_import('desc', 'P', 'TXT') : $pag_i18n['ipage_desc'];
        $text_val = ($_SERVER['REQUEST_METHOD'] == 'POST') ? cot_import('translate_text', 'P', 'HTM') : $pag_i18n['ipage_text'];

        $t->assign([
            'I18N_ACTION' => cot_url('plug', "e=i18n&m=page&a=edit&id=$id&l=$i18n_locale"),
            'I18N_TITLE' => Cot::$L['i18n_editing'],
            'I18N_ORIGINAL_LANG' => $i18n_locales[Cot::$cfg['defaultlang']],
            // Вместо текста теперь селектор
            'I18N_LOCALIZED_LANG' => cot_selectbox($selected_in_selector, 'locale', $lc_values, $lc_names, false),
            'I18N_PAGE_TITLE' => htmlspecialchars($pag['page_title']),
            'I18N_PAGE_DESC' => htmlspecialchars($pag['page_desc']),
            'I18N_PAGE_TEXT' => cot_parse($pag['page_text'], Cot::$cfg['page']['markup']),
            'I18N_IPAGE_TITLE' => htmlspecialchars($title_val),
            'I18N_IPAGE_DESC' => htmlspecialchars($desc_val),
            'I18N_IPAGE_TEXT' => cot_textarea('translate_text', $text_val, 32, 80, '', 'input_textarea_editor')
        ]);

        cot_display_messages($t);

        /* === Hook === */
        foreach (cot_getextplugins('i18n.page.edit.tags') as $pl) {
            include $pl;
        }
        /* =============*/
    }
    // ------------------------------------------------------------------
    // УДАЛЕНИЕ (без изменений)
    // ------------------------------------------------------------------
    elseif ($a == 'delete' && ($i18n_admin || Cot::$usr['id'] == $pag_i18n['ipage_translatorid'])) {
        if (cot_plugin_active('trashcan') && Cot::$cfg['plugin']['trashcan']['trash_page']) {
            require_once cot_incfile('trashcan', 'plug');
            $row = Cot::$db->query('SELECT * FROM ' . Cot::$db->i18n_pages .
                ' WHERE ipage_id = ? AND ipage_locale = ?', [$id, $i18n_locale])->fetch();

            TrashcanService::getInstance()->put(
                'i18n_page',
                Cot::$L['i18n_translation'] . " #$id ($i18n_locale) " . $row['ipage_title'],
                (string) $id,
                $row
            );
        }

        Cot::$db->delete(Cot::$db->i18n_pages, "ipage_id = $id AND ipage_locale = '$i18n_locale'");

        $urlParams = [];

        /* === Hook === */
        foreach (cot_getextplugins('i18n.page.delete.done') as $pl) {
            include $pl;
        }
        /* =============*/

        cot_message(Cot::$L['Deleted']);
        cot_log("Deleted translate for page #" . $id, 'i18n', 'page', 'delete');

        if (empty($urlParams)) {
            $urlParams = ['c' => $pag['page_cat']];
            if (!empty($pag['page_alias'])) {
                $urlParams['al'] = $pag['page_alias'];
            } else {
                $urlParams['id'] = $id;
            }
        }
        cot_redirect(cot_url('page', $urlParams, '', true));
    } else {
        cot_die(true, true);
    }
} else {
    cot_die(true, true);
}