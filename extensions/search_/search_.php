<?php

function search_refresh($gab, $changed_post_id) {
    if (!$gab->getOption('url')) return;
    global $pdo;
    global $forum_id;
    $q = "
        SELECT id, forum_id, author_name, title, message, time_created, views, replies, visibility, type, reply_to
        FROM forum
        WHERE id = ?
        AND (
             type = 'post'
          OR type = 'reply'
        )
        LIMIT 1
    ";
    $statement = $pdo->prepare($q);
    $statement->execute(array($changed_post_id));
    $post = $statement->fetch(PDO::FETCH_ASSOC);

    spl_autoload_register(function ($class) {
        include str_replace("_", "/", $class) . '.php';
    });
    require("Requests.php");

    if ($post['visibility'] == 'hidden' || $post['visibility'] == 'mod_hidden')
        $method = Requests::DELETE;
    else
        $method = Requests::PUT;

    try {
        // If there seems to be problems,
        //   a good place to check is capturing the results
        //   of this function, and print_r()ing it.
        Requests::request(
            "{$gab->getOption('url')}/forum/{$forum_id}/{$post['id']}",
            array(),
            json_encode($post),
            $method,
            array('auth'=>$gab->getOption('auth')));
    } catch (Exception $e) { }
}

function display_search_page($gab) {
    $gab->displayGeneric('search_page.tpl');
}

$this->bindTrigger('new_post', 'search_refresh');
$this->bindTrigger('new_reply', 'search_refresh');
$this->bindTrigger('moderate', 'search_refresh');
$this->addTemplate('*', 'search_link.tpl');
$this->addJavascript('search_.js');
$this->addPage('search', 'display_search_page');
$this->assign("search_url", $this->getOption('url'));