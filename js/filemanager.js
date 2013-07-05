
function FileManager ($scope,$http,$timeout) {
    $scope.rootLinkFolder ="/filemanager/testmapp/";
    $scope.rootUploadFolder ="/filemanager/plupload/upload_tmp/";
    $scope.rootImageFolder = "/filemanager/img/";
    $scope.rootAPIFolder = "/filemanager/restserver/";
    $scope.currentDir = [];
    $scope.fileList = {};
    $scope.status = "";



    $scope.setStatus = function(message,type,time) {
        time = time  * 1000|| 0;
//         $scope.status = message;

        var notice = '<div class="notice">'
         + '<div class="notice-body">'
                 + '<img src="js/purr-notify/img/info.png" alt="" />'
                 + '<h3>'+ type +'</h3>'
                 + '<p>'  + message + '</p>'
            + '</div>'
            + '<div class="notice-bottom">'
              + '</div>'
        + '</div>';

        $( notice ).purr(
            {
                usingTransparentPNG: true,
                // fadeInSpeed: 2000,
                // fadeOutSpeed: 1000,
                removeTimer: time

            }
        );

    }

    // Dir listings -----------

    $scope.getIcon = function (type,name,ext) {

       if(type=='dir'){
           return $scope.rootImageFolder + "folder_icon.png";
       }
       if(type == 'file'){
           if(_isImage(ext)){
           return $scope.rootLinkFolder +  _arrayToString($scope.currentDir,"dir","/") +  name;
           }
           else if(ext=='pptx'){
               return $scope.rootImageFolder + "powerpoint_icon.jpg";
           }
           else if(ext=='ppt'){
               return $scope.rootImageFolder + "powerpoint_icon.jpg";
           }
           else if(ext=='xlsx'){
               return $scope.rootImageFolder + "excel_icon.jpg";
           }
           else if(ext=='xls'){
               return $scope.rootImageFolder + "excel_icon.jpg";
           }
           else if(ext=='docx'){
               return $scope.rootImageFolder + "word_icon.jpg";
           }
           else if(ext=='doc'){
               return $scope.rootImageFolder + "word_icon.jpg";
           }
           else if(ext=='pdf'){
               return $scope.rootImageFolder + "pdf_icon.jpg";
           }
           else {
               return $scope.rootImageFolder + "document_icon.png";
           }

       }
    }




    $scope.getLink = function (name,type) {
        if(type == "dir") {
            return "#" ;
        }
        else {
            return $scope.rootLinkFolder +  _arrayToString($scope.currentDir,"dir","/") +  name;
        }
    }





    $scope.backDir = function (){
        $scope.currentDir.pop();
        _updateFileList();
    }
    $scope.openDir = function (name,type) {
       if(type=="dir"){
           $scope.currentDir.push({"dir":name});
           _updateFileList();
       }
    }
    $scope.changePath = function(level) {
        $scope.currentDir = _slicePath($scope.currentDir,level+1);
        _updateFileList();
    }
    _slicePath = function (arr,level) {
         o = arr.slice(0,level);
        return o;
    }
    _updateFileList= function() {
        dir = _arrayToString($scope.currentDir,"dir","/");
        $scope.getFiles(dir);
    }
    _arrayToString = function (arr,field,delimiter){
        var s ="";
        for (var i= 0;i < arr.length;i++ ){
           s = s + arr[i][field];
           s = s + delimiter;
        }
        return s;
    }

    //file preview functions
    _isImage = function (ext){
        switch(ext){
            case "jpg":
                return true
            break;
            case "png":
                return true
            break;
            case "gif":
                return true
            break;
            default:
               return false
            break;
        }
    }



    // File operations -----------------------
    $scope.getFiles = function (folder) {
        $http.get('restServer/listfiles/' + folder).success(function(data) {
            $scope.fileList = data;
        });
    }
    $scope.createDir = function (name){
        dir = _arrayToString($scope.currentDir,"dir","/");
        ut = 'json={"dir":"'+ dir +'","name":"'+ name +'"}';
        $http.put("restServer/createFolder/",ut).success(function(response) {
            _updateFileList();
        });

    }
    $scope.delete = function(file,type){
        path = _arrayToString($scope.currentDir,"dir","/") + file ;
        if(confirm("Är du säker? detta går inte att ångra...")) {
            if(type=='dir'){
                _deleteDir(path);
            }
            else{
                _deleteFile(path);
            }
        }
    }
    $scope.deleteCurrentDir = function(dir) {
        dir = _arrayToString($scope.currentDir,"dir","/");
        if (confirm("Är du säker?")){
            ut = 'json={"dir":"'+ dir + '/"}';
            $http.put("restServer/deleteFolder/",ut).success(function(response) {
                if(response == 1){
                    $scope.backDir();
                }
                else {
                    $scope.setStatus(response,'Varning',3);
                }
            });
        }
    };
    _deleteDir = function(dir){
        ut = 'json={"dir":"'+ dir + '/"}';
        $http.put("restServer/deleteFolder/",ut).success(function(response) {
            if(response == 1){
                _updateFileList();
            }
            else {
                $scope.setStatus(response,'Varning',1);
            }
        });
    }
    _deleteFile = function(file){
        ut = 'json={"file":"'+ file +'"}';
        $http.put("restServer/deleteFile/",ut).success(function(response) {
            if(response == 1){
                _updateFileList();
            }
            else {
                $scope.setStatus(response,'Varning',1);
            }
        });
    }
    _moveFile = function(src,dest) {
        ut = 'json={"src":"'+ src +'","dest":"'+ dest +'"}';
        $http.put("restServer/moveFile/",ut).success(function(response) {
            if(response == 1){
                $scope.setStatus('File uploaded!','Info',1);
                _updateFileList();
               // return true;
            }
            else {
                $scope.setStatus(response,'Varning',3);
                console.log(response);
            }
        });
    }

    // Upload files -----------------


    $scope.uploader = new plupload.Uploader({
        runtimes : 'gears,html5,flash,silverlight,browserplus',

        max_file_size : '100mb',
        browse_button : 'top-menu-upload',
       //  container: 'uploadContainer',
        url : 'upload.php',
      //  flash_swf_url : 'plupload/js/plupload.flash.swf',
      //  silverlight_xap_url : 'plupload/js/plupload.silverlight.xap',
        filters : [
            {title : "Image files", extensions : "jpg,gif,png,pdf"},
            {title : "Zip files", extensions : "zip"},
            {title : "Office files", extensions : "xlsx,xls,ppt,pptx,doc,docx"}
        ],
        resize : {width : 1280, height : 1280, quality : 100}
    });
    $scope.uploader.init();
    $scope.uploader.bind('FilesAdded', function(up, files) {
        $scope.$apply();
        $scope.uploader.start();
    });
    $scope.uploader.bind('FileUploaded', function(up, file) {
        currPath = _arrayToString($scope.currentDir,"dir","/");
       _moveFile("upload_tmp/" + file.name, currPath + file.name);
       _updateFileList();
});


   // Init -----------
    // _moveFile("DSC_5662.jpg","m1/DSC_5662.jpg");
    $scope.getFiles("");

}