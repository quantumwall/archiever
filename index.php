<?php
    require_once "config.php";
    require_once "functions.php";
    $archives = array_diff(scandir(ARCHIVEDIR), [".", ".."]);
      
?>
<!DOCTYPE html>
<html>
<head>
    <title>Archives list</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php if (!empty($archives)):?>
                <h1>List of archives</h1>
                <?php else: ?>
                <h1>No files to download</h1>
                <?php endif?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th>Size</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($archives as $archive):?>
                        <tr>
                            <td><?=$archive;?></td>
                            <td><?php print getFileSize(ARCHIVEDIR.$archive, "m");?> Mb</td>
                            <td>
                                <a class="btn btn-success btn-block" href='<?=URL."download.php?file=$archive";?>'>Download</a><br>
                                <a onclick="return confirm('Delete this file?')" class="btn btn-danger btn-block" href='<?=URL."download.php?file=$archive&delete";?>'>Delete</a>
                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            <div>
        </div>
    </div>
                  
</body>
</html>
