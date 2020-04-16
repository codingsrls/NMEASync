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
$last_row=0;
$row_count=0;

for ($i=0;$i<count($fistfile_lines);$i++){
    $param1=explode(",",$fistfile_lines[$i]);
   
    //correction hours
    $param1[1]=$param1[1]+$firstfile_corretion_hours*10000;
    
    if($param1[0]=="$".$firstfile_identifier){
        //search timestamp
      
        $row_count=0;
        for($j=$last_row;$j<count($secondfile_lines);$j++){
        //foreach ($secondfile_lines as $secondfile_line){
           
           $param2=explode(",",$secondfile_lines[$j]);
           
           $param2[1]=$param2[1]+$secondfile_corretion_hours*10000;
          
           //se il primo valore ha un tempo troppo discordante
           
           
           if(floor($param2[1])>floor($param1[1]))
               break;
           
           
           
           if($param2[0]=="$".$secondfile_identifier){
                
                if(floor($param1[1])==floor($param2[1])){ //same timestamp
                   
                   $rows=array("NMEA1_".($i+1),"NMEA2_".($j+1));
                   $result=array_merge($param1,$param2,$rows);
                   
                 
                   
                   array_push($correlation, $result);
                   $last_row=$row_count+1;
                   //echo $last_row." \n";
                   
                   break;
                   
               }
               
               
               
                   
           }
           $row_count++;
        }
        
    }
}


?>





<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <title>NMEA Sync</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="jquery.numberedtextarea.css" rel="stylesheet" type="text/css">
    </head>
    
    
    
    <body class="container">
        
        
        <h1>NMEA Sync</h1>
        <h4>Correla due stringhe NMEA utilizzando il timestamp come riferimento</h4>
        <hr/>
        
        <div class="row">
            <div class="col-md-12">
                <form action="index.php" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

                    <div class="col-md-6">

                        <fieldset>
                            <legend>NMEA 1</legend>

                            <div class="form-group">
                                <div class="col-sm-2">
                                  <label for="firstfile" class="control-label">NMEA</label>
                                </div>
                                <div class="col-sm-10">
                                    <textarea name="firstfile" class="form-control" id="firstfile" placeholder="inserisci la tua stringa  NMEA qui..." rows="10" cols="30"><?php echo $firstfile;?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2">
                                  <label for="firstfile" class="control-label">Identificatore</label>
                                </div>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control required" required="required" name="firstfile_indentifier" placeholder="ex. GPGGA, GPRMC, ..." value="<?php if($firstfile_identifier) echo $firstfile_identifier;else "GPGGA";?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                  <label for="firstfile" class="control-label">Correzione orario</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control"  name="firstfile_corretion_hours" placeholder="ex. 0,1,2,..." value="<?php if($firstfile_corretion_hours) echo $firstfile_corretion_hours;else "2";?>">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">

                        <fieldset>
                            <legend>NMEA 2</legend>

                            <div class="form-group">
                                <div class="col-sm-2">
                                  <label for="secondfile" class="control-label">NMEA</label>
                                </div>
                                <div class="col-sm-10">
                                    <textarea name="secondfile" class="form-control" id="secondfile" placeholder="inserisci la tua stringa  NMEA qui..." rows="10" cols="30"><?php echo $secondfile;?> </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2">
                                  <label for="secondfile" class="control-label">Identificatore</label>
                                </div>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  name="secondfile_indentifier" placeholder="ex. GPGGA, GPRMC, ..." value="<?php if($secondfile_identifier) echo $secondfile_identifier;else "GPRMC";?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                  <label for="firstfile" class="control-label">Correzione orario</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control"  name="secondfile_corretion_hours" placeholder="ex. 0,1,2,..." value="<?php if($secondfile_corretion_hours) echo $secondfile_corretion_hours;else "0";?>">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    
                    
                    <div class="col-md-12 text-center">
                        <input class="btn btn-primary" type="submit" value="Calcola" />
                    </div>

                </form>
            </div>
            
            <?php if(count($correlation)):?>
            <div class="col-md-12">
                <h2>Valori calcolati</h2>
                <table class="table table-striped">
                    
                        <?php  
                    foreach ($correlation as $c1):
                        ?>
                        <tr>
                            <td>
                                <?php
                                    for($i=0;$i<count($c1);$i++){
                                        echo $c1[$i];
                                        if($i<(count($c1)-1))
                                            echo ",";
                                    }
                                    
                                ?>
                            </td>
                        </tr>
                    <?php                        endforeach;?>
                
                </table>  
                
                
            </div>
            <?php endif;?>
            
            
        </div>
        
        
        <script src="jquery.numberedtextarea.js"></script>
<script>
$('textarea').numberedtextarea();
</script>



    </body>
</html>
