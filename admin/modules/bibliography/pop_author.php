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


/* Biblio Author Adding Pop Windows */

// main system configuration
require '../../../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';
require UCS_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// page title
$page_title = 'Authority List';
// check for biblioID in url
$biblioID = 0;
if (isset($_GET['biblioID']) AND $_GET['biblioID']) {
    $biblioID = (integer)$_GET['biblioID'];
}

// utility function to check author name
function checkAuthor($str_author_name)
{
    global $dbs;
    $_q = $dbs->query('SELECT author_id FROM mst_author WHERE author_name=\''.$str_author_name.'\'');
    if ($_q->num_rows > 0) {
        $_d = $_q->fetch_row();
        // return the author ID
        return $_d[0];
    }
    return false;
}

// start the output buffer
ob_start();
/* main content */
// biblio author save proccess
if (isset($_POST['save']) AND (isset($_POST['authorID']) OR trim($_POST['search_str']))) {
    $author_name = trim($dbs->escape_string(strip_tags($_POST['search_str'])));
    // create new sql op object
    $sql_op = new simbio_dbop($dbs);
    // check if biblioID POST var exists
    if (isset($_POST['biblioID']) AND !empty($_POST['biblioID'])) {
        $data['biblio_id'] = intval($_POST['biblioID']);
        // check if the author select list is empty or not
        if (isset($_POST['authorID']) AND !empty($_POST['authorID'])) {
            $data['author_id'] = $_POST['authorID'];
        } else if ($author_name AND empty($_POST['authorID'])) {
            // check author
            $author_id = checkAuthor($author_name);
            if ($author_id !== false) {
                $data['author_id'] = $author_id;
            } else {
                // adding new author
                $author_data['author_name'] = $author_name;
                $author_data['authority_type'] = $_POST['type'];
                $author_data['input_date'] = date('Y-m-d');
                $author_data['last_update'] = date('Y-m-d');
                // insert new author to author master table
                @$sql_op->insert('mst_author', $author_data);
                $data['author_id'] = $sql_op->insert_id;
            }
        }
        $data['level'] = intval($_POST['level']);

        if ($sql_op->insert('biblio_author', $data)) {
            echo '<script type="text/javascript">';
            echo 'alert(\''.__('Author succesfully updated!').'\');';
            echo 'opener.setIframeContent(\'authorIframe\', \''.MODULES_WEB_ROOT_DIR.'bibliography/iframe_author.php?biblioID='.$data['biblio_id'].'\');';
            echo '</script>';
        } else {
            utility::jsAlert(__('Author FAILED to Add. Please Contact System Administrator')."\n".$sql_op->error);
        }
    } else {
        if (isset($_POST['authorID']) AND !empty($_POST['authorID'])) {
            // add to current session
            $_SESSION['biblioAuthor'][$_POST['authorID']] = array($_POST['authorID'], intval($_POST['level']));
        } else if ($author_name AND empty($_POST['authorID'])) {
            // check author
            $author_id = checkAuthor($author_name);
            if ($author_id !== false) {
                $last_id = $author_id;
            } else {
                // adding new author
                $data['author_name'] = $author_name;
                $data['authority_type'] = $_POST['type'];
                $data['input_date'] = date('Y-m-d');
                $data['last_update'] = date('Y-m-d');
                // insert new author to author master table
                $sql_op->insert('mst_author', $data);
                $last_id = $sql_op->insert_id;
            }
            $_SESSION['biblioAuthor'][$last_id] = array($last_id, intval($_POST['level']));
        }

        echo '<script type="text/javascript">';
        echo 'alert(\''.__('Author added!').'\');';
        echo 'opener.setIframeContent(\'authorIframe\', \''.MODULES_WEB_ROOT_DIR.'bibliography/iframe_author.php\');';
        echo '</script>';
    }
}

?>

<div style="padding: 5px; background: #CCCCCC;">
<form name="mainForm" action="pop_author.php?biblioID=<?php echo $biblioID; ?>" method="post">
<div>
    <strong><?php echo __('Add Author'); ?> </strong>
    <hr />
    <form name="searchAuthor" method="post" style="display: inline;">
    <?php
    $ajax_exp = "ajaxFillSelect('../../AJAX_lookup_handler.php', 'mst_author', 'author_id:author_name', 'authorID', $('search_str').getValue())";
    echo __('Author Name'); ?> : <input type="text" name="search_str" id="search_str" style="width: 30%;" onkeyup="<?php echo $ajax_exp; ?>" onchange="<?php echo $ajax_exp; ?>" />
    <select name="type" style="width: 20%;"><?php
    foreach ($sysconf['authority_type'] as $type_id => $type) {
        echo '<option value="'.$type_id.'">'.$type.'</option>';
    }
    ?></select>
    <select name="level" style="width: 20%;"><?php
    foreach ($sysconf['authority_level'] as $level_id => $level) {
        echo '<option value="'.$level_id.'">'.$level.'</option>';
    }
    ?></select>
</div>
<div style="margin-top: 5px;">
<select name="authorID" id="authorID" size="5" style="width: 100%;"><option value="0"><?php echo __('Type to search for existing authors or to add a new one'); ?></option></select>
<?php if ($biblioID) { echo '<input type="hidden" name="biblioID" value="'.$biblioID.'" />'; } ?>
<input type="submit" name="save" value="<?php echo __('Insert To Bibliography'); ?>" style="margin-top: 5px;" />
</div>
</form>
</div>

<?php
/* main content end */
$content = ob_get_clean();
// include the page template
require UCS_BASE_DIR.'/admin/admin_themes/notemplate_page_tpl.php';
?>
