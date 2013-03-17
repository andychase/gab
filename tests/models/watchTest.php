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
        $id = watch::new_watch($this->post, $this->user, "user", "###");
        $this->assertGreaterThan(0, $id);
        $unread = watch::get_unread($this->user);
        $this->assertEquals(0, count($unread));
        post::post_reply($this->post, $this->user, "user", "####", "reply");
        $unread = watch::get_unread($this->user);
        $this->assertEquals(1, count($unread));
        $this->assertEquals($this->post, $unread[0]['id']);
        watch::read($this->user, $this->post);
        $unread = watch::get_unread($this->user);
        $this->assertEquals(0, count($unread));
    }

}