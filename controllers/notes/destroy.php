<?php

use Core\Database;

$config = require base_path("config.php");
$db = new Database($config['database']);

$currentUserID = 1;

// form was submitted. delete note
$note = $db->query("select * from notes where id = :id", [
    //'id' => $_GET['id']
    'id' => $_POST['id']
])->findOrFail();

authorize($note['user_id'] === $currentUserID);

$db->query("delete from notes where id = :id", [
    'id' => $_POST['id']
]);

header("location: /notes");
exit();
