<?php
include("../functions/koneksi.php");
include("../functions/function.php");


$mode = $_POST['mode'];


if (!empty($mode)) {

    if ($mode == 'retrieveData') {
        $n = 1;
        $query = "SELECT * FROM blog.contentBlog";
        $hsl = $dbCon->execute($query);
        foreach ($hsl as $data) {
            $id = $data['id'];
            $txtData .= "<tr>
                <td>" . $n . "</td>
                <td id='txtContent" . $id . "'>" . $data['content'] . "</td>
                <td>
                    <button class='btn btn-primary' onclick=\"editData(" . $id . ")\">Edit</button>
                    <button class='btn btn-danger' onclick=\"hapusData(" . $id . ")\">Hapus</button>
                </td>
            </tr>";
            $n++;
        }
        echo $txtData;
    } else if ($mode == 'updateContent') {
        $id = $_POST['id'];
        $content = $_POST['content'];
        try {
            $dbCon->execute("BEGIN");
            $queryInsert = "UPDATE blog.contentBlog SET content = '" . $content . "' WHERE id = $id";
            $hsl = $dbCon->execute($queryInsert);
            if ($hsl) {
                echo 'sukses';
            }
            $dbCon->execute("COMMIT");
        } catch (Exception $e) {
            var_dump($e->getTrace());
            $dbCon->execute("ROLLBACK");
        }
    } else if ($mode == 'deleteContent') {
        $id = $_POST['id'];
        try {
            $dbCon->execute("BEGIN");
            $queryInsert = "DELETE FROM blog.contentBlog WHERE id = $id";
            $hsl = $dbCon->execute($queryInsert);
            if ($hsl) {
                echo 'sukses';
            }
            $dbCon->execute("COMMIT");
        } catch (Exception $e) {
            var_dump($e->getTrace());
            $dbCon->execute("ROLLBACK");
        }
    }
}
