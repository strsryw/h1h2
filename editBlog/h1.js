$(document).ready(function(){
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
    getData();
       
    });
    
    function getData(){
        $.ajax({
            url:'h2.php',
            type:'post',
            data:({mode:'retrieveData'}),
            success:function(result){
                // console.log(result);
                $('#tableData').children('tbody:first').html(result);
               
            }
        });
    }

    function editData(id){
        $('#myModal').modal('show');
        var content = document.getElementById('txtContent'+id).innerHTML;
        document.getElementById('idTampung').value = id;
        var editor = tinymce.get('text-area');
        // Mengosongkan konten editor
        editor.setContent(content);
        // document.getElementById('text-area').value = content;
    }

    function hapusData(id){
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url:'h2.php',
                type:'post',
                data:({id, mode:'deleteContent'}),
                dataType:'text',
                success:function(result){
                    // console.log(result);return
                    alert('Data berhasil dihapus');
                    getData();
                }
            })
        }
    }
    
    function saveData() {
        var id = document.getElementById('idTampung').value;
        var editor = tinymce.get('text-area');
        // Dapatkan nilai konten dari editor
        var content = editor.getContent();
        // console.log(content);
        $.ajax({
            url:'h2.php',
            type:'post',
            data:({ content, mode:'updateContent', id}),
            success:function(result){
                $('#myModal').modal('hide');
                getData();
                var editor = tinymce.get('text-area');
                // Mengosongkan konten editor
                editor.setContent('');
            }
        })
      }
    
    