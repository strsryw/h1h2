$(document).ready(function(){
   getData(1);
});

function getData(hal){
    var filterNamaDistributor = $('#filterNamaDistributor').val();
    var filterStatus = $('#filterStatus').val();
    $.ajax({
        url:"h2.php",
        type:'post',
        data:{mode:'getData', filterNamaDistributor, filterStatus},
        success:function(response){
            console.log(response);
             $("#tblGetData").children("tbody:first").html(response);
        }
    })
}