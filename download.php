<?php
    $file = !empty($_GET['file']) ? $_GET['file'] : "";
    $delete = isset($_GET['delete']) ? true : false;
    if (!$file) {
        print "File is no specified";
        exit();
    }
    require_once "config.php";
    $path_to_file = ARCHIVEDIR.$file;
    if (!is_file($path_to_file)) {
        print "The file not exists";
        exit();
    }
    
    require_once "functions.php";
    if ($delete) {
        unlink($path_to_file);
        logWrite("$path_to_file was deleted");
    } else { 
        sendFile($path_to_file);
        logWrite("$path_to_file was downloaded");
    }
    header("Location: /archiever");
