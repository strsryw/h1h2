<?php
include("../functions/koneksi.php");
include("../functions/function.php");


$mode = $_POST['mode'];


if (!empty($mode)) {

    if ($mode == 'retrieveData') {
        $query = "SELECT * FROM blog.contentBlog";
        $hsl = $dbCon->execute($query);
        foreach ($hsl as $data) {
            $txtData .= "<div class='col-md-3 panel panel-success' style='padding:5px;margin-left:10px;margin-right:10px;'>" . $data['content'] . "</div>";
        }
        echo $txtData;
    } else if ($mode == 'insertContent') {
        $content = $_POST['content'];
        try {
            $dbCon->execute("BEGIN");
            $queryInsert = "INSERT INTO blog.contentBlog(content) VALUES ('" . $content . "')";
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
