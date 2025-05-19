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
        <h1 class="text-center">BLOG</h1>
        <div class="row">
            <div class="col-md-6">
                <textarea id="text-area">
                    Welcome to TinyMCE!
                </textarea>
                <button class="btn btn-primary mt-3" onclick="saveData()">SAVE</button>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row" id="getBlog">

        </div>
    </div>

    <script>
        tinymce.init({
            selector: 'textarea#text-area',
            plugins: 'image code anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | code',
            branding: false,
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
            file_picker_types: 'image', // Enable custom filepicker only for Image dialog
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* Call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    });
                    reader.readAsDataURL(file);
                });

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
    <script src="h1.js"></script>
</body>

</html>