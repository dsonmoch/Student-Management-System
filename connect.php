<?php
$servername="";
$username="";
$password="";
$dbname="student_record";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed" . $conn->connect_error);
}
?>
