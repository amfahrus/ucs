<?php
/**
 *
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

/* Module Management section */

// main system configuration
require '../../../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';
require UCS_BASE_DIR.'admin/default/session_check.inc.php';

// only administrator have privileges to modify modules data
if ($_SESSION['uid'] != 1) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
}

require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

/* RECORD OPERATION */
if (isset($_POST['saveData'])) {
    // check form validity
    $moduleName = trim(strip_tags($_POST['moduleName']));
    $modulePath = trim(strip_tags($_POST['modulePath']));
    if (empty($moduleName) OR empty($modulePath)) {
        utility::jsAlert(__('Module name and path can\'t be empty'));
        exit();
    } else {
        $data['module_path'] = $dbs->escape_string($modulePath);
        // check for module path existance
        if (!file_exists(MODULES_BASE_DIR.$data['module_path'].DIRECTORY_SEPARATOR)) {
            utility::jsAlert('Modules path doesn\'t exists! Please check again in module base directory');
            exit();
        }
        $data['module_name'] = $dbs->escape_string($moduleName);
        $data['module_desc'] = trim($dbs->escape_string(strip_tags($_POST['moduleDesc'])));

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // filter update record ID
            $updateRecordID = (integer)$_POST['updateRecordID'];
            // update the data
            $update = $sql_op->update('mst_module', $data, 'module_id='.$updateRecordID);
            if ($update) {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' update module data ('.$moduleName.') with path ('.$modulePath.')');
                utility::jsAlert(__('Module Data Successfully Updated'));
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', parent.getPreviousAJAXurl(), \'post\');</script>';
            } else { utility::jsAlert(__('Module Data FAILED to Updated. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            if ($sql_op->insert('mst_module', $data)) {
                // insert module privileges for administrator
                $module_id = $sql_op->insert_id;
                $dbs->query('INSERT INTO group_access VALUES (1, '.$module_id.', 1, 1)');
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' add new module ('.$moduleName.') with path ('.$modulePath.')');
                utility::jsAlert(__('New Module Data Successfully Saved'));
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'post\');</script>';
            } else { utility::jsAlert(__('Module Data FAILED to Save. Please Contact System Administrator')."\n".$sql_op->error); }
            exit();
        }
    }
    exit();
} else if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!($can_read AND $can_write)) {
        die();
    }
    /* DATA DELETION PROCESS */
    $sql_op = new simbio_dbop($dbs);
    $failed_array = array();
    $error_num = 0;
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array((integer)$_POST['itemID']);
    }
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        $itemID = (integer)$itemID;
        // get module data
        $module_q = $dbs->query('SELECT module_name, module_path FROM mst_module WHERE module_id='.$itemID);
        $module_d = $module_q->fetch_row();
        if (!$sql_op->delete('mst_module', "module_id=$itemID")) {
            $error_num++;
        } else {
            // also delete all records related to this data
            // delete group privileges
            $dbs->query('DELETE FROM group_access WHERE module_id='.$itemID);
            // write log
            utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' DELETE module ('.$module_d[0].') with path ('.$module_d[1].')');
        }
    }

    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(__('All Data Successfully Deleted'));
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    } else {
        utility::jsAlert(__('Some or All Data NOT deleted successfully!\nPlease contact system administrator'));
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    }
    exit();
}
/* RECORD OPERATION */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner moduleIcon">
    <?php echo strtoupper(__('Modules')); ?> - <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>system/module.php?action=detail" class="headerText2"><?php echo __('Add New Modules'); ?></a>
    &nbsp; <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>system/module.php" class="headerText2"><?php echo __('Modules List'); ?></a>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>system/module.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" size="30" />
    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* search form end */
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    /* RECORD FORM */
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    $rec_q = $dbs->query('SELECT * FROM mst_module WHERE module_id='.$itemID);
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.__('Save').'" class="button"';

    // form table attributes
    $form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        $form->record_id = $itemID;
        // form record title
        $form->record_title = $rec_d['module_name'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.__('Update').'" class="button"';
    }

    /* Form Element(s) */
    // module
    $form->addTextField('text', 'moduleName', __('Module Name').'*', $rec_d['module_name'], 'style="width: 50%;"');
    // module path
    $form->addTextField('text', 'modulePath', __('Module Path').'*', $rec_d['module_path'], 'style="width: 100%;"');
    // module desc
    $form->addTextField('text', 'moduleDesc', __('Module Description'), $rec_d['module_desc'], 'style="width: 100%;"');

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'.__('You are going to edit data').' : <b>'.$rec_d['module_name'].'</b></div>'; //mfc
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* MODULE LIST */
    // table spec
    $table_spec = 'mst_module AS mdl';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('mdl.module_id',
        'mdl.module_name AS \''.__('Module Name').'\'',
        'mdl.module_desc AS \''.__('Module Description').'\'');
    $datagrid->setSQLorder('module_name ASC');

    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
       $keywords = $dbs->escape_string($_GET['keywords']);
       $datagrid->setSQLCriteria("mdl.module_name LIKE '%$keywords%'");
    }

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, true);
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}
/* main content end */
?>
