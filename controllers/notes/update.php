<?php

// find the note
use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserID = 1;

$note = $db->query("select * from notes where id = :id", [
    'id' => $_POST['id']
])->findOrFail();

// authorize the user
authorize($note['user_id'] === $currentUserID);


// validate the form
$errors = [];

if (! Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1000 characters is required';
}

// if validation error, provide feedback
if (! empty($errors)) {
    return view('notes/edit.view.php', [
        'heading' => 'Edit Note',
        'errors' => $errors,
        'note' => $note
    ]);
}

// update the note

$db->query('update notes set body = :body where id = :id', [
    'id' => $_POST['id'],
    'body' => $_POST['body']
]);

// redirect the user
header('location: /notes');
die();
