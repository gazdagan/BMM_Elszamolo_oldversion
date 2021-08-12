/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function hirlevel_post(){
    console.log("hirlevel post data");
    
    var adatok = {
        title : "nincs",
        publisher : "nincs",
        public_date : "nincs",
        publisd : "",
        summernote : "",
        writer : "",
        hir_id  : ""
       };    
     
    
    adatok.title= document.getElementById("title").value;
    adatok.publisher = document.getElementById("publisher").value;    
    adatok.public_date =  document.getElementById("public_date").value;
    if( document.getElementById("publisd").checked === true ){adatok.publisd =1;} else{adatok.publisd =0;}
    
    adatok.summernote =  document.getElementById("summernote").value;
    adatok.hir_id = document.getElementById("hir_id").value;
    adatok.writer = document.getElementById("hir_íro").value;
    
   
    //új bejegyzés vagy upadte 
    postAjax("./PostGetAjax/post_hirlevel.php", adatok, function(data){ console.log(data); });
    
      
   
//    document.getElementById("title").value = "";
//    document.getElementById("publisher").value = ""; 
//    document.getElementById("public_date").value = "";
//      
//    $('#summernote').summernote('reset');
    
    location.reload();
}

function hirlevel_delete(news_id){
    
var adatok = {
        news_id : "0"
       
       }; 
       
adatok.news_id = news_id;  
deleteAjax("./PostGetAjax/post_hirlevel.php", adatok, function(data){ console.log(data); });
location.reload();    
}

function hirlevel_szerkeszt(news_id){
 
var get ="./PostGetAjax/post_hirlevel.php?news_id=" + news_id;



getAjax(get, function(data){  var json = JSON.parse(data);
        console.log(json);  

        document.getElementById("title").value = json.news_title;
        document.getElementById("publisher").value =  json.news_publisher;
        document.getElementById("public_date").value =  json.news_date;
        
        
        if (json.news_publisd.toString() == 1 ){document.getElementById("publisd").checked = true;} else {document.getElementById("publisd").checked = false;}
        
        document.getElementById("hir_id").readonly = false;
        document.getElementById("hir_id").value =  json.news_id;
         document.getElementById("hir_id").readonly = true;
        
        $('#summernote').summernote('reset');
        $('#summernote').summernote('code', json.news_content);

})


        
    
}

function olvastam(reader,news_id){
    
 console.log ("olvasta:",news_id,"-",reader);
 
  var adatok = {
        news_id : 0,
        reader : 0,
        acton : "read_news"
       };    
     
    
    adatok.news_id = news_id;
    adatok.reader = reader;
    
    var panelid = 'news_panel_'+ news_id;
    document.getElementById(panelid).classList.remove('panel-warning');
    document.getElementById(panelid).classList.add('panel-success');
    
    var readers = 'readers_' + news_id;
    var names = document.getElementById(readers).innerHTML + ' - ' + reader;
    document.getElementById(readers).innerHTML = names;
    
    //új bejegyzés vagy upadte 
    postAjax("./PostGetAjax/post_hirlevel.php", adatok, function(data){ console.log(data); });   
    
    //location.reload();
}