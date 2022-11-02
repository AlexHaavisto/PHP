<?php
  require_once  "inc/database.php";
  require_once "inc/header.php";

  if (!empty($_POST)){

    $sql = "DELETE FROM asiakas
            WHERE asiakasID = :asiakasID";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':asiakasID', $_POST['asiakasID'], PDO::PARAM_INT);
    $stmt->execute();

    header("Location: asiakas.php");

  } else {
    $asiakasID = $_GET['asiakasID'];

    $sql = "SELECT asiakasID, CONCAT(etunimi, ' ', sukunimi) AS nimi 
            FROM asiakas
            WHERE asiakasID = :asiakasID";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':asiakasID', $asiakasID, PDO::PARAM_INT);
    $stmt->execute();
    
    $asiakas = $stmt->fetch(PDO::FETCH_OBJ);

    if($asiakas === false){
      header("Location: asiakas.php");
    }
  }
    
?>
  <h3>Asiakastietojen poistaminen</h3>

  <p>Haluatko varmasti poistaa asiakkaan, <?php echo $asiakas->nimi; ?>, tiedot?</p>

  <form action="poista_asiakas.php" method="post">
    <input type="hidden" name="asiakasID" value="<?php echo $asiakas->asiakasID;?>">

    <button type="submit" class="btn btn-danger">Poista</button>
    <a href="asiakas.php" class="btn">Takaisin</a>

  </form>

<?php
  require_once "inc/footer.php";
?>