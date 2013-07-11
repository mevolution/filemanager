<?php

session_start();
include ('restServer/src/Session.class.php');
$s = new Session("./users.json");

if($s->login($_REQUEST["email"],md5($_REQUEST["passwd"]))) {
$l=true;
}else {
header('Location: ./index.php?errorLogin=true');
}

?>
<!DOCTYPE html>
<html ng-app xmlns="http://www.w3.org/1999/html" id="ng-app">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!--[if lte IE 8]>
    <script src="lib/json3.min.js"></script>
    <![endif]-->

    <title>Filemanager</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" >
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/test.css" rel="stylesheet" >


    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/angular-1.0.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="plupload/js/plupload.full.js" type="text/javascript"></script>
    <!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
    <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>

    <script type="text/javascript" src="js/jquery.purr.js"></script>
    <link type="text/css" href="js/purr-notify/purr.css" rel="stylesheet">

    <script src="js/filemanager.js"></script>

</head>
<body ng-controller="FileManager">

    <div id="mev_top">
        <div id="mev_top_site_id">
            <i class="icon-suitcase"></i> Filhanteraren
        </div>
        <div id="mev_top_logout">
            &nbsp;&nbsp; <a href="index.php?logout=true" ><i class="icon-signout"></i>log out</a>
        </div>

        <div id="mev_top_loggeginuser">
            <i class="icon-user"></i> <span class="hidden-mobile"> mattias@mevolution.se </span>
        </div>


    </div>

    <div id="top-menu-canvas">

            <div id="top-menu-upload" ><i class="icon-large icon-upload-alt"></i> Ladda upp fil </div>
            <div id="top-menu-create-folder"><i class="icon-large icon-folder-close-alt"></i> <a href="#createFolderModal" data-toggle="modal">+Skapa mapp </a></div>


    </div>



<div class="container-fluid">

    <div class="row-fluid" id="toolbarFileList">
        <div class="span12 ">
            <ul class="breadcrumb pull-left">
                <li><a href="#" class="active">/</a><span class="divider"></span></li>
                <li ng-repeat="folders in currentDir"><a href="#" ng-click="changePath($index)">{{folders.dir}}</a> <span class="divider">/</span></li>
            </ul>

        </div>
        <!--
         <div class="span6 ">
            <input type="search" class="pull-right input-medium search-query" placeholder="search" ng-model="search.txt">
         </div>
        -->
     </div>
     <div class="row-fluid" id="FilelistContainer">
         <div class="span12">
             <table class="table table-bordered table-striped">
                 <thead>
                 <th ng-click="backDir()">Namn</th>
                 <th>Storlek</th>
                 <th></th>
                 </thead>
                 <tbody>
                 <tr ng-hide="currentDir.length<1">
                     <td><a href="#" ng-click="backDir()"><i class="icon-arrow-up"></i>...</a></td>
                     <td>{{files.size}}</td>
                     <td>{{files.type}}</td>

                 </tr>

                 <tr ng-repeat="file in fileList| filter:search.txt">
                     <td><a href="{{getLink(file.name,file.type)}}" target="{{getTarget(file.type)}}" ng-click="openDir(file.name,file.type)"><img src="{{getIcon(file.type,file.name,file.ext)}}" class="file-image"  width="40" /> {{file.name}}</a></td>
                     <td>{{file.size}}</td>
                     <td><a href="#" ng-click="delete(file.name,file.type)"><i style="color: red" class="icon-remove icon-large"></i> </a></td>
                 </tr>
                 </tbody>
             </table>
         </div>

     </div>
 </div>

 <footer class="navbar navbar-fixed-bottom">
     <div class="navbar-inner" >
         <h5>Mevolution 2013</h5>
     </div>
 </footer>
 <!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="createFolderModal" class="modal hide fade modal-create"  tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title">Skapa Mapp</h3>
    </div>
    <div class="modal-body">
        <input type="text" placeholder="namn" ng-model="input.Folder">
    </div>
    <div class="modal-footer">
        <a class="btn btn-primary" ng-click="createDir(input.Folder)" data-dismiss="modal">
            <span><i class="icon-plus icon-white"></i> Skapa</span>
        </a>
    </div>
</div>
</body>
</html>