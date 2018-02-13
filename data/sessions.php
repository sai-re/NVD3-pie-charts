<?php
    session_start();
    //checks if post values are set from front-end ajax
    if (isset($_POST['start'],$_POST['end']) || isset($_POST['years'])) {
        //attaches post values to session        
        $_SESSION['start'] = $_POST['start'];
        $_SESSION['end'] = $_POST['end'];
        $_SESSION['year'] = $_POST['years'];
    }
?>