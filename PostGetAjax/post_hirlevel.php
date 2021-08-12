<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_POST["title"]) AND isset($_POST["publisher"]) AND isset($_POST["public_date"]) AND isset($_POST["publisd"]) AND isset($_POST["summernote"]) AND isset($_POST["hir_id"]) ){
    
    $conn = DbConnect();
    $title = test_input($_POST["title"]);
    $publisher = test_input($_POST["publisher"]);
    $public_date = test_input($_POST["public_date"]);
    $publisd = test_input($_POST["publisd"]);
    $summernote = $_POST["summernote"];
    $hir_id = test_input($_POST["hir_id"]);
    $writer = test_input($_POST["writer"]);
    
    $sql = "SELECT * FROM news WHERE news_id = '$hir_id'";
    
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // már van ilyen hír elkezdve  update 
            echo "UPDATE";
            $sql = "UPDATE news "
                    . "SET news_title='$title' , news_publisher ='$publisher', news_date='$public_date', news_publisd ='$publisd', news_content = '$summernote',news_writer='$writer'"
                   ."WHERE news_id = '$hir_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
            }
                
        } else {
            // még nincs ilyen id news INSERTINTO
            echo "INSERTINTO";
            $sql = "INSERT INTO news (	news_title, news_publisher, news_date,news_publisd,news_content,news_writer)
                               VALUES ('$title', '$publisher', '$public_date', '$publisd', '$summernote', '$writer')";

                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

            
        }
    
    
}

if ( $_SERVER['REQUEST_METHOD'] == 'DELETE'  ){
  
    $conn = DbConnect();
    
    parse_str(file_get_contents('php://input'), $_DELETE);
    //echo var_dump($_DELETE); //$_PUT contains put fields 
     
    $newsid = $_DELETE["news_id"];
   
    $sql = "UPDATE news SET news_deleted ='1' WHERE news_id='$newsid'";

        if ($conn->query($sql) === TRUE) {
            echo $newsid." Record updated successfully - deleted";
        } else {
            echo "Error updating record: " . $conn->error;
        }

   
    
}


if ( $_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET["news_id"])  ){
  
    $conn = DbConnect();
    
    $news_id= $_GET["news_id"];
     
    $sql = "SELECT * FROM news WHERE news_id = '$news_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                
                $news_data= json_encode($row);

            }
        } else {
            echo "0 results";
        }
        
    echo $news_data;
    
    $conn->close();

   
    
}


if ( $_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST["news_id"]) AND isset($_POST["reader"])  ){
  
    $conn = DbConnect();
    
    $reader = test_input($_POST["reader"]);
    $news_id = test_input ($_POST["news_id"]);
    
     $sql = "SELECT * FROM news_readers WHERE news_id = '$news_id' and reader_id = '$reader' ";
    
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // már van ilyen hír user olvasta
            
                
        } else {
            // még nincs ilyen user nem olvasta
            echo "INSERTINTO";
            $sql = "INSERT INTO news_readers ( news_id, reader_id )
                               VALUES ('$news_id', '$reader')";

                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

            
        }
    
    
    $conn->close();

   
    
}