$(document).ready(function(){
   
});

function getData(hal){
    var filterNamaDistributor = $('#filterNamaDistributor').val();
    $.ajax({
        url:"h2.php",
        type:'post',
        data:{mode:'getData', filterNamaDistributor},
        success:function(response){
            console.log(response);
             $("#tblGetData").children("tbody:first").html(response);
        }
    })
}