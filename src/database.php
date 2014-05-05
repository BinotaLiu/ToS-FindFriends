<?php
/**
 * Filename: src/database.php
 * $Id$
 * 資料庫模組，放置所有與資料庫相關相關的功能。
 */

Class Database
{
    public static function connect($host, $username, $password){
        $link = @mysql_connect($host, $username, $password);
        @mysql_set_charset("utf8", $link);
        return $link ? $link : false;
    }

    public static function close($handle)
    {
        mysql_close($handle);
        return true;
    }

    public static function select($database)
    {
        return @mysql_select_db($database) or false;
    }

    public static function insert($table, $values)
    {
        //初始化
        $myValues = "";
        $myCols   = "";
        //分解 $where 為 WHERE 查詢用字串
        foreach ($values as $key => $value) {
            $myCols   .= "`{$key}`," ;
            $myValues .= "\"" . self::fix_string($value) . "\",";
        }
        //移除最後的逗號 ,
        $myCols = substr($myCols, 0, -1);
        $myValues = substr($myValues, 0, -1);

        $queryString = "INSERT INTO $table ($myCols) VALUES ($myValues)";

        //var_dump($queryString);

        $result = mysql_query($queryString);

        return $result ? mysql_insert_id() : false;
    }

    public static function query($query)
    {
        $result = @mysql_query($query);
        if($result){
            $rows = @mysql_num_rows($result);
            $array = array();
            for($i = 0; $i < $rows; $i++){
                $array[$i] = mysql_fetch_array($result);
            }
            return $array;
        } else {
            return false;
        }   
    }

    public static function fetch($table, $select = "*", $start = 0, $num = 0)
    {
        $queryString = "SELECT {$select} FROM {$table}";
        if($start && $num)
            $queryString .= " LIMIT {$start}, {$num}";
        $result = @mysql_query($queryString);
        if($result){
            if($num <= 0 or $num > @mysql_num_rows($result)){
                $rows = @mysql_num_rows($result);
            } else {
                $rows = $num;
            }
            $array = array();
            for($i = 0; $i < $rows; $i++){
                $array[$i] = mysql_fetch_array($result);
            }
            return $array;
        } else {
            return false;
        }       
    }

    public static function fetch_where($table, $selects = "*", $where, $start = 0, $num = 0)
    {
        //初始化
        $myWhere = "";
        //分解 $where 為 WHERE 查詢用字串
        foreach ($where as $key => $value) {
            $myWhere .= "{$key}=\"{$value}\",";
        }
        //移除最後的逗號 ,
        $myWhere = substr($myWhere, 0, -1);

        $mySelects = "";
        foreach ($selects as $value) {
            $mySelects .= "{$value},";
        }
        $mySelects = substr($mySelects, 0, -1);

        $queryString = "SELECT {$mySelects} FROM {$table} WHERE {$myWhere}";
        if($start && $num)
            $queryString .= " LIMIT {$start}, {$num}";
        $result = @mysql_query($queryString);

        //var_dump($queryString);

        if($result){
            if($num <= 0 or $num > @mysql_num_rows($result)){
                $rows = @mysql_num_rows($result);
            } else {
                $rows = $num;
            }
            $array = array();
            for($i = 0; $i < $rows; $i++){
                $array[$i] = mysql_fetch_array($result);
            }
            return $array;
        } else {
            return false;
        }
        
    }

    public static function update($table, $sets, $where = null)
    {
        if($where){
            $myWhere = "";
            foreach ($where as $key => $value) {
                $myWhere .= self::fix_string($key) ."=\"" . self::fix_string($value) . "\",";
            }
            $myWhere = substr($myWhere, 0, -1);
        }

        $mySets = "";
        foreach ($sets as $key => $value) {
            $mySets .= self::fix_string($key) ."=\"" . self::fix_string($value) . "\",";
        }
        $mySets = substr($mySets, 0, -1);

        $queryString = "UPDATE {$table} SET {$mySets}" . ($where ? " WHERE {$myWhere}" : "");

        //var_dump($queryString);

        return @mysql_query($queryString);
    }

    public static function delete($table, $field, $value)
    {
        return @mysql_query("DELETE FROM " . $table . " WHERE " . $field . "=" . $value) or false;
    }

    public static function fix_string($string)
    {
        return htmlentities(mysql_real_escape_string(stripslashes($string)));
    }
}
