<?php
  require_once "inc/database.php";
  require_once "inc/header.php";
?>
      <div class="row">
        <h3>Videotiedot</h3>
      </div>
      <div class="row">
        <p>
          <a href="lisaa_video.php" class="btn btn-success">Lisää</a>
        </p>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nimi</th>
              <th>Genre</th>
              <th>Kuva</th>
              <th>Toiminto</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM video";
              $result = $pdo->query($sql);

              while($row = $result->fetch()): ?>
                <tr>
                  <td> <?php echo $row['videoID']; ?> </td>
                  <td> <?php echo $row['nimi']; ?> </td>
                  <td> <?php echo $row['genre']; ?> </td>
                  <td> <img src="img/<?php echo $row['kuva']; ?>" alt="<?php echo $row['nimi']; ?>" width="50"> </td>
                  <td><a href="poista_video.php?videoID=<?php echo $row['videoID']; ?>" class="btn btn-danger">Poista</a> 
                
                  <a href="paivita_video.php?videoID=<?php echo $row['videoID']; ?>" class="btn btn-success">Päivitä</a>

                  <a href="katso_video.php?videoID=<?php echo $row['videoID']; ?>" class="btn">Katso</a>

                </td>
                </tr>
              <?php endwhile;

              unset($result);
              unset($pdo);
            ?>
          </tbody>
        </table>
      </div>

<?php
  require_once "inc/footer.php";
?>