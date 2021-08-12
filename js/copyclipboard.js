/* 
 elemeket vágólapra
 */


function copyClipboard(){
    var text = document.getElementById("riport");
    var range = document.createRange();
         
    range.selectNode(text);
    window.getSelection().addRange(range);
    document.execCommand('copy');
    
    
}

function copyClipboard1(){
    var text = document.getElementById("riport1");
    var range = document.createRange();
         
    range.selectNode(text);
    window.getSelection().addRange(range);
    document.execCommand('copy');
    
    
}