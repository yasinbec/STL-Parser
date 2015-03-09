<!--
Name: stlparse.php
Desc: ASCII STL File Parser
Comments: This php script will read .stl file and parse
Created By: Ali Beceren
Date: October 22, 2014
-->

<?php

function stl_parse ($filepath) {
    // Getting content from file
    $section = file_get_contents($filepath, NULL, NULL, 0);
    
    $findval='endfacet';
    // Counting all faces
    $count=substr_count($section, $findval);
    
    // Seperation for each facet into arrays
    $facet= split ("facet normal", $section); 
    
    // Getting the title from file
    $title=explode('solid', $facet[0]);
    $title=array('title'=>$title[1]);
        
    for($i=1; $i<=$count; $i++){
        
        // Getting Faces
        $findcenter[$i]=str_replace(strstr($facet[$i],"outer"),"",$facet[$i]);
    
        // Seperation for looping vertex
        $vertex[$i]= split ("vertex", $facet[$i]); 
        
        // Deleting empty first array key
        $vertex[$i] = array_slice($vertex[$i], 1, 3);
        
        // Cleaning for last Vertex array item
        $vertex[$i][2]=str_replace("endloop","",$vertex[$i][2]);
        $vertex[$i][2]=str_replace("endfacet","",$vertex[$i][2]);
        $vertex[$i][2]=str_replace("endsolid","",$vertex[$i][2]);
        $vertex[$i][2]=str_replace( $title[1],"",$vertex[$i][2]);
    
            // Vertex x y z seperation
            $x=explode(' ',$vertex[$i][0]);
                $x1=(float)$x[1]; 
                $x2=(float)$x[2];
                $x3=(float)$x[3];
            
            $y=explode(' ',$vertex[$i][1]);
            
                $y1=(float)$y[1];
                $y2=(float)$y[2];
                $y3=(float)$y[3];
            
            $z=explode(' ',$vertex[$i][2]);
            
                $z1=(float)$z[1];
                $z2=(float)$z[2];
                $z3=(float)$z[3];
                
            // Adding faces and Vertex x y z seperation
            $vertex[$i]=array('n'=>array('i'=>(float)$findcenter[$i],'j'=>(float)$findcenter[$i],'k'=>(float)$findcenter[$i]),
                              'v'=>array(
                              '1'=>array('x'=>$x1,'y'=>$x2,'z'=>$x3),
                              '2'=>array('x'=>$y1,'y'=>$y2,'z'=>$y3),
                              '3'=>array('x'=>$z1,'y'=>$z2,'z'=>$z3),
                              ));       
    }
    
    // Add them together
    $result = array_merge($title, $vertex); 
    
    // Change output to Human Readable format   
    echo '<pre>';
    
    // If you want json format
    //$out = array_values($result);
    //echo json_encode($out); 
    
    // Default Array Format
    print_r($result); 
    
    return stlparse;

}

// Calling stl_parse function
stl_parse('cube.stl');

?>
