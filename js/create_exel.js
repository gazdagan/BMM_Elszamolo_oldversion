/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){  
      $('#create_excel').click(function(){  
           var excel_data = $('#date_table').html();  
           var page = "excel.php?data=" + excel_data;  
           window.location = page;  
      });  
 });  

