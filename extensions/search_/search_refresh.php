<?php
if ($this->changed_post_id) {
    global $pdo;
    $q = "
        SELECT id, forum_id, author_name, title, message, time_created, views, replies, status
        FROM forum
        WHERE id = ?
        AND (
             type = 'post'
          OR type = 'reply'
        )
        LIMIT 1
        ";
    $statement = $pdo->prepare($q);
    $statement->execute(array($this->changed_post_id));
    $post = $statement->fetch(PDO::FETCH_ASSOC);

    spl_autoload_register(function ($class) {
        include str_replace("_", "/", $class) . '.php';
    });
    require("Requests.php");

    if ($post['status'] == 'hidden' || $post['status'] == 'mod_hidden')
        $method = Requests::DELETE;
    else
        $method = Requests::PUT;

    try {
        // If there seems to be problems,
        //   a good place to check is capturing the results
        //   of this function, and print_r()ing it.
        Requests::request(
            "{$this->search_url}/forum/post/{$post['id']}",
            array(),
            json_encode($post),
            $method,
            array('auth'=>$this->search_auth));
    } catch (Exception $e) {

    }
}
