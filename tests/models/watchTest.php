<?php

require_once('tests/test.php');
require_once('models/user.php');
require_once('models/watch.php');
require_once('models/post.php');

class model_watch_test extends PHPUnit_Framework_TestCase {

    function setUp() {
        $this->user = user::new_user("1", "user", "###");
        $this->post = post::new_thread("1", "user", "###", "hey", "msg");
    }

    function testRead()   {
        $id = watch::new_watching($this->post, $this->user, "user", "###");
        $this->assertGreaterThan(0, $id);
    }

}