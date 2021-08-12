/* 
 *pénztárbizonylatot osszesítő js könyvtár
 *
 */

function bizonylat_kitolt(){
    console.log("hp bizonylat kitöltélse");
    // részösszegek összegzése
    
    var table_datas = "";
    var table = document.getElementById("penztar_bizonylat");
    var rows  = table.getElementsByTagName("TR");
    var sum_value = 0;
    var ertek = 0;
    var text;
    for (tr = 9; tr < rows.length - 3; tr++ ){
        
        
             ertek = rows[tr].getElementsByTagName("TD")[4].getElementsByTagName("INPUT")[0].value ;
             if (ertek === '') {ertek = 0;}
             sum_value +=  parseFloat(ertek);
     }
     //if (sum_value === '') {sum_value = 0;}
     
    
    
  
    document.getElementById("bizonylat_osszesen").value = kerekit(sum_value);
    document.getElementById("bizonylat_kerekites").value = sum_value - kerekit(sum_value);
    document.getElementById("bizonylat_foosszegszam").value = kerekit(sum_value);
    
    
    text = capitalizeFirstLetter(numberToSpell(kerekit(sum_value)));
    document.getElementById("bizonylat_foosszegszoveg").value = text;
    console.log("hp osszesen", sum_value,"-",text) ;
    
}

function kerekit(ertek){
    var kerekitett;
    kerekitett = ertek - (ertek%10);
   return (kerekitett); 
}

function today_date(ide){

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 

    //today = mm + '/' + dd + '/' + yyyy;
    today = yyyy + '.'+ mm + '.' + dd;
    //document.write.ide(today);
    console.log(today);
    document.getElementById(ide).value = today;
   
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}