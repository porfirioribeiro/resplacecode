<?php

    include 'std/String.php';
    
   
    $start = microtime(true); 

    for ($i = 0; $i <= 1000; $i++) { 

        strtoupper("My Test String | Porfirio's Klass"); 

    } 

    $end1 = microtime(true); 

 

    for ($i = 0; $i <= 1000; $i++) { 

        st("My Test String | Porfirio's Klass")->upperCase; 

    } 

    $end2 = microtime(true); 

 

    $difference1 = $end1 - $start; 

    $difference2 = $end2 - $end1; 

 
    print "PHP: $difference1 seconds.\nPorfirio: $difference2 seconds.";

    
    $GLOBALS

?>