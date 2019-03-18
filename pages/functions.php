<?php
/**
 * Created by PhpStorm.
 * User: Teacher
 * Date: 07.03.2019
 * Time: 18:35
 */
//Get Variables
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
function connect(
    $host = 'localhost',
    $user = 'root',
    $pass = '',
    $dbname = 'traveldb')
{
    $link = mysql_connect($host, $user, $pass) or die('connection error');
    mysql_select_db($dbname) or die('db open error');
}

function log_mysql($err)
{
    if ($err && $err != 1062) {
        echo "<h2 style='color:red;'>Error code: $err</h2><br>";
        return false;
    } elseif($err == 1062) {
        Logging('This Login is Already');
    } else {
    Logging('', false);
}
}




function page_reload()
{
    echo "<script>";
    echo "window.location = document.URL;";
    echo "</script>";
}