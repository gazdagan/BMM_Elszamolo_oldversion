<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemlogClass
 *
 * @author Andras
 */
class SystemlogClass {
    //put your code here
    private $logname;
    private $logtext;
    
    public function __construct($logname,$logtext) {
        $this->logname = $logname;
        $this->logtext = $logtext;
    }
    
    public function writelog(){
        $returntxt = "";
        $db_connect = DbConnect();
        
        $sql_insert = "INSERT INTO user_log (user_name, log_txt)
                VALUES (' $this->logname','$this->logtext')";
        
        
        if ($db_connect->query($sql_insert) === TRUE) {
            $returntxt = "New log created successfully";
        } else {
        $returntxt = "Error: " . $sql . "<br>" . $conn->error;
        }         
    return $returntxt;    
    }
    
    
}
