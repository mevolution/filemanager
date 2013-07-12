<?php


// FileManager.class.php
//
// A class to handle fileoperations
//

ini_set('track_errors', 1);

class FileManager {
	
	protected $baseDir = "";
	protected $hiddenFolders = array();
	protected $hiddenFiles = array();
	protected $fileHandler;

	function FileManager ($dir) {
		//init
		$dummy = $this->setBaseDir($dir);
		$this->SetHiddenFolder(".");
		$this->SetHiddenFolder("..");
		$this->SetHiddenFile(".DS_Store");
        $this->SetHiddenFile("upload_tmp");

    }
	function setBaseDir ($dir) {
		if (!is_readable($_SERVER['DOCUMENT_ROOT'] . "/" . $dir)) return "Error dir don't exists";
		$this->baseDir = $_SERVER['DOCUMENT_ROOT'] . "/" . $dir;
		return 1;	
	}
	function getBaseDir () {
		return $this->baseDir;
	}
	function setHiddenFolder ($folder) {
		$this->hiddenFolders[]= $folder;
	}

	function getHiddenFolders () {
		return $this->hiddenFolders;
	}
	function setHiddenFile ($file) {
		$this->hiddenFiles[]= $file;
	}

	function getHiddenFiles () {
		return $this->hiddenFiles;
	}

	// Gets files and folders except $hiddenFolders
	function getFiles($folder){
		  $out[] = null; 
		  $dir = $this->getBaseDir().$folder;
		  $handle = opendir($dir); 
		  $i = 0; 
		  while(false !== ($f = readdir($handle))) { 	
			  	if( !in_array($f,$this->hiddenFolders) && !in_array($f,$this->hiddenFiles) ) {
			  		
			  		$out[$i][name] = $f;
			  		$out[$i][size] = round(filesize($dir."/".$f) / 1024)	;   //lägg till array
			  		$out[$i][type] = filetype($dir."/".$f) ;
                    $out[$i][ext] =  strtolower(pathinfo($dir."/".$f, PATHINFO_EXTENSION));
			    }
			  					
			// }
			  	$i++ ;
		  }
		  unset($out[0]); // tar bort tom förstarad	
		  sort($out);
		return $out;

	}

	function createFolder($name,$dir) {
		// TODO Check that dir exists
	   mkdir($this->baseDir . $dir ."/" . $name, 0755);
       return 1;

	}
	
	function deleteFolder ($dir) {
		  $dir = $this->baseDir . $dir;
		  if (!is_readable($dir)) return "error dir not readable";
			//Check if dir is empty
		  if (count(scandir($dir)) == 2) {
			rmdir($dir);
			return 1;  	
		 }
		 else {
		 	return "Error: Dir not empty";
		 }
	}

	function deleteFile ($file) {
		$file = $this->baseDir . $file;
		if (!is_readable($file)) return "error file not readable";
		unlink($file);
		return 1;
	} 

    function moveFile ($src,$dest){
        $s = $this->baseDir .$src;
        $d = $this->baseDir .$dest;
        rename($s, $d) or die("File move failed " . $php_errormsg);
        return true;
    }

}
?>
