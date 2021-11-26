#!/usr/bin/env php
<?php
    require_once "config.php";
    require_once "functions.php";

    $now = new DateTime();
    $interval = new DateInterval('P4M');
    $now->sub($interval);
    $year = $now->format('Y');
    $month = $now->format('m');
    $zipfilename = ARCHIVEDIR."archive-$year-$month.zip";
    $months = array_diff(scandir(BASEDIR."$year"), [".", ".."]);
    chdir(BASEDIR);
    $process = popen("zip -9 -r -@ $zipfilename", "w");
    foreach ($months as $mnt) {
        if ($mnt <= $month) {
            fwrite($process, "$year/$mnt\n");
        } 
    }
    pclose($process);
    
    //prepare message for email
    if (is_file($zipfilename)) {
        $disk_usage = getDiskUsage();
        $free_space = $disk_usage['free_space'];
        $free_percent = $disk_usage['free_percent'];
        $message = "Hello. This is an informational message from the PBX.\n
    Your archive file of conversation recordings is ready to download. You can download it from the following link: ".URL.". File size: ".getFileSize($zipfilename, "m")." mb.\n
    At the moment, free space on the PBX: $free_space gb\n$free_percent% of free space\n";
        sendMail(EMAIL, $message);  
        logWrite("The link to the file ".basename($zipfilename)." was sent to the email ".EMAIL);
    }
