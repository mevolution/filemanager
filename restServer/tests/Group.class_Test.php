<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mattias
 * Date: 2013-02-10
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */

require_once ("../src/Groups.class.php");



class GroupsTest extends PHPUnit_Framework_TestCase
{
    protected $g;
    protected $UserFile = "./GroupTest.json";

    function __construct(){

    }


    protected function setUp()
    {
        $this->g = new Groups();
       //  $this->u->setStoreFile($this->UserFile);

    }
    protected function tearDown()
    {
        //raderar test file store
        if (file_exists($this->UserFile)) {
           unlink($this->UserFile);
        }

    }

    public function test_add_and_read_group () {
        $this->g->addGroup("123","namnet","besk");
        $t= $this->g->getGroups();
        $this->assertEquals('[{"groupId":"123","groupName":"namnet","groupDescription":"besk","members":""}]',$t);
        $t = $this->g->addGroup("123","namnet","besk");
        $this->assertEquals('{"error":"Group already exists"}',$t);


    }
    public function test_get_group() {
        $this->g->addGroup("123","namnet","besk");
        $t= $this->g->getGroup("1234");
        $this->assertEquals('{"error":"Group does not exists"}',$t);
        $t= $this->g->getGroup("123");
        $this->assertEquals('{"groupId":"123","groupName":"namnet","groupDescription":"besk","members":""}',$t);
    }
    Public function test_delete_group() {
        $this->g->addGroup("123","namnet","besk");
        $this->g->addGroup("1234","namnet2","besk2");
        $t= $this->g->getGroups();
        $this->assertEquals('[{"groupId":"123","groupName":"namnet","groupDescription":"besk","members":""},{"groupId":"1234","groupName":"namnet2","groupDescription":"besk2","members":""}]',$t);
        $t = $this->g->deleteGroup("12345");
        $this->assertEquals('{"error":"Group does not exists"}',$t);
        $t = $this->g->deleteGroup("123");
        $this->assertEquals(true,$t);
        $t= $this->g->getGroups();
        $this->assertEquals('[{"groupId":"1234","groupName":"namnet2","groupDescription":"besk2","members":""}]',$t);
    }
    public function test_add_member_in_group() {
        $this->g->addGroup("123","namnet","besk");
        $t = $this->g->addMember("1234","uid123");
        $this->assertEquals('{"error":"Group does not exists"}',$t);

        $t = $this->g->addMember("123","uid123");
        $this->assertEquals(true,$t);


        $t= $this->g->getGroups();
        $this->assertEquals('[{"groupId":"123","groupName":"namnet","groupDescription":"besk","members":[{"userId":"uid123"}]}]',$t);
        $t = $this->g->addMember("123","uid123");
        $this->assertEquals(false,$t);

        $t = $this->g->addMember("123","uid1234");
        $t= $this->g->getGroups();

        $this->assertEquals('[{"groupId":"123","groupName":"namnet","groupDescription":"besk","members":[{"userId":"uid123"},{"userId":"uid1234"}]}]',$t);

    }

    public function test_to_get_members_in_group() {
        $this->g->addGroup("123","namnet","besk");
        $this->g->addMember("123","uid123");
        $this->g->addMember("123","uid1234");

        $t = $this->g->getMembers("123");
        $this->assertEquals('[{"userId":"uid123"},{"userId":"uid1234"}]',$t);
    }

    public function test_to_delete_member() {
        $this->g->addGroup("123","namnet","besk");
        $this->g->addMember("123","uid123");
        $this->g->addMember("123","uid1234");

        $t = $this->g->getMembers("123");
        $this->assertEquals('[{"userId":"uid123"},{"userId":"uid1234"}]',$t);
        $t = $this->g->deleteMember("123","uid123");

        $t = $this->g->getMembers("123");
        $this->assertEquals('[{"userId":"uid1234"}]',$t);


    }
    public function test_check_if_member_in_group () {
        $this->g->addGroup("123","namnet","besk");
        $this->g->addMember("123","uid123");
        $this->g->addMember("123","uid1234");
        $this->assertTrue($this->g->isInGroup("123","uid123"));
        $this->assertFalse($this->g->isInGroup("123","uid1"));

    }


}