<?php
// Kas submit nuppu update-by-ide lehel on vajutatud
if (isset($_POST["submit"])){
    $database->show($_POST); //Testimiseks - arrays näitab muudatust
    $id = $_POST["sid"];
    $name = $_POST["name"];
    $birth = $_POST["birth"];
    $salary = $_POST["salary"];
    $height = $_POST["height"];
    if(empty($salary)) {
        $salary = "NULL";
    }
    if(empty($height)) {
        $height = "NULL";
    }
    // alati peab olema tingimus, mida uuendada, et kõike üle ei kirjutaks
    $sql = "UPDATE simple SET
        name = ".$database->dbFix($name).",
        birth = ".$database->dbFix($birth).",
        salary = ".$salary.",
        height = ".$height.",
        added = added
        WHERE id = ".$id;

    // echo $sql; // testiks
    if($database->dbQuery($sql)) {
        $success = true;
        $_POST = array();
    } else {
        $success = false;
    }

}

?>
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>

        <div class="col-sm-8">
            <h3 class="text-center">Update - Kliki muutmisikoonil muutmiseks</h3>
            <?php
            // Kui toimus uuendamine (faili alguses olev if lause on tõene!)
            if (isset($success) && $success) {
                ?> 
                <div class="alert alert-success">
                    Sissekanne on uuendatud! 
                </div>
                <?php
    
            } else if(isset($success) && !$success) {
                ?> 
                <div class="alert alert-danger">
                    Sissekande uuendamine ei õnnestunud! 
                </div>
                <?php
            }
            
            // sql lause, päring ja if lause
            $sql = "SELECT * FROM simple ORDER BY added DESC";
            $res = $database->dbQuery($sql);
            if ($res !== false) {
            ?>
                <table class="table table-bordered table-striped table-hover mt-2">
                    <thead class="text-center">
                        <tr>
                            <th>Jrk</th>
                            <th>Nimi</th>
                            <th>Sünniaeg</th>
                            <th>Palk</th>
                            <th>Pikkus</th>
                            <th>Lisatud</th>
                            <th>Tegevus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // foreach-loop algab
                        foreach ($res as $key=>$val) {
                        $date = new DateTime($val["birth"]);
                        $birth = $date->format("d.m.Y");
                        $dateTime = new DateTime($val["added"]);
                        $added = $dateTime->format("d.m.Y H:i:s");
                        ?>
                            <tr>
                                <td class="text-end"><?php echo ($key + 1); ?>.</td>
                                <td><?php echo $val["name"]; ?></td>
                                <td><?php echo $birth; ?></td>
                                <td class="text-end"><?php echo $val["salary"]; ?></td>
                                <td class="text-end"><?php echo $val["height"]; ?></td>
                                <td><?php echo $added; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?page=hw_update-by-id&ids=<?php echo $val["id"]; ?>"><i class="fa-solid fa-pen-to-square text-warning" title="Edit"></i></a>
                                </td>
                            </tr>
                        <?php
                        // foreach-loop lõppeb
                    }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
            // if lause else
            ?>
                <p class="text-danger fs-4 text-center fw-bold">Isikuid ei leitud</p>
            <?php
            }// if lause lõppeb
            ?>
        </div>

        <div class="col-sm-2"></div>
    </div>
</div>