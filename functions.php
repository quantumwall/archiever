<?php
    
    function getFileSize($path_to_file, $unit) {
        if (!is_file($path_to_file)) return false;
        $size = filesize($path_to_file);
        switch (strtolower($unit)) {
            case "g":
                $size = round($size / 1024 ** 3, 1);
                break;
            case "m":
                $size = round($size / 1024 ** 2, 1);
                break;
            case "k":
                $size = round($size / 1024, 1);
                break;
        }
        return $size;
    }
    
    function getDiskUsage() {
        $free_space = disk_free_space("/");
        $total_space = disk_total_space("/");
        $free_percent = $free_space / $total_space * 100;
        $free_space = round($free_space / 1024 ** 3, 1);
        $free_percent = round($free_percent, 1);
        $output = ["free_space" => $free_space, "free_percent" => $free_percent];
        return $output; 
    }
    
    function sendMail($to, $msg) {
        $subj = "Notification from PBX";
        mail($to, $subj, $msg); 
    }

    function sendFile($path_to_file) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($path_to_file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path_to_file));
        readfile($path_to_file);
    }

    function deleteFile($path_to_file) {
        if (!is_file($path_to_file)) {
            $log_msg = "$path_to_file is not exists\n";
            logWrite($log_msg);
        }
        unlink($path_to_file);              
    }
    
    function logWrite($msg) {
        require_once "config.php";
        $dt = date("d-M-Y H:i:s");
        $msg = "[$dt] $msg\n";
        file_put_contents(LOG_FILE, $msg, FILE_APPEND);
    }
