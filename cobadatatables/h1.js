var selectJabatan = getDtOnload();
var databuffer = "karyawan|505|DIV-MIS|DIV-MIS|||172|12345|TRUE|5#KP5||true|^karyawan|506|DIV-FINANCE|DIV-FINANCE|||173|12346|TRUE|5#KP6||true|^karyawan|507|DIV-GA|DIV-GA|||174|12347|TRUE|5#KP7||true|^karyawan|508|DIV-LOGISTIK|DIV-LOGISTIK|||175|12348|TRUE|5#KP8||true|^karyawan|509|DIV-MSD|DIV-MFD|||176|12349|TRUE|5#KP9||true|^karyawan|510|DIV-MDP|DIV-MDP|||177|12350|TRUE|5#KP10||true|^karyawan|511|DIV-MKT1|DIV-MKT1|||178|12351|TRUE|5#KP11||true|^karyawan|512|DIV-MKT2|DIV-MKT2|||179|12352|TRUE|5#KP12||true|^karyawan|513|DIV-MKT4|DIV-MKT4|||180|12353|TRUE|5#KP13||true|^karyawan|514|DIV-HRD|DIV-HRD|||181|12354|TRUE|5#KP14||true|^karyawan|515|DIV-INT BUSINESS|DIV-INT BUSINESS|||182|12355|TRUE|5#KP15||true|^karyawan|516|DIV-SCIENTIFIC|DIV-SCIENTIFIC|||183|12356|TRUE|5#KP16||true|^karyawan|517|DIV-PROD DEV|DIV-PROD DEV|||184|12357|TRUE|5#KP17||true|^karyawan|518|DIV-MKT5|DIV-MKT5|||185|12358|TRUE|5#KP18||true|^karyawan|519|DIV-SEKRETARIAT|DIV-SEKRETARIAT|||186|12359|TRUE|5#KP19||true|^karyawan|520|DIV-DIREKSI|DIV-DIREKSI|||187|12360|TRUE|5#KP20||true|^karyawan|521|DIV-PROCLINIC|DIV-PROCLINIC|||188|12361|TRUE|5#KP21||true|^karyawan|522|DIV-GTR|DIV-GTR|||189|12362|TRUE|5#KP22||true|^karyawan|523|DIV-TRAINING|DIV-TRAINING|||190|12363|TRUE|5#KP23||true|^karyawan|524|DIV-PROD DESIGN|DIV-PROD DESIGN|||191|12364|TRUE|5#KP24||true|^karyawan|525|DIV-REGISTRASI|DIV-REGISTRASI|||192|12365|TRUE|5#KP25||true|^karyawan|526|DIV-HR|DIV-HR|||193|12366|false|5#KP26||true|^karyawan|527|DIV-PROD MANAGEMENT|DIV-PROD MANAGEMENT|||194|12367|TRUE|5#KP27||true|^karyawan|528|DIV-LEGAL|DIV-LEGAL|||195|12368|TRUE|5#KP28||true|^karyawan|529|DIV-MARFIN|DIV-MARFIN|||196|12369|TRUE|5#KP29||true|^karyawan|530|DIV-PURCHASING|DIV-PURCHASING|||197|12370|TRUE|5#KP30||true|^karyawan|544|DIV-CORPORATE STRA|DIV-CORPORATE STRA|||198|12345|true|5#KP31||true|^karyawan|627|DIV-IRA|DIV-IRA|||208|12345|true|5#KP5||true|^karyawan|628|DIV-DR|DIV-DR|||209|12345|true|5#KP5||true|^karyawan|629|DIV-DSO|DIV-DSO|||210|12345|true|5#KP5||true|^karyawan|630|DIV-PABRIK|DIV-PABRIK|||211|12345|true|5#KP5||true|^karyawan|633|DIV-MKT3|DIV-MKT3|||213|12345|true|5#KP5||true|^karyawan|641|DIV-MKT7|DIV-MKT7|||221|12345|true|4#KP4||true|^karyawan|665|DIV-DS|DIV-DS|||229|12345|true|5#KP5||true|^";

