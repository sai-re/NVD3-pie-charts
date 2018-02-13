<?php
    session_start();
    //when reset is pressed remove session variables
    unset($_SESSION['start'], $_SESSION['end'], $_SESSION['year'], $_SESSION['lineYear']);
?>
