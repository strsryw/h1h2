$(document).ready(function(){
    var url = 'h2.php';
    $.ajax({
        url:url,
        type:'post',
        data:({mode:'retrieveData'}),
        dataType:'text',
        success:function(result){
        //  console.log(result);return
            document.getElementById('jstree').innerHTML = result;
               // tempel jstree ketika data sudah ready
               $("#jstree").jstree({
                "core": {
                    "multiple": false,
                    "animation": 0
                }
            });
        }
    })
});