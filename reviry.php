<?php
require "database.php";
$storage = new database();
if(isset($_POST['cislo_reviru'])){
    $prem = $storage ->createRevir((int)$_POST['cislo_reviru'], $_POST['popis']);
   if(!$prem)
       echo "<script type='text/javascript'>alert('Revir uz existuje!');</script>";
}
$reviry = $storage->getAll();
$pom = false;
?>
<?php
        if (isset($_GET["opr"]) && (isset($_POST["nove_cislo_reviru"]) && isset($_POST["novy_popis"]) && $_GET["opr"] == "uprava")) {
            if($_POST["nove_cislo_reviru"] == $_GET["cisloReviru"] or $storage->kontrola($_POST["nove_cislo_reviru"])){
            $novy_revir= new Revir($_POST["nove_cislo_reviru"], $_POST["novy_popis"]);
            $pom = $storage->editRevir((int)$storage->getIdReviru($_GET["cisloReviru"]), $novy_revir);
            }
            $_GET = array();
            $_POST = array();
            if ($pom) {
                header("Location: reviry.php");
            } else echo "<script type='text/javascript'>alert('Revir uz existuje!');</script>";

    }
    if(isset($_GET["opr"]) && $_GET["opr"] == "vymazanie"){
        $storage ->mazanie($_GET["cisloReviru"]);
        $_GET = array();
        $_POST = array();
        header("Location: reviry.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stranka</title>
    <link   rel="stylesheet" href="Semestralka.css">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.5/examples/carousel/carousel.css">

    <script src="https://kit.fontawesome.com/e7858c52b6.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img alt="obrazok" width="40" height="40" src="https://i.pinimg.com/originals/e5/3b/4b/e53b4b19480f6d4562452e58c064734d.png"> Portál ryba
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.html">Domov <span class="sr-only">(current)</span></a>


            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menu
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="oNas.html">O stránke</a>
                    <a class="dropdown-item" href="reviry.php">Revíry</a>
                    <a class="dropdown-item" href="Kontakt.html">Kontakt</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid col-6 offset-3 mt-5 ">
    <form method="post">
        <label>Popis reviru</label>
        <div>
            <label for="cislo_reviru">Číslo revíru</label>
            <input type="number" name="cislo_reviru">
        </div>
        <div>
        <label for="popis">Text k reviru</label>
        <input type="text" name="popis">
        </div>
        <input type="submit" value="Odoslať">
    </form>
    <?php foreach ($reviry as $revir){ ?>
        <div>
            <h2><?=$revir->getCisloReviru()?></h2>
            <p><?= $revir->getPopis()?></p>
            <a href="<?= "?opr=uprava" . "&cisloReviru=" . $revir->getCisloReviru()?>" class="btn btn-link"><i class="fas fa-pencil-alt"></i> Edit</a>
            <a href="<?= "?opr=vymazanie" . "&cisloReviru=" . $revir->getCisloReviru()?>" class="btn btn-link"><i class="fas fa-minus"></i> Delete</a>
        </div>
<?php }
    if(isset($_GET["opr"]) && $_GET["opr"] == "uprava"){
?>
        <form method="post">
        <label>Uprava reviru</label>
        <div>
            <label for="cislo_reviru">Číslo revíru</label>
            <input type="number" name="nove_cislo_reviru">
        </div>
        <div>
        <label for="popis">Text k reviru</label>
        <input type="text" name="novy_popis">
        </div>
        <input type="submit" value="Upraviť">
    </form>
<?php
    }
?>
</div>
</body>
</html>