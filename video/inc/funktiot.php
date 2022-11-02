<?php

function tarkistaHenkilotunnus($henkilotunnus){

    // Lisää tähän henkilötunnuksen tarkistus
    // palauta true tai false rippuen oliko se oikein

    $kuvio = '(^[0-2][0-9]|3[0-1])(0[0-9]|1[0-2])([0-9][0-9])([+A-])([[:digit:]]{3})([A-Z]|[[:digit:]])$';
    if (eregi($kuvio, $henkilotunnus, $tulos)) {
        $day=(int)$tulos[1];$month=(int)$tulos[2];
        if ($tulos[4]=='+')
            $vuosisata='18';
        if ($tulos[4]=='-')
            $vuosisata='19';
        if ($tulos[4]=='A')
            $vuosisata='20';
        $vuosi=$vuosisata.$tulos[3];
        $year=(int)$vuosi;
        if (checkdate($month, $day, $year)){
            $numerot=$tulos[1].$tulos[2].$tulos[3].$tulos[5];
            $luku = (int)$numerot;
            $jaannos=$luku % 31;
            $lista=array (10=>'A', 11=>'B', 12=>'C', 13=>'D', 14=>'E', 15=>'F', 16=>'H', 17=>'J', 18=>'K', 19=>'L',
            20=>'M', 21=>'N', 22=>'P', 23=>'R', 24=>'S', 25=>'T', 26=>'U', 27=>'V', 28=>'W', 29=>'X', 30=>'Y');
            if ($jaannos<10)
                $tarkistus = $jaannos;
            else $tarkistus=$lista[$jaannos];
            if ($tulos[6]==$tarkistus)
                return '';
            else return 'tarkistusmerkki ei täsmää';
        } else return 'päivämäärä ei kelpaa';
    }else return 'sotun pitää olla muotoa ppkkvv[+-A]nnnx';

    return false;
}

function tarkistaKirjautuminen(){

    if ( isset($_SESSION['kirjautunut']) &&  $_SESSION['kirjautunut'] === true){
        return true;
    } else {
        return false;
    }
}

function luoInputKentta( $otsikko, $muuttujaNimi, $muuttujaArvo, $virheKentta, $kentanTyyppi = 'text' ){

    $html = "";
    $invalid_feedback = "";
    $is_invalid = "";
    
    if( !empty( $virheKentta ) ){
        $is_invalid =  'is-invalid';

        $invalid_feedback = "<div class='invalid-feedback'>";
        $invalid_feedback .= "<small>$virheKentta</small>";
        $invalid_feedback .= "</div>";
    }
    
    $html .= "<div class='row mb-3'>";
    $html .= "<label for='$muuttujaNimi' class='col-sm-3 col-form-label'>$otsikko</label>";
    $html .= "<div class='col-sm-9'>";
    $html .= "<input type='$kentanTyyppi' name='$muuttujaNimi' value='$muuttujaArvo' class='form-control $is_invalid'>";
    $html .= $invalid_feedback;
    $html .= "</div>";
    $html .= "</div>";

    return $html;
}

function luoTextareaKentta( $otsikko, $muuttujaNimi, $muuttujaArvo, $virheKentta ){

    $html = "";
    $invalid_feedback = "";
    $is_invalid = "";
    
    if( !empty( $virheKentta ) ){
        $is_invalid =  'is-invalid';

        $invalid_feedback = "<div class='invalid-feedback'>";
        $invalid_feedback .= "<small>$virheKentta</small>";
        $invalid_feedback .= "</div>";
    }
    
    $html .= "<div class='row mb-3'>";
    $html .= "<label for='$muuttujaNimi' class='col-sm-3 col-form-label'>$otsikko</label>";
    $html .= "<div class='col-sm-9'>";
    $html .= "<textarea class='form-control $is_invalid' name='$muuttujaNimi' cols='30' rows='3'>$muuttujaArvo</textarea>";
    $html .= $invalid_feedback;
    $html .= "</div>";
    $html .= "</div>";

    return $html;
}
