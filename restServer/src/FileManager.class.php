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

/*
	function getFileTree ($dir) {
		if(!$array_out) $array_out = array();	
		$array_out[$dir] = $this->getFiles($dir);
			echo " ut <br>";
			foreach ($array_out as $key => $value) {
				echo $key[$value] . " " . $value . " <br>";
				foreach($value as $k => $v) {
					echo $k . " " . $v . " <br>";
				}
				
			}




		while() { 
	     
			} else if (is_dir($dir.'/'.$file) && ($file != '.') && ($file != '..')) {       
			     $this->getFileTree('/'.$file.'/');  
			} 
	    } 

       return $array_out; 
	}
*/


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
//$t = new FileManager("filemanager/testmapp");
//$out = $t->getFiles("/");
//echo "<PRE>";
//print_r($out);
//echo "</PRE>";
//
//// $t->moveFile("/DSC_5662.jpg","/m1/DSC_5662.jpg");
//$out = $t->getFiles("m1/");
//echo "<PRE>";
//print_r($out);
//echo "</PRE>";




// Tests
// echo "<h1>Tester FileManager</h1>\n";
// $t = new FileManager("filemanger/testmapp");
// $hf = $t->getHiddenFolders();
// echo"<h3>List hidden folders</h3>";
//print_r($hf);
//echo"<br>------------------------------<br>";

//echo"<h3>creates folder test</h3>";
//
//$t->createFolder("test","/");
//$t->createFolder("/test/test2");
//
//
//$out = $t->getFiles();
//echo"<h3>List files in basedir</h3>";
//echo "baseDir:" . $t->getBaseDir() . "<br>" ;
//echo "<PRE>";
//print_r($out);
//echo "</PRE>";
//echo"<br>------------------------------<br>";
//
//echo"<h3>deletes folder test</h3>";
//echo "<br>delete folder ". $t->deleteFolder("/test/test2");
//echo "<br>delete folder ". $t->deleteFolder("/test");
//echo "<br>delete file" . $t->deleteFile("/jomen.html");
//
//
//$out = $t->getFiles();
//echo"<h3>List files in basedir</h3>";
//echo "baseDir:" . $t->getBaseDir() . "<br>" ;
//echo "<PRE>";
//print_r($out);
//echo "</PRE>";
//echo"<br>------------------------------<br>";
//
//
//$out = $t->getFileTree("/");
//echo"<h3>dir tree</h3>";
//echo "baseDir:" . $t->getBaseDir() . "<br>" ;
//echo "<PRE>";
//print_r($out);
//echo "</PRE>";
//echo"<br>------------------------------<br>";
//
//?>
