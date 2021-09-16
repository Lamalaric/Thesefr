<!DOCTYPE html>
<html lang="FR">

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
            <div class="container d-flex flex-column justify-content-center align-items-center h">
                <div class="row h-100 mt-5 mb-4 ">
                    <div class="text-center">
                        <img src="images/google.png" class="img-fluid mx-auto" alt="Google image">
                    </div>
                </div>
                <form method="get" action="recherche.php" class="d-flex w-50 m-auto">
                    <input class="form-control me-2 rounded-pill" type="search" name="research" placeholder="" aria-label="Search" >
                </form>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                    <button class="btn btn-secondary">Recherche Google</button>
                    <button class="btn btn-secondary">J'ai de la chance</button>
                </div>
                <p class="mt-5 d-md-flex justify-content-md-center">Google disponnible en : <a href=""> English</a></p>
            </div>
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