$(document).ready(function (e) {
    document.h1form.buffer.value = databuffer;
    setDataTable();
    var table = new DataTable('#example', {
        scrollX: 'true',
        // responsive:true,
        columnDefs: [
            {
                target: 0,
                visible: false
            }
        ]
    });
    var longpress = 500;
    var start;


    // table.on('click', 'tbody tr', (e) => {
    //     let targetRow = e.currentTarget;
    //     // Periksa apakah baris tersebut memiliki kelas 'selected'
    //     if ($(targetRow).hasClass('selected')) {
    //         let clickedCell = $(e.target).closest('td'); // Temukan sel yang diklik di dalam baris
    //         let indexcolumn = clickedCell.index(); // Hitung indeks kolom dari sel yang diklik
    //         console.log(indexcolumn);
            // if(indexcolumn == 9){ //bagian select
            //     $(targetRow).find('td').attr('contenteditable', 'false');
            // }else if(indexcolumn == 8){ //bagian checkbox
            //     $(targetRow).find('td').attr('contenteditable', 'false');
            // }else{
            //     $(targetRow).find('td').attr('contenteditable', 'true');
            // }
    //     } else {
    //         $(targetRow).find('td').attr('contenteditable', 'false');

    //         // Hapus kelas 'selected' dari semua baris terpilih lainnya
    //         table.rows('.selected').nodes().each((row) => {
    //             $(row).find('td').attr('contenteditable', 'false');
    //             $(row).removeClass('selected');
    //         });

    //         // Tambahkan kelas 'selected' ke baris yang diklik
    //         $(targetRow).addClass('selected');
    //     }
    // });

    table.on('click', 'tbody td', function() {
       
        var idKaryawan = table.row(this).data()[0];
        var indexcolumn = table.cell(this).index()['column'];
        console.log(indexcolumn);
        var labelCabang = document.getElementById('cabang'+idKaryawan);
        var selectKaryawan = document.getElementById('karyawan'+idKaryawan);
        if (idKaryawan.includes('N')) { //ketika add data
            var computedStyle = window.getComputedStyle(selectKaryawan);
            var displayPropertyValue = computedStyle.getPropertyValue('display');
            if (displayPropertyValue === 'none') { //ketika display none maka select2 sebelumnya didestroy
                selectKaryawan.style.display='block';
                $('#karyawan'+idKaryawan).select2({
                    width: "100%"
                });
            } else {
                
            }
            labelCabang.style.display='none';
         
            // $('#karyawan'+idKaryawan).select2({
            //     width: "100%"
            // });
            var selectedBefore = document.getElementsByName('tableRow');
            for(let i = 0;i<selectedBefore.length;i++){ // hapus semua selected yang ada
                selectedBefore[i].classList.remove('selected');
            }
            var trElement = $(this).closest('tr');
            trElement.attr('data-id', idKaryawan); //tambahkan data id yang nantinya dipakai untuk add
            trElement.attr('id', 'row' + idKaryawan);  //id digunakan dalam proses dom
            trElement.attr('name', 'tableRow');  //attr name agar selaras dengan tr sebelumnya
            trElement.addClass('selected'); //lalu selected ketika masi dalam data ini
            $(this).attr('contenteditable', 'true');
        }
        else{
            var selectedRow = document.getElementById('row'+idKaryawan);
            if($(selectedRow).hasClass('selected')){
                if(indexcolumn == 10){ //bagian select
                    $(this).attr('contenteditable', 'false');
                }else if(indexcolumn == 9){ //bagian checkbox
                    $(this).attr('contenteditable', 'false');
                }else{
                    $(this).attr('contenteditable', 'true');
                }
            }else{
               var selectedBefore = document.getElementsByName('tableRow');
               for(let i = 0;i<selectedBefore.length;i++){
                    selectedBefore[i].classList.remove('selected');
               }
                selectedRow.classList.add('selected');
                selectedRow.setAttribute('data-id', idKaryawan);
            }
         
        }
    });

    table.on('blur', 'tbody tr td', function (e) {
        $(this).attr('contenteditable', 'true');
        var nilaiSesudah = $(this).text();
        var idKaryawan = table.row(this).data()[0];
        // console.log(idKaryawan);
        var indexcolumn = table.cell(this).index()['column'];
        
        if (indexcolumn == 9) {
            //data new row
            if (idKaryawan.includes('N')) {
                var checkBox = document.getElementById('checkBox' + idKaryawan);
                if (checkBox.checked) {
                    checkBox.value = true;
                } else {
                    checkBox.value = false;
                }
                //data yang sudah ada ketika getdata
            } else {
                var checkBox = document.getElementById('checkBox' + idKaryawan);
                if (checkBox.checked) {
                    checkBox.value = true;
                } else {
                    checkBox.value = false;
                }
            }
            updateDataOnBuffer("karyawan", idKaryawan, indexcolumn, checkBox.value, document.forms[0].buffer);
        } 
        else if (indexcolumn == 10) { // select autocomplete
            // //data new row
            // if (idKaryawan.includes('N')) {
            //     var selectKaryawan = document.getElementById('karyawan' + idKaryawan);
            //     // selectKaryawan.style.display='none';
            //     var labelCabang = document.getElementById('cabang' + idKaryawan);
            //     // labelCabang.style.display='block';
            //     //data yang sudah ada ketika getdata
            // } 
            // else {
            //     var selectKaryawan = document.getElementById('karyawan' + idKaryawan).value;
            //     var labelCabang = document.getElementById('cabang' + idKaryawan).innerText;
            // }
            // if (selectKaryawan == 'GM') { //pembatasan untuk mengembalikan nilai
            //     updateDataOnBuffer("karyawan", idKaryawan, indexcolumn, selectKaryawan, document.forms[0].buffer);
            // } else {
            //     updateDataOnBuffer("karyawan", idKaryawan, indexcolumn, selectKaryawan, document.forms[0].buffer);
            // }
        } 
        else {
            updateDataOnBuffer("karyawan", idKaryawan, indexcolumn, nilaiSesudah, document.forms[0].buffer);
        }
    })
})

