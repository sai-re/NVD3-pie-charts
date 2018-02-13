<?php

function filter($hostname, $db, $user, $pass) {

    $dbh2 = new PDO("mysql:host=$hostname; dbname=$db; charset=utf8", $user, $pass, array(PDO::ATTR_EMULATE_PREPARES => false,
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //query to grab all years 
    $sql = "SELECT DISTINCT year FROM data";

    $stmt = $dbh2->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

?>  
    <!--builds dropdown box for all years-->
    <select name="filter" class="calenderApp__dropdown__years">
       <option value="0">All</option>
        <?php while ($r = $stmt->fetch()):
            $year = $r["year"];
        ?>
            <option value="<?=$year?>">
                <?php echo $year ?>
            </option>
        <?php endwhile; ?>
    </select>

<?php } ?>
