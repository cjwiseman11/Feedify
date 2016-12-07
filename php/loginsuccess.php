<?php
session_start();
if(isset($_SESSION['feedifyusername'])){
   echo "cheese";
} else {
    echo "no cheese";
}

var_dump($_SESSION);
?>