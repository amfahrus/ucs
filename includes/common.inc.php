<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/* Common Variables */

/* Location list */
ob_start();
echo '<option value="0">'.__('All Locations').'</option>';
foreach ($sysconf['node'] as $node) {
    echo '<option value="'.$node['id'].'">'.$node['name'].'</option>';
}
$location_list = ob_get_clean();

/* GMD List */
ob_start();
echo '<option value="0">'.__('All GMD/Media').'</option>';
$gmd_q = $dbs->query('SELECT gmd_name FROM mst_gmd LIMIT 50');
while ($gmd_d = $gmd_q->fetch_row()) {
    echo '<option value="'.$gmd_d[0].'">'.$gmd_d[0].'</option>';
}
$gmd_list = ob_get_clean();

/* Language selection list */
ob_start();
require_once(INC_DIR.'localisation.php');
foreach ($available_languages AS $lang_index) {
    $selected = null;
    $lang_code = $lang_index[0];
    $lang_name = $lang_index[1];
    if ($lang_code == $sysconf['default_lang']) {
        $selected = 'selected';
    }
    echo '<option value="'.$lang_code.'" '.$selected.'>'.$lang_name.'</option>';
}
$language_select = ob_get_clean();

/* include simbio form element library */
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_element.inc.php';
/* Advanced Search Author AJAX field */
ob_start();
// create AJAX drop down
$ajaxDD = new simbio_fe_AJAX_select();
$ajaxDD->element_name = 'author';
$ajaxDD->element_css_class = 'ajaxInputField';
$ajaxDD->additional_params = 'type=author';
$ajaxDD->handler_URL = UCS_WEB_ROOT_DIR.'includes/contents/advsearch_AJAX_response.php';
echo $ajaxDD->out();
$advsearch_author = ob_get_clean();


/* Advanced Search Topic/Subject AJAX field */
ob_start();
// create AJAX drop down
$ajaxDD = new simbio_fe_AJAX_select();
$ajaxDD->element_name = 'subject';
$ajaxDD->element_css_class = 'ajaxInputField';
$ajaxDD->additional_params = 'type=topic';
$ajaxDD->handler_URL = UCS_WEB_ROOT_DIR.'includes/contents/advsearch_AJAX_response.php';
echo $ajaxDD->out();
$advsearch_topic = ob_get_clean();
?>
