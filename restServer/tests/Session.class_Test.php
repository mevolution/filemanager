<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mattias
 * Date: 2013-02-10
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */


require_once ("../src/Session.class.php");


class SessionTest extends PHPUnit_Framework_TestCase
{
    protected $s;

    function __construct(){

    }


    protected function setUp()
    {
         $this->s = new Session("./users.json");

    }
    protected function tearDown()
    {

    }
    public function test_login(){
       $t = $this->s->login("mattias@mevolution.se","171c335c7a1f3105fb1a9637667c59a0");
       $this->assertTrue($t);
       $t = $this->s->login("mattias@mevolution.se","345234");
       $this->assertFalse($t);

    }
    public function test_if_logged_in (){
        $t = $this->s->login("mattias@mevolution.se","171c335c7a1f3105fb1a9637667c59a0");
        $this->assertEquals($_SESSION["loggedIn"],'Japp');
        $this->assertTrue($this->s->checkIfLoggedin("mattias@mevolution.se"));
        $t = $this->s->logout();
        $this->assertFalse($this->s->checkIfLoggedin("mattias.perssondddddd@mevolution.se"));
        $this->assertNotEquals($_SESSION["loggedIn"],'Japp');


    }



}