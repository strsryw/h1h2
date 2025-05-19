<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <title>Form Penilai</title>
    <script type="text/javascript" src="../base/aw.js"></script>
    <script type="text/javascript" src="../base/functions.js"></script>


    <script type="text/javascript" src="../functions/jQuery/js/jquery-1.4.2.min.js"></script>
    <link type="text/css" href="../functions/select2.css" rel="stylesheet" />
    <link href="../functions/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </link>
    <link href="../base/aw.css" rel="stylesheet">
    </link>

    <!-- dataTables  -->
    <!-- <link href="https://cdn.datatables.net/v/dt/dt-2.0.5/datatables.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../base/dataTables.dataTables.css">
    <link rel="stylesheet" href="../base/responsive.dataTables.css">
    <link rel="stylesheet" href="../base/rowReorder.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.5/datatables.min.js"></script>
    <script src="../base/dataTables.rowReorder.js"></script>
    <script src="../base/dataTables.responsive.js"></script>
    <!-- dataTables  -->
    <script type="text/javascript" src="h1.js"></script>
    <script type="text/javascript" src="../functions/select2.js"></script>
    <style type="text/css">
        /* .select2-hidden-accessible {
            position: fixed !important;
        } */

        .style1 {
            font-family: "Lucida Grande", Geneva, Arial, Helvetica, Verdana, sans-serif;
            font-size: 14px;
        }

        .select2-selection__rendered {
            line-height: 20px !important;
            width: 130px;
        }

        .select2-container .select2-selection--single {
            height: 20px !important;
        }

        .select2-selection__arrow {
            height: 20px !important;
        }

        input[type=button] {
            font-family: "Lucida Grande", Geneva, Arial, Helvetica, Verdana, sans-serif;
        }
    </style>
</head>

<body style="font-family:Tahoma">

    <h3 class="style1">Matriks Penilaian</h3>
    <form name="h1form" method="post" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="style1">

        </table>
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>NIK</th>
                    <th>NamaKaryawan</th>
                    <th>NamaPerusahaan</th>
                    <th>NamaJabatan</th>
                    <th>Password</th>
                    <th>Isactive</th>
                    <th>Group</th>
                    <th>Kosong</th>
                    <th>Cabang</th>
            </thead>
            <tbody></tbody>
        </table>

        <table id="example" class="display" style="width:100%"></table>
        <button type="Button" value="Add" name="Add" onClick="addData()">Add</button>
        <button type="button" value="Del" name="Del" onClick="delData()">Del</button>
        <button type="button" value="Save" name="Save" onClick="saveData()">Save</button>
        <div class=" style1"><strong>Keterangan</strong> : Menu untuk memanage data karyawan (Untuk input baru, nama divisi kosongkan saja)</div>
        </td>
        <input id="idDinilaiCopy" name="idDinilaiCopy" type="hidden" />
        <input type='text' name='lastId' />
        <input type='hidden' name='lastId_1' />
        <input type='hidden' name='lastId_2' />
        <input type='hidden' name='lastId_3' />
        <input type="text" id="lastIdTable">
        <textarea name="buffer" id="buffer" cols="50" rows="3">tse</textarea>

    </form>



</body>

</html>