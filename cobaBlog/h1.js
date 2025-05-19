$(document).ready(function(){

getData();
   
});

function getData(){
    $.ajax({
        url:'h2.php',
        type:'post',
        data:({mode:'retrieveData'}),
        success:function(result){
            // console.log(result);
            document.getElementById('getBlog').innerHTML = result;
        }
    });
}

function saveData() {
    var editor = tinymce.get('text-area');
    // Dapatkan nilai konten dari editor
    var content = editor.getContent();

    $.ajax({

        url:'h2.php',
        type:'post',
        data:({ content, mode:'insertContent'}),
        success:function(result){
            getData();
        }
    })
  }

