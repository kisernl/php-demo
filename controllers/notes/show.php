<?php

use Core\Database;

$config = require base_path("config.php");
$db = new Database($config['database']);

$currentUserID = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // form was submitted. delete note
    $note = $db->query("select * from notes where id = :id", [
        'id' => $_GET['id']
    ])->findOrFail();

    authorize($note['user_id'] === $currentUserID);

    $db->query("delete from notes where id = :id", [
        'id' => $_POST['id']
    ]);

    header("Location: /notes");
    exit();
} else {

    $note = $db->query("select * from notes where id = :id", [
        'id' => $_GET['id']
    ])->findOrFail();

    authorize($note['user_id'] === $currentUserID);

    view("notes/show.view.php", [
        'heading' => "Note",
        'note' => $note
    ]);
}


// 5:42:00