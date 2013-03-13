<?php



function reindex($gab) {
    global $pdo;
    $q = "
    SELECT id, forum_id, author_name, title, message, time_created, views, replies
    FROM forum
    WHERE id > ?
    AND (type = 'post'
         OR type = 'reply'
         )
    AND status >= 'normal'
    ";
    $statement = $pdo->prepare($q);
    $statement->execute(array(0));

    spl_autoload_register(function ($class) {
        include str_replace("_", "/", $class) . '.php';
    });
    require("Requests.php");

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    foreach($posts as $post) {
       $output .=
            // { "index" : { "_index" : "test", "_type" : "type1", "_id" : "1" } }
           json_encode(array(
             "index" => array( "_index" => "forum", "_type" => "post", "_id" => $post['id']))
           ) . /* Newline */'
' .
           // { "field1" : "value1" }
           json_encode($post) . /* Newline */ '
';
    }

    $url = $gab->search_url;
    $resp = Requests::PUT("$url/forum/post/_bulk", array(), $output, array('auth'=>$gab->search_auth));
    //print_r($resp);
}

$this->addPage('search_ext', 'reindex');