<?php 
    require_once "inc/header.php";
    require_once "inc/database.php";

    if( $_SERVER['REQUEST_METHOD'] == "POST" ){

        // luetaan tiedot lomakkeelta
        $tunnus = $_POST['kayttajatunnus'];
        $salasana = $_POST['salasana'];

        // alustetaan virheilmoitukset
        $tunnusError = '';
        $salasanaError = '';

        // oletetaan, että tiedot oikein
        $valid = true;

        if(empty($tunnus)){
            $valid = false;
            $tunnusError = "Syötä käyttäjätunnus";
        }

        if(empty($salasana)){
            $valid = false;
            $salasanaError = "Syötä salasana";
        }

        if( $valid ){

            $sql = "SELECT myyjaID, salasana
                    FROM myyja
                    WHERE kayttajatunnus = :tunnus";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam( ':tunnus', $tunnus, PDO::PARAM_INT );
            $stmt->execute();

            $myyja = $stmt->fetch( PDO::FETCH_OBJ );

            //var_dump($myyja);
            // tarkistetaan, että salasana on oikein
            if( password_verify( $salasana, $myyja->salasana )){
                
                // nyt me voidaan määrittää istuntokohtaisia muuttujia
                $_SESSION['kirjautunut'] = true;
                $_SESSION['myyjaID'] = $myyja->myyjaID;
                $_SESSION['tunnus'] = $tunnus;

                header( "Location: asiakas.php" ); 
                exit;
            } else {
                $salasanaError = "Tarkista salasana";
                $tunnusError = "Tarkista käyttäjätunnus";
            }

        }
    }
?>

<div class="row">
    <div class="col-8 mx-auto">
        <div class="card card-body bg-light mt-3">
            <h3>Kirjaudu</h3>

            <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post">

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="kayttajatunnus">Käyttäjätunnus</label>
                    <div class="col-sm-9">
                        <input type="text" name="kayttajatunnus" 
                        value="<?php echo ( !empty( $tunnus ) )? $tunnus: ''; ?>" id="inputKayttajatunnus" class="form-control 
                        <?php echo (!empty($tunnusError))?'is-invalid':''; ?>" >
                        <div class="invalid-feedback">
                            <small><?php echo $tunnusError; ?></small>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="salasana">Salasana</label>
                    <div class="col-sm-9">
                        <input type="password" name="salasana" id="inputSalasana"
                        value="<?php echo ( !empty( $salasana ) )? $salasana: ''; ?>"  class="form-control <?php echo (!empty($salasanaError))?'is-invalid':''; ?>">
                        <div class="invalid-feedback">
                            <small><?php echo $salasanaError; ?></small>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Kirjaudu</button>
        
            </form>
        </div>
    </div>
</div>

<?php
    require_once "inc/footer.php";