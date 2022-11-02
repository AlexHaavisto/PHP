<?php

    require_once "inc/header.php";
    require_once "inc/database.php";

    if(!empty($_POST)){
        
        // luetaan lomakkeen tiedot
        $nimi = $_POST['nimi'];
        $kuvaus = $_POST['kuvaus'];
        $genre = $_POST['genre'];
        $ikaraja = $_POST['ikaraja'];
        $kesto = $_POST['kesto'];
        $julkaisupaiva = $_POST['julkaisupaiva'];
        $tuotantovuosi = $_POST['tuotantovuosi'];
        $ohjaaja = $_POST['ohjaaja'];
        $nayttelijat = $_POST['nayttelijat'];
        $kuva = basename($_FILES['kuva']['name']);

        // kenttien virhetekstit
        $virheIlmoitus = array();
        $virheIlmoitus['nimi'] = 'Tarkista nimi';
        $virheIlmoitus['kuvaus'] = 'Tarkista kuvaus';
        $virheIlmoitus['genre'] = 'Tarkista genre';
        $virheIlmoitus['ikaraja'] = 'Tarkista ikäraja';
        $virheIlmoitus['kesto'] = 'Tarkista kesto';
        $virheIlmoitus['julkaisupaiva'] = 'Tarkista julkaisupäivä';
        $virheIlmoitus['tuotantovuosi'] = 'Tarkista tuotantovuosi';
        $virheIlmoitus['ohjaaja'] = 'Tarkista ohjaaja';
        $virheIlmoitus['nayttelijat'] = 'Tarkista näyttelijät';
        $virheIlmoitus['kuva'] = 'Tarkista kuva';

        // alustetaan virheilmoitukset
        foreach($_POST as $key => $value){
            $muuttuja = $key . 'Error'; // luodaan dynaaminen muuttuja
            ${$muuttuja} = '';
        }

        // oletaan, että käyttäjä syöttänyt kaikki tiedot oikein
        $valid = true;

        // tarkistetaan ovatko lomakkeen kentät tyhjiä
        foreach( $_POST as $key => $value ){
            if( empty( $value ) ){
                $valid = false;
                $muuttujaNimi = $key . 'Error';
                $$muuttujaNimi = $virheIlmoitus[$key];
            }
        }

        if(empty($kuva)){
            $kuvaError = $virheIlmoitus['kuva'];
        }

        if($valid){

            // ladataan kuva img-kansioon
            $tmpName = $_FILES['kuva']['tmp_name'];
            move_uploaded_file($tmpName, 'img/' . $kuva);

            $sql = "INSERT INTO video (nimi, kuvaus, genre, ikaraja,  kesto, julkaisupaiva, tuotantovuosi, ohjaaja, nayttelijat, kuva)
            VALUES  (:nimi, :kuvaus, :genre, :ikaraja,  :kesto, :julkaisupaiva, :tuotantovuosi, :ohjaaja, :nayttelijat, :kuva)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':nimi', $nimi, PDO::PARAM_STR);
            $stmt->bindParam(':kuvaus', $kuvaus, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
            $stmt->bindParam(':ikaraja', $ikaraja, PDO::PARAM_INT);
            $stmt->bindParam(':kesto', $kesto, PDO::PARAM_INT);
            $stmt->bindParam(':julkaisupaiva', $julkaisupaiva, PDO::PARAM_STR);
            $stmt->bindParam(':tuotantovuosi', $tuotantovuosi, PDO::PARAM_INT);
            $stmt->bindParam(':ohjaaja', $ohjaaja, PDO::PARAM_STR);
            $stmt->bindParam(':nayttelijat', $nayttelijat, PDO::PARAM_STR);
            $stmt->bindParam(':kuva', $kuva, PDO::PARAM_STR);

            $stmt->execute();

            header("Location: video.php");
            exit;
        }
    }

?>
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card card-body bg-light mt-3">
                <h3>Lisää video</h3>

                 <form action="" method="post" enctype="multipart/form-data">
   
                    <?php 
                        echo luoInputKentta('Nimi', 'nimi', $nimi??'', $nimiError??'', 'text');
                        
                        echo luoTextareaKentta('Kuvaus', 'kuvaus', $kuvaus??'', $kuvausError??'');

                        echo luoInputKentta('Genre' , 'genre', $genre??'', $genreError??'', 'text');
                    
                        echo luoInputKentta('Ikäraja' , 'ikaraja', $ikaraja??'', $ikarajaError??'', 'text');

                        echo luoInputKentta('Kesto' , 'kesto', $kesto??'', $kestoError??'', 'text');

                        echo luoInputKentta('Julkaisupäivä' , 'julkaisupaiva', $julkaisupaiva??'', $julkaisupaivaError??'', 'date');

                        echo luoInputKentta('Tuotantovuosi' , 'tuotantovuosi', $tuotantovuosi??'', $tuotantovuosiError??'', 'text');

                        echo luoInputKentta('Ohjaaja' , 'ohjaaja', $ohjaaja??'', $ohjaajaError??'', 'text');

                        echo luoInputKentta('Näyttelijät' , 'nayttelijat', $nayttelijat??'', $nayttelijatError??'', 'text');

                        echo luoInputKentta('Kuva' , 'kuva', $kuva??'', $kuvaError??'', 'file');
                    ?>

                    <button class="btn btn-primary" type="submit">Tallenna</button>
                    <a href="video.php" class="btn ">Takaisin</a>
                 </form>   

            </div>
        </div>
    </div>
    
<?php
    require_once "inc/footer.php";