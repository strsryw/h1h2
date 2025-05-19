<?php
include("../functions/koneksi.php");
// include("../functions/session.php");
include("../functions/function.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" href="../functions/style.css" rel="stylesheet" />
    <link type="text/css" href="../functions/jquery/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
    <link href="../functions/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../functions/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="../functions/bootstrap/js/bootstrap.min.js"></script>
    <script src="h1.js"></script>
    <style>
        .bungkus {
            width: 20%;
        }

        .toggle-symbol {
            float: right;
            /* Posisikan simbol di kanan */
            margin-left: 10px;
            /* Beri jarak dari teks */
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }


        ul li {
            border: 1px solid #ddd;
            margin-top: -1px;
            background-color: #f6f6f6;
            padding: 8px 10px;
            transition: background-color 0.9s ease;
            /* Transisi untuk animasi smooth */
        }

        ul li:hover {
            background-color: #eaeaea;
            /* Warna latar belakang berubah saat digulirkan */
        }

        ul ul li {
            padding-left: 40px;
        }

        ul ul ul li {
            padding-left: 60px;
        }

        ul ul ul ul li {
            padding-left: 80px;
        }

        ul ul ul ul ul li {
            padding-left: 100px;
        }

        ul .active {
            background-color: #ccc;
            /* Warna latar belakang aktif */
        }
    </style>
</head>

<body>
    <div class="bungkus" id="bungkus">
        <ul id="tampungList">
            <li onclick="toggleElement('satrio')" style="cursor: pointer;">Satrio Suryo Wibowo</li>
            <ul id="satrio" style="display: none;">
                <li>PT Bernofarm</li>
                <li onclick="toggleElement('historySatrio')" style="cursor: pointer;">History Pendidikan</li>
                <ul id="historySatrio" style="display: none;">
                    <li>SD N Mranggen 1</li>
                    <li>SMP N 14 Semarang</li>
                    <li>SMA N 2 Semarang</li>
                    <li>Universitas Dian Nuswantoro</li>
                </ul>
            </ul>
            <li onclick="toggleElement('bagus')" style="cursor: pointer;">Bagus</li>
            <ul id="bagus" style="display: none;">
                <li>PT Bernofarm</li>
            </ul>
        </ul>
    </div>
    <script>
        function toggleElement(elementId) {
            var element = document.getElementById(elementId);
            var symbol = document.getElementsByClassName('toggle-symbol'); // Ambil elemen simbol
            if (element.style.display === 'none') {
                element.style.display = 'block'; // Jika elemen disembunyikan, tampilkan elemen
                element.classList.add('active'); // Tambahkan kelas 'active'
                for (let i = 0; i < symbol.length; i++) {
                    symbol[i].textContent = "-";
                }
            } else {
                element.style.display = 'none'; // Jika elemen ditampilkan, sembunyikan elemen
                element.classList.remove('active'); // Hapus kelas 'active'
                for (let i = 0; i < symbol.length; i++) {
                    symbol[i].textContent = ">";
                }
            }
        }
    </script>
</body>

</html>