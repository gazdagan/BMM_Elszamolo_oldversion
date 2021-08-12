<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BMMkartyaClass
 *
 * @author Andras
 */
class BMMkartyaClass {
    //put your code here

    
    
function addCardToPatient(){
       
    $html ='';
    $html = '<h2>Páciensenk kiadjuk a bmm kártyát<h2>';
    $html .='<form class="form-inline" ">
            <div class="form-group">
              <label for="paciensnev">Páciens neve:</label>
              <input type="text" class="form-control" id="paciensnev"  required>
            </div>
            <div class="form-group">
              <label for="paciensemail">Email:</label>
              <input type="email" class="form-control" id="paciensemail">
            </div>
            <div class="form-group">
              <label for="pwd">BMM Kártyára írt szám:</label>
              <input type="text" class="form-control" id="BMMkulsokarytaszam" placeholder="2012 591 901 015" required>
            </div>
             <div class="form-group">
              <label for="pwd">Kártyára csippantás:</label>
              <input type="text" class="form-control" id="BMMCardSerialNo" placeholder="klikk ide - és csippantás" required>
            </div>
            
        </form>';
    
    
    
  
    
    return $html;
}    
    
    
    
    
    
}
