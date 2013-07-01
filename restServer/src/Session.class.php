<?php
/**
 * Login class by Mevolution Feb 2013
 *
 */
include ('Users.class.php');
class Session
{
   private $users;

    function __construct($userFile){
    $this->users = new Users();
    $this->users->setStoreFile($userFile);
   }
   public function login ($email,$password) {
     if($this->users->getUserPassword($email) == $password) {
        $this->setSession($email);
         return  true;
     }
     else {
         return false;
     }
   }
   public function logout () {
       $_SESSION = null;
       return true;
   }
   public function checkIfLoggedin ($email) {
          if($_SESSION["loggedIn"]== "Japp"){
              return true;
          }
          else{
              return false;
          }
   }
    private function setSession($email){
        $_SESSION["loggedIn"] = "Japp";
    }
    private function destroySession(){

    }

}

