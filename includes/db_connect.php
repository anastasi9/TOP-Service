
<?php
$servername = 'localhost';
$username = 'root';
$password = "mysql";
$dbname = 'topservice_db';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die('Connection Faled'. mysqli_error());
} else {
    'Успех';
}?>