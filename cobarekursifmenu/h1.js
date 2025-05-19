$(document).ready(function(){

    var url = 'h2.php';
    $.ajax({
        url:url,
        type:'post',
        data:({mode:'retrieveData'}),
        dataType:'text',
        success:function(result){
            // console.log(result);
            document.getElementById('tampungList').innerHTML = result;
        }   
    })

});