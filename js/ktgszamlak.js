/* 
 *Költség számlákhoz tartozó js 
 */


function update_ktgpartner(ktg_partner_id){

    var adatok = {
        ktg_partner_id : "000000",
        ktg_partner_name : "",
        ktg_partner_adosz : "",
        ktg_partner_note : "" 
       };

    partner_name = 'partner_name_'+ ktg_partner_id;
    partner_adosz = 'partner_adosz_'+ ktg_partner_id;  
    partner_note = 'partner_note_'+ ktg_partner_id;  
    
    console.log("ktg partner update:", ktg_partner_id );

    adatok.ktg_partner_id = ktg_partner_id;
    adatok.ktg_partner_name = document.getElementById(partner_name).value;
    adatok.ktg_partner_adosz = document.getElementById(partner_adosz).value;
    adatok.ktg_partner_note = document.getElementById(partner_note).value;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_ktg_szamlak.php", adatok, function(data){ console.log(data);

        //document.getElementById("cardlog").innerHTML = data;

    });
}


function delete_ktgpartner(ktg_partner_id) {

    var adatok = {
                delete_ktg_partner_id : "000000"
       };
    adatok.delete_ktg_partner_id  = ktg_partner_id;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_ktg_szamlak.php", adatok, function(data){ console.log(data);
           //document.getElementById("cardlog").innerHTML = data;
           select_keszlet("ktg_partner");
    });



}