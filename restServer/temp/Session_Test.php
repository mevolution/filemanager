<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mattias
 * Date: 2013-02-10
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */

require_once ("../src/Session.php");

class AuthTest extends PHPUnit_Framework_TestCase
{
    protected $auth;

    protected function setUp()
    {
        $this->auth = new Sesssion();
    }

    public function testLogin2()
    {
        $t = $this->auth->login("Mattias");
        $this->assertEquals($t,md5("jomen"));

        $te = $this->auth->checkIfExists("Mattias");
        $this->assertTrue($te);

    }
    public function testifExist ()
    {
        $te = $this->auth->checkIfExists("fake");
        $this->assertFalse($te);
    }





}
?>