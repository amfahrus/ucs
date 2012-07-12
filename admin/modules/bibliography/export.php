<?php
/**
 * Copyright (C) 2010  Arie Nugraha (dicarve@yahoo.com)
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


/* Biblio data export section */

// main system configuration
require '../../../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You are not authorized to view this section').'</div>');
}

if (isset($_POST['doExport'])) {
    // check for form validity
    if (empty($_POST['fieldSep']) OR empty($_POST['fieldEnc'])) {
        utility::jsAlert(__('Required fields (*)  must be filled correctly!'));
        exit();
    } else {
        // set PHP time limit
        set_time_limit(0);

        // create local function to fetch values
        function getValues($obj_db, $str_query)
        {
            // make query from database
            $_value_q = $obj_db->query($str_query);
            if ($_value_q->num_rows > 0) {
                $_value_buffer = '';
                while ($_value_d = $_value_q->fetch_row()) {
                    if ($_value_d[0]) {
                        $_value_buffer .= '<'.$_value_d[0].'>';
                    }
                }
                return $_value_buffer;
            }
            return null;
        }

        // limit
        $sep = trim($_POST['fieldSep']);
        $encloser = trim($_POST['fieldEnc']);
        $limit = intval($_POST['recordNum']);
        $offset = intval($_POST['recordOffset']);
        if ($_POST['recordSep'] === 'NEWLINE') {
            $rec_sep = "\n";
        } else if ($_POST['recordSep'] === 'RETURN') {
            $rec_sep = "\r";
        } else {
            $rec_sep = trim($_POST['recordSep']);
        }
        // fetch all data from biblio table
        $sql = "SELECT
            b.biblio_id, b.title, gmd.gmd_name, b.edition,
            b.isbn_issn, publ.publisher_name, b.publish_year,
            b.collation, b.series_title, b.call_number,
            lang.language_name, pl.place_name, b.classification,
            b.notes, b.image, b.file_att
            FROM biblio AS b
            LEFT JOIN mst_gmd AS gmd ON b.gmd_id=gmd.gmd_id
            LEFT JOIN mst_publisher AS publ ON b.publisher_id=publ.publisher_id
            LEFT JOIN mst_language AS lang ON b.language_id=lang.language_id
            LEFT JOIN mst_place AS pl ON b.publish_place_id=pl.place_id ";
        if ($limit > 0) { $sql .= ' LIMIT '.$limit; }
        if ($offset > 1) {
            if ($limit > 0) {
                $sql .= ' OFFSET '.($offset-1);
            } else {
                $sql .= ' LIMIT '.($offset-1).',99999999999';
            }
        }
        // for debugging purpose only
        // die($sql);
        $all_data_q = $dbs->query($sql);
        if ($dbs->error) {
            utility::jsAlert(__('Error on query to database, Export FAILED!'));
        } else {
            if ($all_data_q->num_rows > 0) {
                header('Content-type: text/plain');
                header('Content-Disposition: attachment; filename="senayan_biblio_export.csv"');
                while ($biblio_d = $all_data_q->fetch_row()) {
                    $buffer = null;
                    foreach ($biblio_d as $idx => $fld_d) {
                        // skip biblio_id field
                        if ($idx > 0) {
                            $fld_d = $dbs->escape_string($fld_d);
                            // data
                            $buffer .=  stripslashes($encloser.$fld_d.$encloser);
                            // field separator
                            $buffer .= $sep;
                        }
                    }
                    // authors
                    $authors = getValues($dbs, 'SELECT a.author_name FROM biblio_author AS ba
                        LEFT JOIN mst_author AS a ON ba.author_id=a.author_id
                        WHERE ba.biblio_id='.$biblio_d[0]);
                    $buffer .= $encloser.$authors.$encloser;
                    $buffer .= $sep;
                    // topics
                    $topics = getValues($dbs, 'SELECT t.topic FROM biblio_topic AS bt
                        LEFT JOIN mst_topic AS t ON bt.topic_id=t.topic_id
                        WHERE bt.biblio_id='.$biblio_d[0]);
                    $buffer .= $encloser.$topics.$encloser;
                    $buffer .= $sep;
                    // item code
                    $items = getValues($dbs, 'SELECT item_code FROM item AS i
                        WHERE i.biblio_id='.$biblio_d[0]);
                    $buffer .= $encloser.$items.$encloser;
                    echo $buffer;
                    echo $rec_sep;
                }
                exit();
            } else {
                utility::jsAlert(__('There is no record in bibliographic database yet, Export FAILED!'));
            }
        }
    }
    exit();
}
?>
<fieldset class="menuBox">
<div class="menuBoxInner exportIcon">
    <?php echo __('EXPORT TOOL'); ?>
    <hr />
    <?php echo __('Export bibliographics data to CSV file'); ?>
</div>
</fieldset>
<?php

// create new instance
$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'], 'post');
$form->submit_button_attr = 'name="doExport" value="'.__('Export Now').'" class="button"';

// form table attributes
$form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

/* Form Element(s) */
// field separator
$form->addTextField('text', 'fieldSep', __('Field Separator').'*', ''.htmlentities(',').'', 'style="width: 10%;" maxlength="3"');
//  field enclosed
$form->addTextField('text', 'fieldEnc', __('Field Enclosed With').'*', ''.htmlentities('"').'', 'style="width: 10%;"');
// record separator
$rec_sep_options[] = array('NEWLINE', 'NEWLINE');
$rec_sep_options[] = array('RETURN', 'CARRIAGE RETURN');
$form->addSelectList('recordSep', __('Record Separator'), $rec_sep_options);
// number of records to export
$form->addTextField('text', 'recordNum', __('Number of Records To Export (0 for all records)'), '0', 'style="width: 10%;"');
// records offset
$form->addTextField('text', 'recordOffset', __('Start From Record'), '1', 'style="width: 10%;"');
// output the form
echo $form->printOut();
?>
