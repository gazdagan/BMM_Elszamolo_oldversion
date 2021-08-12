<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require './includes/HirlevelClass.php';
echo '<script>';
include ("./js/ajax.js");
include ("./js/hirlevel.js");
echo '</script>';

$hirlevel = new HirlevelClass();
echo $hirlevel -> Create_New_Hirlevel();

echo $hirlevel->SelectNewsList();

echo "<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  </script>";
