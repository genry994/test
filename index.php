<html>
 <head>
    <script src="js/jquery.min.js"></script>
    <script src="js/footable.all.min.js"></script>
    <script src="js/jquery.footable.js"></script>
    <script src="js/testAnimate.js"></script>

  <meta charset="utf-8">
  <title>реестр</title>
    <style>
        .footable-page-arrow {
                display:inline;
                padding:5px;
        }	
        .footable-page {
                display:inline;
                padding:5px;
        }
    </style>
  <style type="text/css">
      /*стили для увеличения фото */
#container {
    text-align: center;
    margin: 0; 
    padding: 0;
}
.img {  
    
    margin: 0;
    padding: 0;
    position: fixed;
}
.img a img {
    
    border: none;
}
.clear {
    clear: both;
}
</style>
  <script>
    function XmlHttp(){
        var xmlhttp;
        try{
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e)
        {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } 
            catch (E) {xmlhttp = false;}
        }
        if (!xmlhttp && typeof(XMLHttpRequest)!=='undefined'){
            xmlhttp = new XMLHttpRequest();
        }
          return xmlhttp;
        }

    function ajax(param){
        if (window.XMLHttpRequest) req = new XmlHttp();
        
        method=(!param.method ? "POST" : param.method.toUpperCase());
           send="";
           for (var i in param.data) send+= i+"="+param.data[i]+"&";

        req.open(method, param.url, true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.send(send);
        req.onreadystatechange = function(){
            if (req.readyState == 4 && req.status == 200){ //если ответ положительный
                    if(param.success)param.success(req.responseText);
                }
        }
    }
    function setM(){
        if (document.getElementById("sexM").chechecked){
            document.getElementById("sexM").value = 'm';
        }
    }
    
    
  </script>
 </head>
 <body>
    <h1> Реестр сотрудников </h1> <a href="add.php">+добавить сотрудника </a>
    <h2> Поиск </h2>
    <form method="post" action="search.php" >
       <h3>ФИО: <input id="fio" type = "text" name = "fio" value = ""></h3>
   
       <h3>пол:<br></h3>
       <p>М <input id ="sexM" type = "checkbox" name="sex"  value= "" > </p>
       <p>Ж <input id ="sexW" type= "checkbox" name="sex"  value= "" > </p> 
       <input hidden id = "sex" value= "">
           
       <h3>возраст:<br></h3>
       <p>С <input id="ageMin" type="number" name= "ageMin" > <br> </p>
       <p>ПО <input id="ageMax" type="number" name= "ageMax" > <br> </p>

       <p><input type='button' value='Поиск' onclick='
            ajax({
               url:"search.php",
               statbox:"status",
               method:"POST",
               data:
               {
                  fio:document.getElementById("fio").value,
                  sexM:document.getElementById("sexM").value,
                  sexW:document.getElementById("sexW").value,
                  ageMin:document.getElementById("ageMin").value,
                  ageMax:document.getElementById("ageMax").value
               },
               success:function(data){
                   data = html_entity_decode(data);
                   document.getElementById("result").innerHTML = data;
                   
                test();
                testAnimate();
            }
               })'
       ></p>
    </form>
    <div id="result">
     
 </div>
    <script>
       var checkboxSexW = document.getElementById("sexW");
       var checkboxSexM = document.getElementById("sexM");
       checkboxSexW.onchange = function() {
       if(checkboxSexW.checked){
           checkboxSexW.value = 'w';
       }else{
           checkboxSexW.value = '';
       }
    };
       checkboxSexM.onchange = function() {
       if(checkboxSexM.checked){
           checkboxSexM.value = 'm';
       }else{
           checkboxSexM.value = '';
       }
    }; 
    
    function html_entity_decode(str) {

      var tarea=document.createElement('textarea'); // the "content" part is needed in buttons
      tarea.innerHTML = str;
      return tarea.value;
    }
    </script>

 </body>
</html>

    