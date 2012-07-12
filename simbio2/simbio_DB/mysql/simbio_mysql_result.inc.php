<?php
/**
 * simbio_mysql_result class
 * This class emulates mysqli mysqli_result object behaviour
 *
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
class simbio2
{
    public $error = '';
    private $version = '2.0';

    /**
     * Method to show an error
     *
     * @param   boolean $bool_die
     * @return  void
     */
    public function showError($bool_die = false)
    {
        echo '<div style="padding: 5px; border: 1px dotted #FF0000; color: #FF0000;">';
        echo 'ERROR : '.nl2br($this->error).'</div>'."\n";
        if ($bool_die) {
            die();
        }
    }


    /**
     * Static method to colorized SQL string
     *
     * @param   string  $sql_string
     * @return  string
     */
    public static function colorSQLstring($sql_string = '')
    {
        // list of mysql reserved words
        $reservedwords = array(
            "\bDATABASE\b",
            "\bTABLE\b",
            "\bAND\b",
            "\bOR\b",
            "\bSELECT\b",
            "\bINSERT\b",
            "\bUPDATE\b",
            "\bDELETE\b",
            "\bALTER\b",
            "\bFROM\b",
            "\bWHERE\b",
            "\bLIKE\b",
            "\bORDER BY\b",
            "\bLIMIT\b",
            "\bUSE\b",
            "\bDESCRIBE\b",
            "\bJOIN\b",
            "\bLEFT\b",
            "\bRIGHT\b",
            "\bINNER\b",
            "\b=\b",
            "\b!=\b",
            "\bON\b",
            "\bIN\b",
            "\bAS\b",
            "\bNULL\b",
            "\bNOT\b",
            "\bIS\b",
            "\bINTO\b");

        // colorized the sql string
        $matches_str = array();
        preg_match_all("/'[^']*'/i", $sql_string, $matches_str, PREG_SET_ORDER);
        if ($matches_str) {
            foreach ($matches_str as $sql_str) {
                $sql_string = preg_replace("/".$sql_str[0]."/i", '<strong style="color: green;">'.$sql_str[0].'</strong>', $sql_string);
            }
        }

        // colorized brackets
        $sql_string = str_replace(array('(',')'), array('<strong style="color: red;">(</b>', '<b style="color: red;">)</strong>'), $sql_string);

        // colorized the SQL reserved words
        foreach ($reservedwords as $words) {
            $sql_string = preg_replace("/$words/i", '<strong style="color: navy;">'.$words.'</strong>', $sql_string);
        }

        // remove regex special chars
        $sql_string = str_replace(array('\b'), '', $sql_string);
        return $sql_string;
    }
}

class simbio_mysql_result extends simbio2
{
    /**
     * Private properties
     */
    private $res_result = false;
    private $sql_string = '';

    /**
     * Public properties
     */
    public $num_rows = 0;
    public $field_count = 0;
    public $affected_rows = 0;
    public $insert_id = 0;
    public $errno = false;


    /**
     * Class Constructor
     *
     * @param   string      $str_query
     * @param   resource    $res_conn
     */
    public function __construct($str_query, $res_conn)
    {
        $this->sql_string = trim($str_query);
        $this->sendQuery($res_conn);
    }


    /**
     * Method to send SQL query
     *
     * @param   resource    $res_conn
     * @return  void
     */
    private function sendQuery($res_conn)
    {
        // checking query type
        // if the query return recordset or not
        if (preg_match("/^SELECT|DESCRIBE|SHOW|EXPLAIN\s/i", $this->sql_string)) {
            $this->res_result = @mysql_query($this->sql_string, $res_conn);
            // error checking
            if (!$this->res_result) {
                $this->error = 'Query ('.$this->sql_string.") failed to executed. Please check your query again \n".mysql_error($res_conn);
                $this->errno = mysql_errno($res_conn);
            } else {
                // count number of rows
                $this->num_rows = @mysql_num_rows($this->res_result);
                $this->field_count = @mysql_num_fields($this->res_result);
            }
        } else {
            $query = @mysql_query($this->sql_string, $res_conn);
            $this->insert_id = @mysql_insert_id($res_conn);
            // error checking
            if (!$query) {
                $this->error = 'Query ('.$this->sql_string.") failed to executed. Please check your query again \n".mysql_error($res_conn);
                $this->errno = mysql_errno($res_conn);
            } else {
                // get number of affected row
                $this->affected_rows = @mysql_affected_rows($res_conn);
            }
            // nullify query
            $query = null;
        }
    }


    /**
     * Method to fetch record in associative  array
     *
     * @return  array
     */
    public function fetch_assoc()
    {
        return @mysql_fetch_assoc($this->res_result);
    }


    /**
     * Method to fetch record in numeric array indexes
     *
     * @return  array
     */
    public function fetch_row()
    {
        return @mysql_fetch_row($this->res_result);
    }


    /**
     * Method to fetch fields information of resultset
     *
     * @return  array
     */
    public function fetch_fields()
    {
        $_fields_info = array();
        $_f = 0;
        $_field_num = mysql_num_fields($this->res_result);
        while ($_f < $_field_num) {
            $_fields_info[] = mysql_fetch_field($this->res_result, $_f);
            $_f++;
        }

        return $_fields_info;
    }


    /**
     * Method to free resultset memory
     *
     * @return  void
     */
    public function free_result()
    {
        if ($this->res_result) {
            @mysql_free_result($this->res_result);
        }
    }
}
?>
