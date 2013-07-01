<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mattias
 * Date: 2013-02-23
 * Time: 17:01
 */
class Group{
    public  $groupId;
    public  $groupName;
    public $groupDescription;
    public $members = array();

    function __construct($groupId,$groupName,$groupDescription,$members)
    {
        $this->groupId = $groupId;
        $this->groupName = $groupName;
        $this->groupDescription = $groupDescription;
        $this->members = $members;
    }
}


class Groups
{

    protected $fileStore = "./groups.txt";
    public  $groupsArray = array();


    function addGroup($groupId,$groupName,$groupDescription)
    {
        if (!$this->groupExists($groupId)){
            $g = new Group($groupId,$groupName,$groupDescription,"");
            if($this->groupsArray[] = $g){
                $this->write();
                return true;
            }
        }
        return '{"error":"Group already exists"}';
    }

    public function deleteGroup($groupId){
        if($this->findRecord($groupId)){
            array_splice($this->groupsArray,$this->getKey($groupId),1);
            return true;
        }
        return '{"error":"Group does not exists"}';
    }
    public function getGroup($groupId) {
        if($this->findRecord($groupId)){
            return json_encode($this->findRecord($groupId));
        }
        return '{"error":"Group does not exists"}';
    }
    public function getGroups() {
        return json_encode($this->groupsArray);
    }
    public function getMembers($groupId) {
         $k = $this->getKey("$groupId");
        return json_encode($this->groupsArray[$k]->members);
    }
    public function addMember($groupId,$userId) {
        if($this->groupExists($groupId)){
               if(!$this->memberExists($groupId,$userId)){
                   $k = $this->getKey($groupId);
                   $this->groupsArray[$k]->members[]['userId']= $userId;
                   return true;
                }
                return false;
        }
        return '{"error":"Group does not exists"}';
    }
    public function deleteMember($groupId,$userId) {
         $k = $this->getkey($groupId);
            foreach($this->groupsArray[$k]->members as $key=>$val){
                if($val["userId"] == $userId) {
                    array_splice($this->groupsArray[$k]->members,$k,1);
                }
            }

    }
    public function isInGroup($groupId,$userId) {
          return  $this->memberExists($groupId,$userId);
    }

    public function getStoreFile() {
        return $this->fileStore;
    }
    public function setStoreFile($fileName) {
        $this->fileStore = $fileName;
    }
    private function write() {
        $fh = fopen($this->fileStore, 'w')  or die("can't open file");
        $data = json_encode($this->groupsArray) ; // json_encode($d);
        fwrite($fh, $data);
        fclose($fh);
        return true;
    }
    private function read() {
        $error = '{"status" : false, "message" : "file open error"}' ;
        if (file_exists($this->fileStore)) {
            $fh = fopen($this->fileStore, 'r') or die($error);
            $theData = fread($fh, filesize($this->fileStore));
            $this->groupsArray = json_decode($theData);
            fclose($fh);
        }

    }

    private function groupExists($groupId){
        foreach($this->groupsArray as $key=>$val){
            if ($val->groupId == $groupId){
                return true;
            }
        }
        return false;
    }
    private function memberExists($groupId,$userId){
        foreach($this->groupsArray as $key=>$val){

           if ($val->groupId == $groupId){
                if($val->members != ""){
                  foreach($val->members as $k=>$v){
                      if ($v['userId'] == $userId){
                        return true;

                       }
                  }
                 }

            }
            return false;
        }
        return false;
    }
    private function findRecord($groupId)
    {
        foreach($this->groupsArray as $key=>$val){
            if ($val->groupId == $groupId){
                return $val;
            }
        }
        return false;
    }
    private function getKey($groupId)
    {
        $i =0;
        foreach($this->groupsArray as $key=>$val){
            if ($val->groupId == $groupId){
                return $i;
            }
            $i++;
        }
    }


}




