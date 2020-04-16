<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$firstfile=$_POST['firstfile'];
$secondfile=$_POST['secondfile'];
$firstfile_identifier=$_POST['firstfile_indentifier'];
$secondfile_identifier=$_POST['secondfile_indentifier'];
$firstfile_corretion_hours=$_POST['firstfile_corretion_hours'];

$secondfile_corretion_hours=$_POST['secondfile_corretion_hours'];


//divide file in line

$fistfile_lines=  explode(PHP_EOL, $firstfile);
$secondfile_lines=  explode(PHP_EOL, $secondfile);

//for every line detect corrispondence
$correlation=array();

foreach ($fistfile_lines as $firstfile_line){
    $param1=explode(",",$firstfile_line);
    //correction hours
    $param1[1]=$param1[1]+$firstfile_corretion_hours*10000;
    
    if($param1[0]=="$".$firstfile_identifier){
        //search timestamp
      
   
        foreach ($secondfile_lines as $secondfile_line){
           $param2=explode(",",$secondfile_line);
           $param2[1]=$param2[1]+$secondfile_corretion_hours*10000;
           
          
           if($param2[0]=="$".$secondfile_identifier){
                
               
               if(round($param1[1])==round($param2[1])) //same timestamp
                   $newarray= array_merge($param1,$param2);
                   array_push($correlation, $newarray);
                   continue;
           }
        }
        
    }
}


?>

<html>
    
    <head>
        
    </head>
    <body>
        
            <?php  
            foreach ($correlation as $c1){
                for($i=0;$i<count($c1);$i++){
                    echo $c1[$i];
                    if($i<(count($c1)-1))
                        echo ",";
                }
                echo "\n";
            }
            
            ?>
        
        
        
    </body>
    
</html>
    


