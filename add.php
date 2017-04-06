<?php
// Путь для картинок
$path = 'img/';
//типы файлов
$types = array('image/gif', 'image/png', 'image/jpeg');
//размер
$sizeMAX = 200000;

// Обработка запроса
//проверка на метод пост и на форму
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form'] )){
    //получаем переменные
    $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $patronymic = filter_input(INPUT_POST, 'patronymic', FILTER_SANITIZE_STRING);
    $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);

    $photo = strip_tags($path .$_FILES['photo']['name']);
    // Загрузка файла и коирование 
    // поверка на тип и размер
    if($_FILES['photo']['size'] > 0){
        if ( $_FILES['photo']['error'] or
                !in_array($_FILES['photo']['type'], $types) or
                $_FILES['photo']['size'] > $sizeMAX or
                !copy($_FILES['photo']['tmp_name'], $path . $_FILES['photo']['name'])){
            
            echo 'загрузка не удалась ';
            $photo="";
        }else{
        echo 'Загрузка удачна';
        }
    }
    
    $birth = filter_input(INPUT_POST, 'birth', FILTER_SANITIZE_NUMBER_INT);
    $birthTimestamp = strtotime($birth);
    //если файла БД нет, то создадим её и таблицу в ней worker(рабочие)
    if(!file_exists("db.db")){
        $db = new SQLite3('db.db');
        $sql="CREATE TABLE worker(
            ID INTEGER PRIMARY KEY AUTOINCREMENT,
            fio TEXT,
            sex TEXT,
            photo TEXT,
            birth INTEGER
        )";
        $db->query($sql);
    }else{
    //если бд есть
       $db = new SQLite3('db.db');
    }
    $query = "INSERT INTO worker (fio, sex, photo, birth)"
            . " VALUES ('$name $surname $patronymic', '$sex', '$photo', '$birthTimestamp')";
    $db->exec($query);
    $db->close();
}
?>
<html>
 <head>
  <meta charset="utf-8">
  <title>добавление нового сотрудника</title>
 </head>
 <body>
    <h1> Создание сотрудника </h1>
    <form method="post" enctype="multipart/form-data">
        
        <p>Фамилия: <input required type = "text" name = "surname"  value = ""> </p>
   <p>Имя: <input required type = "text" name = "name"  value = ""> </p>
   <p>Отчество: <input type = "text" name = "patronymic" value = ""> </p>
   
   
   <h3>Дата рождения:</h3>
   <p><input required type="date" name = "birth"  ></p>
   
   <h3>Пол:</h3>
   <p><select  name="sex">

    <option value="m">муж</option>
    <option value="w">жен</option>
   </select></p>
   
   <h3>Фото:</h3>
  
   <input name = "photo" type="file" />
   <p><input type="submit" value="добавить" name="form"></p>
   <a href="index.php">На главную</a>
   
  </form>
 </body>
</html>