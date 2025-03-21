<?php
include 'include/element.php';
//$header = "MIME-Version: 1.0\r\n";
//$header .= 'From: "Nom"<test@jalegreatdeal.fr>' . "\n";
//$header .= 'Content-Type: text/html; charset="utf-8"' . "\n";
//$header .= 'Content-Trasnfer-Encoding: 8bit';

//$message = "Salut";
//$mail = "admin@jalegreatdeal.fr";
//mail($mail, "Sujet", $message, $header);

if(isset($_POST["recherche"])){
    header("location:categorie.php?idcategorie=".$_POST["categorie"]."&recherche=".$_POST["recherchetext"]);
    //envoie vers la page categorie.php avec l'id de la catégorie et la recherche
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Accueil - MBM </title>
    <?php include 'include/header.php'; ?>
</head>
<body style="background-color: #f2edf3">
<div class="container-scroller">

    <?php include 'include/navigation.php'; ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper container">



                    <div class="grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="text-center">Les 20 annonces les plus vues </h2>
                                <div class="row product-item-wrapper mt-4">

                                    <?php foreach ($pdo->query("SELECT * from annonce order by vue desc LIMIT 20") as $tableau): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="action-holder">
                                                    <?php
                                                    $time = time();
                                                    $diff = $time - $tableau['time'];
                                                    if($diff < 604800): ?>
                                                    <div class="sale-badge bg-gradient-success">New</div>
                                                    <?php endif; ?>
                                                    <span class="favorite-button"><a href="<?php if(isset($uid)): ?> action_get.php?action=ajoutFavori&ida=<?= $tableau["ida"] 
                                                    ?>&idu=<?= $uid ?>&route=location:index.php<?php else: ?>connexion.php<?php endif; ?>">
                                                            <?php
                                                            if(isset($uid)){ ?>

                                                                    <?php
                                                                $verif = $pdo->prepare("SELECT * from favoris where ida = ? and idu = ?");
                                                                $verif->execute(array($tableau['ida'], $uid));
                                                                if($verif->rowCount() == 0){
                                                                    echo '<i style="color: #ff0000" class="fa-regular fa-heart"></i>';
                                                                }else{
                                                                    echo '<i style="color: #ff0000" class="fa-solid fa-heart"></i>';
                                                                }
                                                            }else{  ?>
                                                            <i style="color: #ff0000" class="fa-regular fa-heart"></i>
                                                            <?php } ?>
                                                        </a></span>
                                                </div>

                                                <div class="product-img-outer text-center">
                                                    <img class="product_image rounded" style="height: 300px; width: 300px" src="../<?= $tableau["photo"] ?>" alt="prduct image">
                                                </div>
                                                <p class="product-title"><?= $tableau["titre"] ?></p>
                                                <p class="product-price"><?= number_format($tableau["prix"], 0, ',', ' ')  ?> €</p>
                                                <p class="product-actual-price">
                                                    <?php if ($tableau["livraison"]==1): ?>
                                                    <span class="badge badge-pill badge-success">Livraison <i class="fa-solid fa-truck"></i></span>
                                                    <?php else: ?>
                                                    <span class="badge badge-pill badge-danger">Main propre <i class="fa-solid fa-handshake"></i></span>
                                                    <?php endif; ?>
                                                </p>
                                                <ul class="product-variation">
                                                        <?php if ($tableau["categorie"]==1): ?>
                                                        <span class="badge badge-primary">Romance <i class="fa-solid fa-heart mx-2"></i></span>
                                                        <?php elseif ($tableau["categorie"]==2): ?>
                                                        <span class="badge badge-warning">Thriller/Policier <i class="fa-solid fa-user-secret mx-2"></i></span>
                                                        <?php elseif ($tableau["categorie"]==3): ?>
                                                        <span class="badge badge-info">Science Fiction <i class="fa-solid fa-rocket mx-2"></i></span>
                                                        <?php elseif ($tableau["categorie"]==4): ?>
                                                        <span class="badge badge-danger">Développement personnel <i class="fa-solid fa-feather-pointed mx-2"></i></span>
                                                        <?php else: ?>
                                                        <span class="badge badge-success">Romans étrangers <i class="fa-solid fa-earth-europe mx-2"></i></span>
                                                        <?php endif; ?>
                                                </ul>
                                                <a href="detail.php?ida=<?= $tableau["ida"] ?>" class="btn btn-inverse-primary">Voir</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </div>

                    

                </div>


            </div>

            <?php include 'include/footer.php'; ?>

        </div>
    </div>
</div>

<?php include 'include/script.php'; ?>

</body>
</html>