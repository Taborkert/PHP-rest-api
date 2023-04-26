<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

spl_autoload_register(function ($class_name) {
    include 'classes/' . str_replace('\\', '/', $class_name) . '.php';
});

$db = new DataBase();

$mail = new Mail();
$mail->addAddress('brandnewerik@gmail.com', 'Erik Kránicz');
$mail->Subject = "Újabb próbaemail";
$mail->Body = "Ez a levél szövege!";
$mail->send();

exit;

$db->select('Select * from user where id = :id', ['id' => 2]);
$db->echo_json();
