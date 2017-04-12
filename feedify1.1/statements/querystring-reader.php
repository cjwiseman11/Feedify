<?php
    //Get current channel and save into variable
    if($_GET['chan']){
        $chan = $_GET['chan'];
    } else {
        $chan = "all";
    }

    if($_GET['lim']){
        $lim = $_GET['lim'];
    } else {
        $lim = "10";
    }

    if($_GET['p']){
        $page = $_GET['p'];
    } else {
        $page = "1";
    }


?>