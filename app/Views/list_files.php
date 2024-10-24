<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Files</title>
    <!--Bootstrap and JQuery CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--Custom CSS and JS-->
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <!--Datatable CDN-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
    <!--End of CDN-->
</head>
<body>
    <div class="container"  style="padding-top:30px;">
    <div class="row">
            <div class="col-lg-12"   style = "margin-bottom:10px;">
                <a class="btn btn-success" href="<?=site_url('/');?>">To Upload</a>
            </div>
        </div>

        <?php 
            $attachmentLibrary = new \App\Libraries\AttachmentLibrary();
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1>List Files</h1>
                <table id="filesTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($files as $file):?>
                            <tr>
                                <td><?=$file['file_name']?></td>
                                <td><?=$file['file_size']?> KB</td>
                                <td><a target="_blank" href="<?=$attachmentLibrary->createPresignedUrl($file['file_name']);?>">Download</a></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>