function setDataTable() {
    var dataBuffer = document.h1form.buffer.value;
    var splitBuffer1 = dataBuffer.split('^');
    var txtData = '';
    var n = 1;
    var lastValue;
    splitBuffer1.forEach(function (item) {
        var itemData = item.split('|'); //length 13
        // console.log(itemData);
        if (itemData.length >= 11) {
            // console.log(itemData[11]);
            txtData += `<tr id='row${itemData[1]}' name='tableRow'>
                    <td>${itemData[1]}</td>
                    <td>${itemData[2]}</td>
                    <td>${itemData[3]}</td>
                    <td>${itemData[4]}</td>
                    <td>${itemData[5]}</td>
                    <td>${itemData[6]}</td>
                    <td>${itemData[7]}</td>
                    <td>${itemData[8]}</td>
                    <td>${itemData[9]}</td>
                    <td>${itemData[10]}
                        <input contenteditable='false' type="checkbox" id="checkBox${itemData[1]}" name="checkBox">
                    </td>
                    <td>
                        <label contenteditable='false' id ='cabang${itemData[1]}' >${itemData[11]}</label>
                    </td>
                    
                </tr>`;
            //dapatkan last id
            lastValue = itemData[1]; //belum berguna
            n++;
        }

    });
    //tampung
    document.getElementById('lastIdTable').value = lastValue;
    $("#example").children("tbody:first").html(txtData);
    // $('.select2').select2({
    //     width: "75%"
    // });
    // var selectKaryawan = document.getElementsByName('karyawan');
    // for (let i = 0; i < selectKaryawan.length; i++) {
    //     selectKaryawan[i].innerHTML = selectJabatan;
    // }
}

function addData() {
    $("#example").DataTable().page('last').draw('page');
    tambahRecord();
}

