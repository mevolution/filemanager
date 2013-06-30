<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mattias
 * Date: 2013-02-11
 * Time: 22:52
 * To change this template use File | Settings | File Templates.
 */

class User {
    public $userId ="";
    public $firstName ="";
    public $lastName ="";
    public $email ="";
    public $password ="";

    function __construct($userId,$fistName,$lastName,$email,$password)
    {
        $this->userId = $userId;
        $this->firstName = $fistName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }
}

class Users
{

    protected $fileStore ; // = "./users.json";
    public  $userArray = array();

    function __construct() {
        //read users from filestore
        $this->read();
    }

    public function getUserArray() {
        return $this->userArray;
    }
    public function getStoreFile() {
        return $this->fileStore;
    }
    public function setStoreFile($fileName) {
        $this->fileStore = $fileName;
        $this->read();
    }

    public function addUser($userId,$fistName,$lastName,$email,$password)
    {

        if (!$this->userEmailexists($email)){
             $u = new User($userId,$fistName,$lastName,$email,$password);
             if($this->userArray[] = $u){
                 $this->write();
                 return true;
             }
       }

        return '{"error":"User allready exists"}';
    }
    public  function deleteUser ($email)
    {
       array_splice($this->userArray,$this->getKey($email),1);
       $this->write();
    }
    public function changeUser($fistName,$lastName,$email)
    {
        $this->userArray[$this->getKey($email)]->firstName = $fistName;
        $this->userArray[$this->getKey($email)]->lastName = $lastName;
        $this->userArray[$this->getKey($email)]->email = $email;
        $this->write();
    }
    //TODO Skriv tester!
    public function changeEmail($userId,$email)
    {
        if($this->userExists($userId)){
            foreach($this->userArray as $key=>$val){
                if ($val->userId == $userId){
                    $this->userArray[$key]->email = $email;
                    $this->write();
                    return true;
                }
            }
        }
        else {
                return '{"error":"User dont exists"}';
        }


    }

    public function changePassword($email,$password)
    {
        $this->userArray[$this->getKey($email)]->password = $password;
        $this->write();
    }
    public function getUserInfo ($email)
    {
        return json_encode($this->findRecord($email));
    }
    public function getUserPassword ($email)
    {
        $v = $this->findRecord($email);
        if($this->userEmailexists($email)){
            return $v->password;
        }
        else {
            return $v;
        }

    }

    private function write() {
        $fh = fopen($this->fileStore, 'w')  or die("can't open file");
        $data = json_encode($this->userArray) ; // json_encode($d);
        fwrite($fh, $data);
        fclose($fh);
        return true;
    }
    private function read() {
        $error = '{"status" : false, "message" : "file open error"}' ;
        if (file_exists($this->fileStore)) {
            $fh = fopen($this->fileStore, 'r') or die($error);
            $theData = fread($fh, filesize($this->fileStore));
            $this->userArray = json_decode($theData);
            fclose($fh);
        }

    }
    // Util funktioner
    private function findRecord($email)
    {
        foreach($this->userArray as $key=>$val){
            if ($val->email == $email){
                return $val;
            }
            else{
                return '{"error":"User dont exists"}';
            }
        }
    }

    private function getKey($email)
    {
        $i =0;
        foreach($this->userArray as $key=>$val){
            if ($val->email == $email){
                return $i;
            }
            $i++;
        }

    }

    private function userExists($userId){
        foreach($this->userArray as $key=>$val){
            if ($val->userId == $userId){
                return true;
            }
        }
        return false;
    }


    private function userEmailexists($email){
            foreach($this->userArray as $key=>$val){
                if ($val->email == $email){
                    return true;
                }
            }
            return false;

     }


}
