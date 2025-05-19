$(document).ready(function(){
   getData(1);
});

function getData(hal){
    var filterNamaDistributor = $('#filterNamaDistributor').val();
    var filterAktif = $('#filterAktif').val();
    $.ajax({
        url:"h2.php",
        type:'post',
        data:{mode:'getData', filterNamaDistributor, filterAktif},
        success:function(response){
            console.log(response);
             $("#tblGetData").children("tbody:first").html(response);
        }
    })
}

function edit(id){
    var txtNama = $('#txtNama'+id).text();
    var txtStatus = $('#txtStatus'+id).text();
    var txtAktif = $('#txtAktif'+id).text();
    var txtCons = $('#txtCons'+id).text();

    $('#inputNama').val(txtNama);
    $('#selectStatus').val(txtStatus);
    $('#selectAktif').val(txtAktif);
    $('#inputCons').val(txtCons);
}

function hapus(id){
    alert(id);
}