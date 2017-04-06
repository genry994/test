<?php
header("Content-type: text/plain; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// Обработка запроса
//проверка на метод пост и на форму
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //получаем переменные
    $ageMax = filter_input(INPUT_POST, 'ageMax', FILTER_SANITIZE_NUMBER_INT);
    $ageMin = filter_input(INPUT_POST, 'ageMin', FILTER_SANITIZE_NUMBER_INT);
    
    $sexW = filter_input(INPUT_POST, 'sexW', FILTER_SANITIZE_STRING);
    $sexM = filter_input(INPUT_POST, 'sexM', FILTER_SANITIZE_STRING);
    
    $FIO = filter_input(INPUT_POST, 'fio', FILTER_SANITIZE_STRING);
    $keyWords = explode(' ', $FIO );
    
    $query = "SELECT id, fio, birth, sex, photo FROM worker ";
    //фильтр по ФИО
    switch (count($keyWords)){
        /*case 0:
            break;*/ 
        case 1:
            $query .= "WHERE fio LIKE '%$keyWords[0]%' ";
            break;
        case 2:
            $query .= "WHERE fio LIKE '%$keyWords[0]%' AND "
                . "fio LIKE '%$keyWords[1]%'";
            break;
        case 3:
            $query .= "WHERE fio LIKE '%$keyWords[0]%' AND "
                . "fio LIKE '%$keyWords[1]%'AND "
                . "fio LIKE '%$keyWords[2]%' ";
            break;
    }
    //фильтр по возрасту
    if(strlen($ageMax)){
        $max = time() - $ageMax*31556926;//возраст в секундах
        $query .= "AND birth > '$max' ";
    }
    
    if(strlen($ageMin)){
        $min = time() - $ageMin*31556926;//возраст в секундах
        $query .= "AND birth < '$min' ";
    }
    //фильтр по полу
    if($sexW == 'w' && $sexM == 'm'){
        //то ничего не добавлять
    }elseif($sexW == 'w'){// Ж
        $query .= "AND sex = '$sexW' ";
    }elseif($sexM == 'm'){// М
        $query .= "AND sex = '$sexM'";
    }//не попали, тож ничего не добавлять
    
    showTBody($query);
}

/**
 * выводит пол
 * @param type $str
 * @return string
 */
function ShowSex($str){
    if($str == w){
        return "<font color ='red'>жен</font>";
    }if ($str == m){
        return "<font color='blue'>муж</font>";
    }
}
/**
 * выводит возраст
 * @param type $intAge временная метка даты рождения
 * @return string  YYYY-MM-DD
 */
function showAge($intAge){
    if(!(int)$intAge){
        return "";
    }
    $age = date('Y') - date('Y',$intAge);
    return (int)$age;
}
/**
 * выводит сстылки на удалени и редактирование
 * @param type $id
 * @return type
 */
function showHref($id){
    return "<a href='delete.php?id=$id'>уд. </a> "
    . " <a href='edit.php?id=$id'>ред.</a>";   
}

function showTHead(){
    print('<div id="container"><table id="demo-foo-filtering" data-page-size="5" cellspacing="0" cellpadding="4" border="1">');
    echo htmlspecialchars("
   <thead><tr>
  <th>id</th>
  <th>Фото</th>
  <th>ФИО</th>
  <th>Возраст</th>
  <th>Пол</th>
  <th>Действие</th>
    </tr>
   </thead>   
  <tbody>");
}

function showTFoot(){
    echo htmlspecialchars('</tbody>'
            . '<tfoot>'
            . '<tr>'
            . '<td colspan="6"><p class="pagination"></p></td>'
            . '</tr>'
            . '</tfoot>'
            . '</table></div>');
}
/**
 * выводит тело таблицы
 * @param type $query запрос к бд после подстановки условий поиска
 */
function showTBody($query){
    if(file_exists("db.db")){
        $db = new SQLite3('db.db');
        $result = $db->query($query);
        //рисуем шапку
        showTHead();
        
        while ($res = $result->fetchArray(SQLITE3_ASSOC)){
        //рисуем таблицу результата
        echo htmlspecialchars("<tr>"
                . "<td>".$res['ID']."</td>"
                . "<td><div class='img'><a href='#'>"."<img class='img' width='25' height='10' src='".$res['photo']."'>"."</a></div></td>"
                . "<td>".$res['fio']."</td>"
                . "<td>".showAge($res['birth'])."</td>"
                . "<td>".ShowSex($res['sex'])."</td>"
                . "<td>".showHref($res['ID'])."</td>"
                . "</tr>");
        }
        $db->close();
        showTFoot();
    }
}