<?php
include("../functions/koneksi.php");
// include("../functions/session.php");
include("../functions/function.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tiny.cloud/1/7zdw7wouyd7q3o67u5jr3miejmlahrnpaocg7kifgdofnyzx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link type="text/css" href="../functions/style.css" rel="stylesheet" />
    <link type="text/css" href="../functions/jquery/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
    <link href="../functions/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../functions/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="../functions/bootstrap/js/bootstrap.min.js"></script>

    <style>
        img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center">EDIT BLOG</h1>
        <!-- <div class="row">
            <div class="col-md-6">
                <textarea id="text-area">
                    Welcome to TinyMCE!
                </textarea>
                <button class="btn btn-primary mt-3" onclick="saveData()">SAVE</button>
            </div>
        </div> -->
    </div>


    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableData">
                    <thead>
                        <tr>
                            <th class="text-center" width="10%">No</th>
                            <th class="text-center" width="70%">Content</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idTampung">
                    <textarea id="text-area"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveData()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
    <script src="h1.js"></script>
</body>

</html>