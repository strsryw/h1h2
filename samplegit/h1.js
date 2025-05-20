$(document).ready(function(){
   getData(1);
   alert("Test");
   console.log("abcdefg");
});

function getData(hal){
    var filterNamaDistributor = $('#filterNamaDistributor').val();
    var filterAktif = $('#filterAktif').val();
    $.ajax({
        url:"h2.php",
        type:'post',
        data:{mode:'getData', filterNamaDistributor, filterAktif},
        success:function(response){
            // console.log(response);
             $("#tblGetData").children("tbody:first").html(response);
        }
    })
}

function edit(id){
    var txtNama = $('#txtNama'+id).text();
    var txtStatus = $('#txtStatus'+id).text();
    var txtAktif = $('#txtAktif'+id).text();
    var txtCons = $('#txtCons'+id).text();

    $('#inputId').val(id);
    $('#inputNama').val(txtNama);
    $('#selectStatus').val(txtStatus);
    $('#selectAktif').val(txtAktif);
    $('#inputCons').val(txtCons);
}

function hapus(id){
    var mode = "hapus";
    if(confirm("Apakah anda yakin ?")){
    $.ajax({
        url:"h2.php",
        type:"post",
        data:{id, mode},
        success:function(response){
            console.log(response);
        }
    })
    }
     
}

function simpan(){

    var id = $('#inputId').val();
    var nama = $('#inputNama').val();
    var status = $('#selectStatus').val();
    var aktif = $('#selectAktif').val();
    var cons = $('#inputCons').val();
    var mode = "simpan";
    $.ajax({
        url:"h2.php",
        type:"post",
        data:{id, nama, status, aktif, cons, mode},
        success:function(response){
            console.log(response);
            if(response == "sukses"){
            alert("Data berhasil disimpan");
            $('#inputId').val('');
            $('#inputNama').val('');
            $('#selectStatus').val('');
            $('#selectAktif').val('');
            $('#inputCons').val('');
            getData(1);
            }else if(response == "gagal"){
                alert("Data gagal disimpan");
            }
        }
    })
}