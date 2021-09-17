<html lang="fr">

<?php
$research = $_GET['research'];
?>

<head>
    <title>Google</title>
    <meta name="author" content="Amalaric Le Forestier" />
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/648738da98.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-light bg-light justify-content-end">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Gmail</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Images</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Application</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Profil</a>
            </li>
        </ul>
    </nav>

    <main>
        <form method="get" action="recherche.php" class="d-flex w-50 m-auto mt-2">
            <input class="form-control me-2 rounded-pill" type="search" name="research" placeholder="<?php echo $research; ?>" aria-label="Search" >
        </form>

    </main>

    <footer>
        <div class="fixed-bottom bg-secondary">
            <p class="text-light ps-lg-4 pt-3">France</p>
        </div>
        <div class="d-flex justify-content-between fixed-bottom bg-secondary text-light ps-lg-4 pe-4 pt-3">
            <ul class="list-inline">
                <li class="list-inline-item px-1">À propos</li>
                <li class="list-inline-item px-1">Publicité</li>
                <li class="list-inline-item px-1">Entreprise</li>
                <li class="list-inline-item px-1">Comment fonctionne la recherche Google ?</li>
            </ul>

            <ul class="list-inline">
                <li class="list-inline-item"><i class="fab fa-envira"></i> Neutre en carbonne depuis 2007</li>
            </ul>

            <ul class="list-inline">
                <li class="list-inline-item px-1">Info consommateurs</li>
                <li class="list-inline-item px-1">Confidentialité</li>
                <li class="list-inline-item px-1">Conditions</li>
                <li class="list-inline-item px-1">Paramètres</li>
            </ul>
        </div>
    </footer>
</body>

</html>


