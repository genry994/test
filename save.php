<?php
// Путь для картинок
$path = 'img/';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if(file_exists("db.db")){
    $db = new SQLite3('db.db');
    $query = "SELECT * FROM worker WHERE id = '$id'";
    $result = $db->query($query);
    if(!$resOnDB = $result->fetchArray(SQLITE3_ASSOC)){
        echo "несуществующий id";
    }
}
// Обработка запроса
//проверка на метод пост и на форму
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])){
    //$db = new SQLite3('db.db');
    $fio = filter_input(INPUT_POST, 'fio', FILTER_SANITIZE_STRING);
    if($fio !== $resOnDB['fio']){
        updateFIO($fio);
        echo"обнов ФИО";
    }
    $photo = strip_tags($path .$_FILES['photo']['name']);
    if($photo !== $path.$_FILES['photo']['tmp_name'] && strlen($photo)){
        updatePhoto($photo);
        echo"обнов фото";
    }
    $birth = filter_input(INPUT_POST, 'birth', FILTER_SANITIZE_NUMBER_INT);
    $birthTimestamp = strtotime($birth);
    if($birthTimestamp !== $resOnDB['birth']){
        updateBirth($birthTimestamp);
         echo "обнов дата";
    }
    echo "сохранено <br>"
        . "через 5 секунд вы вернетесь на <a href='index.php'>На главную</a>";
    //$db->close();       
}

function updateFIO($fio){
    global $db,$id;
    $query = "UPDATE worker SET fio = '$fio' WHERE ID = $id";
    $db->query($query); 
}
function updatePhoto($photo){
    global $db,$id,$path;
    $query = "UPDATE worker SET photo = '$photo' WHERE ID = $id";
    $db->exec($query); 
    // Загрузка файла и коирование в 
    if ( ($_FILES['photo']['error']) or !copy($_FILES['photo']['tmp_name'], $path . $_FILES['photo']['name'])){
        echo 'Что-то пошло не так';
        print_r($_FILES);
    }	
    else{
        echo 'Загрузка удачна';
        echo "<pre>";
        //print_r($_FILES);
        //print_r($_POST);
    }
    //конец загрузки
}
function updateBirth($birthTimestamp){
    global $db,$id;
    $query = "UPDATE worker SET birth = '$birthTimestamp' WHERE ID = $id";
    $db->exec($query); 
}