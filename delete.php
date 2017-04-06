<?php
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    header("refresh: 5; url=index.php");
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(file_exists("db.db")){
        $db = new SQLite3('db.db');
        //удаляем файл
            $delFileName = "SELECT photo FROM worker WHERE id = '$id'";
            $result = $db->query($delFileName);
            $res = $result->fetchArray(SQLITE3_ASSOC);
            unlink($res['photo']);
        
        $query = "DELETE FROM worker WHERE id = '$id'";
        $db->query($query);
            echo "удалено <br>"
        . "через 5 секунд вы вернетесь на <a href='index.php'>На главную</a>";
    }
}
