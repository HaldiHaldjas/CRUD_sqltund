<h2 class="text-center">Avaleht - Sirvi kogu tabelit</h2>

<?php 
// Paginate asemel
// loe kokku kirjed
$sql = "SELECT COUNT(id) AS total from simple;";
$res = $database->dbGetArray($sql);
// $database->show($res);
$total = $res[0]["total"];
// Tee sobilik päring tabelisse. Vaata koodi peale inlcude 'paginate.php' (näiteks homepage.php)
if($total > 0){

    if(isset($_GET["pg"])) {
        $pg = $_GET["pg"]; // urlit saadud lk number
    } else {
        $pg = 1;
    }
} else {
    $pg = 1;
}

$totalRows = $total;
$maxPerPage = MAXPERPAGE;
$pageCount = ceil($totalRows / $maxPerPage);

// Vigane pg väärtus 
if(empty($pg) || $pg < 1 || $pg > $pageCount) {
    $pg = 1; 
}

$nextStart = $pg * $maxPerPage;
$start = $nextStart - $maxPerPage;

?>
<nav aria-label="Page navigation">
    <ul class="pagination pagination-color justify-content-center">
    <li class="page-item">
            <a class="page-link <?php echo ($pg == 1) ? "disabled" : null; ?>" href="hw_index.php?pg=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link <?php echo ($pg == 1) ? "disabled" : null; ?>" href="hw_index.php?pg=<?php echo (($pg - 1) == 0) ? "1" :($pg -1 ); ?>" aria-label="Previous">
                <span aria-hidden="true">&lsaquo;</span>
            </a>
        </li>
        <?php 
        // for-loop algus
        // muudame number ühe ära 
        // numbri tagant siniseks - active
        for($x = 0; $x < $pageCount; $x++) {
            ?>
            <li class="page-item">
                <a class="page-link <?php echo (($x + 1) == $pg) ? "active" : null; ?>" href="hw_index.php?pg=<?php echo ($x + 1); ?>"><?php echo ($x + 1); ?></a>
            </li>
            <?php
        // for-loop lõpp
        }
        ?>
        <li class="page-item">
            <a class="page-link <?php echo ($pg >= $pageCount) ? "disabled" : null; ?>" href="hw_index.php?pg=<?php echo (($pg + 1) > $pageCount) ? "$pageCount" :($pg + 1 ); ?>" aria-label="Next">
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link <?php echo ($pg >= $pageCount) ? "disabled" : null; ?>" href="hw_index.php?pg=<?php echo $pageCount ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>


<?php

// sql lause, päring ja if lause
$sql = "SELECT * FROM simple ORDER BY added DESC LIMIT ".$start.", ".$maxPerPage;
// andmebaasi tulemus on $res
$res = $database->dbGetArray($sql);
if ($res !== false){
    // kontroll, kas näitab andmebaasi kirjeid - $database->show($res);a
?>

<table class="table table-hover table-bordered">
    <thead>
        <tr class="text-center">
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
        foreach($res as $key=>$val){
            $date = new DateTime($val["birth"]);
            $birth = $date->format("d.m.Y");
            $dateTime = new DateTime($val["added"]);
            $added = $dateTime->format("d.m.Y H:i:s");

        ?>
        <tr>
            <td class="text-end"><?php echo ($key + 1);?>.</td>
            <td>
                <?php echo $val["name"]; ?></td>
            <td class="text-center"> <?php echo $birth; ?></td>
            <td class="text-end"> <?php echo $val["salary"]; ?></td>
            <td class="text-end"> <?php echo $val["height"]; ?></td>
            <td class="text-end"> <?php echo $added; ?></td>
            <td>
                <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=hw_update" style="display: inline-block; margin-right: 10px;">
                    <i class="fa-solid fa-pen-to-square text-warning"></i>
                </a>
                <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=hw_delete" style="display: inline-block;">
                    <i class="fa-regular fa-trash-can text-danger"></i>
                </a>
            </td>

        </tr>
        <?php 
        }
        ?>
    </tbody>
</table>
<?php
} else {
    ?>
    <div class="alert alert-danger">Sobivaid kirjeid ei leitud</div>
    <?php
}
?>
