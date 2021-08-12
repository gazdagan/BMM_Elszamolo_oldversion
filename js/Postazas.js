/* 
 *számlák postázásának rögzítése post 
 */


function postAjax(url, data, success) {
    
     var params = typeof data == 'string' ? data : Object.keys(data).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
        ).join('&');

    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); 
        
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
}

function Postazas(id){
    console.log("postazas: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "add",
        date: ""
       };    
       
    postazas_date = 'postazas_date' + id;
  
    adatok.id_szamla = id;   
    adatok.date = document.getElementById(postazas_date).value;
    
    postAjax("./PostGetAjax/post_postazas.php", adatok, function(data){ console.log(data); });
   
   tabeledate = 'date' + id; 
   
   var d = new Date();
   var y = d.getFullYear();
   var m = d.getMonth()+1;
   if (m < 10) {m = '0' + m;}
   var d = d.getDate();
   
   document.getElementById(id).className = "info";
   document.getElementById(tabeledate).innerHTML = adatok.date;
   

}

function Postazas_torles (id){
    console.log("postazas_torlés: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "erease"
       };    
       
    adatok.id_szamla = id;   
    postAjax("./PostGetAjax/post_postazas.php", adatok, function(data){ console.log(data); });
    
    tabeledate = 'date' + id; 

    document.getElementById(id).className = "warning";
    document.getElementById(tabeledate).innerHTML = "";
           
    // window.location.reload();
}


function Bank_date(id){
    console.log("bank: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "add",
        date: ""
       };    
       
    postazas_date = 'bank_date' + id;
  
    adatok.id_szamla = id;   
    adatok.date = document.getElementById(postazas_date).value;
    
    postAjax("./PostGetAjax/post_bank.php", adatok, function(data){ console.log(data); });
   
   tabeledate = 'bank' + id; 
   
   var d = new Date();
   var y = d.getFullYear();
   var m = d.getMonth()+1;
   if (m < 10) {m = '0' + m;}
   var d = d.getDate();
   
   document.getElementById(id).className = "info";
   document.getElementById(tabeledate).innerHTML = adatok.date;
   

}

function Bank_torles (id){
    console.log("bank_torlés: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "erease"
       };    
       
    adatok.id_szamla = id;   
    postAjax("./PostGetAjax/post_bank.php", adatok, function(data){ console.log(data); });
    
    tabeledate = 'bank' + id; 

    document.getElementById(id).className = "warning";
    document.getElementById(tabeledate).innerHTML = "";
           
    // window.location.reload();
}


function erease_benyujta_date (id){
    
    console.log("recept benyújtás torlés: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "erease_benyujtas"
       };    
       
    adatok.id_szamla = id;   
    postAjax("./PostGetAjax/post_recept.php", adatok, function(data){ console.log(data); 
    feladas_date = 'benyujta_date_' + id;
    document.getElementById(feladas_date).value = '0000-00-00';
    });
    
}

function update_benyujta_date(id){
    
    console.log("recept benyujtas updaet: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "update_benyujtas",
        date: ""
       };    
    
    feladas_date = 'benyujta_date_' + id;
  
    adatok.id_szamla = id;   
    adatok.date = document.getElementById(feladas_date).value;
    
    postAjax("./PostGetAjax/post_recept.php", adatok, function(data){ console.log(data); });
    
}

function  erease_beerkezes_date(id){
    
    console.log("recept támogítás beérkezés torlés: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "erease_beerkezes"
       };    
       
    adatok.id_szamla = id;   
    postAjax("./PostGetAjax/post_recept.php", adatok, function(data){ console.log(data);
    
    feladas_date = 'berkezes_date_' + id;
    document.getElementById(feladas_date).value = '0000-00-00';
    });
    
}

function update_beerkezes_date(id){
    
    console.log("tamogatas beerkezes updaet: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "update_beerkezes",
        date: ""
       };    
    
    feladas_date = 'berkezes_date_' + id;
  
    adatok.id_szamla = id;   
    adatok.date = document.getElementById(feladas_date).value;
    
    postAjax("./PostGetAjax/post_recept.php", adatok, function(data){ console.log(data); });
    
}


function update_venyartamogatas(id){
    
     console.log("ártámogatás frissít: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "update_artamogatas",
        recept_artam: ""
       };    
    
    artamogatas = 'venytamogatas_' + id;
  
    adatok.id_szamla = id;   
    adatok.recept_artam = document.getElementById(artamogatas).value;
    
    postAjax("./PostGetAjax/post_recept.php", adatok, function(data){ console.log(data); });
    
    
}


function update_venyid(id){
    
     console.log("venyid frissít: ",id);
    
    var adatok = {
        id_szamla:"",
        event: "update_venyid",
        recept_id: ""
       };    
    
    venyid = 'receptid_' + id;
  
    adatok.id_szamla = id;   
    adatok.recept_id = document.getElementById(venyid).value;
    
    postAjax("./PostGetAjax/post_recept.php", adatok, function(data){ console.log(data); });
    
    
}



function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}


// Quick and simple export target #table_id into a csv
function download_table_as_csv(table_id) {
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            // Clean innertext to remove multiple spaces and jumpline (break csv)
            var data = cols[j].innerText; //.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
            if (data === null ){data = cols[j].getElementsByTagName("INPUT")[1].value ;}
            // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(','));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'vényes eladások_' + table_id + '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}