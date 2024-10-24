<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload a File</title>
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
    <div class="container" style="padding-top:30px;">

        <div class="row">
            <div class="col-lg-12" style = "margin-bottom:10px;">
                <a class="btn btn-success" href="<?=site_url('attachment');?>">To List</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <?php if (session()->get('message')): ?>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <ul>
                                <?php foreach (session()->get('message') as $message): ?>
                                    <li><?= esc($message) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h1>Upload a File</h1>
                <form id="fileUploadForm" method="post" action="<?= site_url("attachment/upload_file"); ?>"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Choose a file:</label>
                        <input type="file" id="file" name="file" accept=".txt,.csv,.pdf">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    $(".datatable").DataTable()
</script>