<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mattias
 * Date: 2013-02-10
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */

require_once ("../src/Users.class.php");



class UsersTest extends PHPUnit_Framework_TestCase
{
    protected $u;
    protected $UserFile = "./userTest.json";

    function __construct(){

    }


    protected function setUp()
    {
        $this->u = new Users();
        $this->u->setStoreFile($this->UserFile);

    }
    protected function tearDown()
    {
        //raderar test file store
        if (file_exists($this->UserFile)) {
            unlink($this->UserFile);
        }

    }


    public function test_change_file_for_store_users () {
        $this->u->setStoreFile("./test.json");
        $t = $this->u->getStoreFile();
        $this->assertEquals("./test.json",$t);

    }
    public function test_Add()
    {
        $t = $this->u->addUser("1234","Mattias","Pesson","mattias@mevolution.se","171c335c7a1f3105fb1a9637667c59a0");
        $t = $this->u->addUser("12","Mia","Pesson","mia@mevolution.se","jojojjemen");
        $users = $this->u->getUserArray();
        $this->assertEquals("Mattias",$users[0]->firstName);
        $this->assertEquals("Mia",$users[1]->firstName);
        $this->assertEquals("171c335c7a1f3105fb1a9637667c59a0",$users[0]->password);
        $t = $this->u->addUser("1234","Mattias","Pesson","mattias@mevolution.se","jomen");
        $this->assertEquals($t,'{"error":"User allready exists"}');


    }

    public function test_deleteUser()
    {
        $t = $this->u->addUser("1234","Mattias","Persson","mattias@mevolution.se","jomen");
        $t = $this->u->addUser("12345","Mia","Persson","mia@mevolution.se","jojojjemen");
        $t = $this->u->addUser("1234","Mattias","Persson","mattias@roxtec.se","jomen");

        $t = $this->u->deleteUser("mattias@mevolution.se");
        $users = $this->u->getUserArray();
        $this->assertEquals("Mia",$users[0]->firstName);
        $this->assertEquals("mattias@roxtec.se",$users[1]->email);

    }

    public function test_getpassword()
    {
        $this->u->addUser("1234","Mattias","Pesson","mattias@mevolution.se","jomen");
        $t = $this->u->getUserPassword("1234");
        $this->assertEquals('{"error":"User dont exists"}',$t);
        $t = $this->u->getUserPassword("mattias@mevolution.se");
        $this->assertEquals($t,md5("jomen"));

    }
    public function test_ChangeUser()
    {
        $t = $this->u->addUser("1234","Mattias","Pesson","mattias@mevolution.se","jomen");
        $t = $this->u->addUser("12345","Mia","Pesson","mia@mevolution.se","jojojjemen");
        $t = $this->u->changeUser("Mattias__","PA","mattias@mevolution.se");
        $users = $this->u->getUserArray();
        $this->assertEquals("PA",$users[0]->lastName);
        $this->assertEquals("Mattias__",$users[0]->firstName);

    }
    public function test_Change_password (){
        $this->u->addUser("1234","Mattias","Pesson","mattias@mevolution.se","jomen");
        $this->u->changePassword("mattias@mevolution.se","nyttpass");
        $t = $this->u->getUserPassword("mattias@mevolution.se");
        $this->assertEquals("nyttpass",$t);
    }
    public function test_get_user_info(){
        $this->u->addUser("1234","Mattias","Persson","mattias@mevolution.se","jomen");
        $t = $this->u->getUserInfo("mattias@mevolution.se");

        $testJoson = '{"userId":"1234","firstName":"Mattias","lastName":"Persson","email":"mattias@mevolution.se","password":"' . md5("jomen") .'"}';
        $this->assertEquals($testJoson,$t);
    }


    public function test_change_email(){
        $this->u->addUser("1234","Mattias","Persson","mattias@mevolution.se","jomen");
        $this->u->changeEmail("1234","mattias@roxtec.com");
        $t = $this->u->getUserInfo("mattias@roxtec.com");
        $testJoson = '{"userId":"1234","firstName":"Mattias","lastName":"Persson","email":"mattias@roxtec.com","password":"' . md5("jomen") .'"}';
        $this->assertEquals($testJoson,$t);

        $t = $this->u->changeEmail("12345","mattias@roxtec.com");
        $this->assertEquals('{"error":"User dont exists"}',$t);
        $t = $this->u->getUserInfo("mattias@roxtec.com");
        $testJoson = '{"userId":"1234","firstName":"Mattias","lastName":"Persson","email":"mattias@roxtec.com","password":"' . md5("jomen") .'"}';


    }



}