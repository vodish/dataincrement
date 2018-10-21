<?php
header('Content-Type: text/html; charset=utf-8');

# Key
$pass       =   'KEY_PASS_FROM_DATAINCREMENT';      //change for youself

# Connect parametres to mysql database
$host       =   'LOCALHOST';        //change for youself
$user       =   'USERNAME';         //change for youself
$password   =   'PASSWORD';         //change for youself
$database   =   'DATABASE_NAME';    //change for youself



# Access
if ( !isset($_POST['query']) )         die( 'no query' );
if ( @$_POST['pass'] != md5($pass) )   die( 'no pass' );
// if ( $_SERVER['REMOTE_ADDR'] != '185.229.9.9' ) die( 'no ip' );



# Connect
$mysqli     =   new mysqli($host, $user, $password, $database);

if ( $mysqli->connect_error )
{
    die( 'no connect: ' .$mysqli->connect_error );
}

# Character
$mysqli->set_charset( $mysqli->query("SHOW VARIABLES LIKE 'character_set_database'")->fetch_object()->Value );


# Query & Return
if ( $result = $mysqli->query($_POST['query'], MYSQLI_USE_RESULT) )
{
    for ( $rows = array();  $r = $result->fetch_array(MYSQLI_ASSOC);  $rows[] = $r );
    
    $data   =   json_encode($rows);
    $data   =   gzdeflate($data, 9);
    
    die( $data );
}

die( $mysqli->error );
