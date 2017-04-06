<?
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
?>
<html>
 <head>
  <meta charset="utf-8">
  <title>Редактирование</title>
 </head>
 <body>
    <h1> Редактирование </h1>
    <form method="post" action="save.php?id=<?=$id?>" enctype="multipart/form-data">
        
   <p>ФИО: <input type = "text" name = "fio"  value = "<?=$resOnDB['fio'];?>"> </p>

   <h3>Дата рождения:</h3>
   <p><input type="date" name = "birth" value="<?=date('Y-m-d',$resOnDB['birth']);?>"> </p>
   
   
   <h3>Фото:</h3>
   <img src="<?=$res['photo']?>" alt="альтернативный текст" > <br>
   <input type="hidden" name="MAX_FILE_SIZE" value="205000"/>
   <p>изменить фото</p><input name = "photo" type="file" />

   <p><input type="submit" value="сохранить изменения" name="edit"></p>
   <a href="index.php">На главную</a>
   
  </form>
 </body>
</html>