function tambahRecord() {
    // var lastIdTable = document.getElementById('lastIdTable').value;
    lastId = document.forms[0].lastId.value;
    if (lastId.length == 0) {
        document.forms[0].lastId.value = '0';
        // lastIdTable = parseInt(lastIdTable) + 1;
        // document.getElementById('lastIdTable').value = lastIdTable;
    }
    else {
        lastId = parseInt(lastId) + 1;
        document.forms[0].lastId.value = lastId;
        // lastIdTable = parseInt(lastIdTable) + 1;
        // document.getElementById('lastIdTable').value = lastIdTable;
    }
    lastId = document.forms[0].lastId.value;

    var select = `<div id='col10N${lastId}'><label id ='cabangN${lastId}' style='display:none;'>true</label>
    <select class='select2' name="karyawan" id="karyawanN${lastId}" onchange="jabatan('${lastId}', '10')">
    </select></div>`;

    var checkbox = `<input type="checkbox" id="checkBoxN${lastId}" name="checkBox">`;
    const table = new DataTable('#example');
    table.row
        .add([
            'N' + lastId,
            'Masukkan inputan',
            'Masukkan inputan',
            'Masukkan inputan',
            'Masukkan inputan',
            'Masukkan inputan',
            'Masukkan inputan',
            'Masukkan inputan',
            'Masukkan inputan',
            checkbox,
            select
        ])
        .draw(false);
    document.getElementById('karyawanN' + lastId).innerHTML = selectJabatan;
    document.getElementById('karyawanN' + lastId).style.color = 'black'; //buat color hitam agar tidka tabrakan dgn selected
    // document.getElementById('col10N'+lastId).style.display = 'none'; // none td col10
    $('#karyawanN' + lastId).select2({
        width: "100%"
    });
    newRow = "karyawan|N" + lastId + "|||||||12345|true|||^";
    document.forms[0].buffer.value = document.forms[0].buffer.value + newRow;
}

//onchange rowSelected menambahkan tanda biru ketika selected 
// function rowSelected(id) {
//     var selectRow = document.getElementById('selectRow' + id);
//     if (selectRow.checked === true) {
//         // Mendapatkan referensi ke elemen <tr> terkait (contoh: parent dari checkbox)
//         var trElement = selectRow.closest('tr');
//         if (trElement) {
//             // Menambahkan atau menghapus kelas 'selected' dari elemen <tr>
//             trElement.classList.add('selected');
//             document.getElementById('karyawan' + id).style.color = 'black';
//         }
//     } else if (selectRow.checked === false) {
//         var trElement = selectRow.closest('tr');
//         if (trElement) {
//             // Menambahkan atau menghapus kelas 'selected' dari elemen <tr>
//             trElement.classList.remove('selected');
//         }
//     }
// }

function delData() {
    var selected = document.getElementsByClassName('selected');
    var id = $(selected[0]).attr("data-id");
    selected[0].style.display = 'none';
    deleteDataOnBuffer("karyawan", id, document.forms[0].buffer);
}

//get select value 
function getDtOnload() {
    var url = 'h2.php';
    var dataCallback;
    $.ajax({
        url: url,
        type: "POST",
        data: { mode: 'getDtOnload' },
        dataType: "text",
        async: false,
        success: function (result) {
            // console.log(result);return
            dataCallback = result;
        }
    });
    return dataCallback;
}

//onchange jabatan
function jabatan(id, indexcolumn){
   
    var selectJabatan = document.getElementById('karyawanN'+id); // dapat value select
    var selectedOption = selectJabatan.options[selectJabatan.selectedIndex];
    console.log(selectedOption);
    // alert(selectedOption);
    var text = selectedOption.innerText;
    // console.log(text);
    var labelJabatan = document.getElementById('cabangN'+id); // get jabatan
    labelJabatan.innerText = text; // tukar inertext jabatan dengan value select
    labelJabatan.style.display = 'block';
    //update buffer
    updateDataOnBuffer("karyawan", 'N'+id, indexcolumn, text, document.forms[0].buffer);
    //hide dari tampilan
    $("#karyawanN"+id).select2('destroy'); 
    document.getElementById('karyawanN'+id).classList.remove('select2');
    document.getElementById('karyawanN'+id).style.display='none';
}
//html
//jika dibutuhkan
// onchange="rowSelected('${itemData[1]}')"
// console.log(table.cell(this).index()['column'])
// console.log('clicked: ' + table.row(this).data()[1])

/* <select contenteditable='false' class='select2' name="karyawan" id="karyawan${itemData[1]}">
    <option value="SATRIO">SATRIO</option>
    <option value="RIZKI">RIZKI</option>
    <option value="BAGUS">BAGUS</option>
</select> */

// MASIH BUG BUG BUG BAGIAN ONCHANGEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE