<?php 
// Siia tuleb suurem ports PHP koodi aga kõik on loogiline
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
            <a class="page-link <?php echo ($pg == 1) ? "disabled" : null; ?>" href="index.php?pg=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link <?php echo ($pg == 1) ? "disabled" : null; ?>" href="index.php?pg=<?php echo (($pg - 1) == 0) ? "1" :($pg -1 ); ?>" aria-label="Previous">
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
                <a class="page-link <?php echo (($x + 1) == $pg) ? "active" : null; ?>" href="index.php?pg=<?php echo ($x + 1); ?>"><?php echo ($x + 1); ?></a>
            </li>
            <?php
        // for-loop lõpp
        }
        ?>
        <li class="page-item">
            <a class="page-link <?php echo ($pg >= $pageCount) ? "disabled" : null; ?>" href="index.php?pg=<?php echo (($pg + 1) > $pageCount) ? "$pageCount" :($pg + 1 ); ?>" aria-label="Next">
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link <?php echo ($pg >= $pageCount) ? "disabled" : null; ?>" href="index.php?pg=<?php echo $pageCount ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
