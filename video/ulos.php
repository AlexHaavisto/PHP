<?php
    // aloitetaan istunto
    session_start();

    // tuhotaan istunnon muuttujat
    $_SESSION = array();

    // tuhoteen istunto
    session_destroy();

    //ohjataan aloitussivulle
    header("Location: index.php");