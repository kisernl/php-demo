<?php


require "functions.php";
// require "router.php";
require "Database.php";

$config = require("config.php");

$db = new Database($config['database']);

$posts = $db->query("SELECT * FROM posts")->fetchAll();

dd($posts);

// connect to our MySQL database at localhost using PHP PDO

foreach ($posts as $post) {
    echo "<li>" . $post['title'] . "</li>";
}
