<?php

require_once('tests/test.php');
require_once('models/user.php');

class model_user_test extends PHPUnit_Framework_TestCase {

    function testRead()   {
        $user_id = user::new_user("1", "user", "###");
        $this->assertNotNull($user_id);
        $user = user::get_user($user_id);
        $this->assertEquals(array(), $user['badges']);

        user::add_badge($user_id, 'test');
        $user = user::get_user($user_id);
        $this->assertEquals(array('test'), $user['badges']);

        user::remove_badge($user_id, 'test');
        $user = user::get_user($user_id);
        $this->assertEquals(array(), $user['badges']);
    }

}