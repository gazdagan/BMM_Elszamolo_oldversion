<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1>Házipénztár pénztárbizonylatok javítása.</h1>
<div class ="container">
<div class="well">
<form  class="form-inline" action="index.php?pid=page35" method="POST">
    <div class="form-group">
        <label for="jav_biz_id">Pénztárbizonylat száma:</label>
        <div class="radio">
            <label class="radio-inline"><input type="radio" name="jav_biz_tipus" value = "bevetel" checked> Bevételi </label>
        </div>
        <div class="radio">
            <label class="radio-inline"><input type="radio" name="jav_biz_tipus" value ="kiadas"> Kiadási </label>
        </div>
        <input type="text"  class="form-control" placeholder="00000" name="jav_biz_id" id="jav_biz_id">
    </div>
  
    <button type="submit" class="btn btn-default">Javításhoz kikeres</button>
</form>
</div>
<div id="jav_biz">
    
    
</div>    
    
    
<div>
