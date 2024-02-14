<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="../../Assets/Icones/logo_seul_blanc.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="output.css" rel="stylesheet">
    <title>Inter'net - Accueil</title>
</head>


<!-- header -->

<?php
session_start();

$ProfilValue = "";
$ProfilLink = "";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $ProfilValue = $username;
} else {
    $username = "";
    $ProfilLink = 'href="../Login/login.php"';
    $ProfilValue = "Profil";
}
?>


<header>
    <nav class="navbar">
        <img src="../../Assets/Icones/logo_blanc_entier.png" alt="company-logo" class="navbar-logo">
        <img src="../../Assets/Icones/logo_seul_blanc.png" alt="mini-company-logo" class="mini-navbar-logo">
        <div class="navbar-links">
            <ul>
                <li>
                    <a href="">
                        <span aria-hidden="true">Stages</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span aria-hidden="true">Entreprises</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span aria-hidden="true">Statistiques</span>
                    </a>
                </li>
                <li>
                    <a <?php echo $ProfilLink ?>>
                        <span aria-hidden="true">
                            <?php echo $ProfilValue ?>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <img class="navbar-hamburger" src="../../Assets/Icones/hamburger.png" alt="hamburger">
    </nav>
</header>


<!-- ! body -->


<body>
    <div class="full-runway">
        <div class="parent-filter">
            <div class="filter">
                <div class="search_bar">
                    <input type="search" placeholder="Rechercher" id="general-search_bar">
                    <button type="button" id="general-button_search"><img src="../../Assets/Icones/logo_seul.png"
                            alt="V" /></button>
                </div>
                <div class="filter-green">
                    <div class="filter-location">
                        <div class="filter-any_search-top">
                            <p>Localité :</p>
                            <div class="search_bar">
                                <input type="search" placeholder="Rechercher">
                                <button type="button"><img src="../../Assets/Icones/logo_seul.png" alt="V" /></button>
                            </div>
                        </div>
                        <div class="filter-any_search-bot">
                            <ul>
                                <li>Location 1</li>
                                <li>Loc 2</li>
                            </ul>
                            <ul>
                                <li>Loc 3</li>
                                <li>Loc 4</li>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-skills">
                        <div class="filter-any_search-top">
                            <p>Compétences :</p>
                            <div class="search_bar">
                                <input type="search" placeholder="Rechercher">
                                <button type="button"><img src="../../Assets/Icones/logo_seul.png" alt="V" /></button>
                            </div>
                        </div>
                        <div class="filter-any_search-bot">
                            <ul>
                                <li>Compétence 1</li>
                                <li>comp 2</li>
                            </ul>
                            <ul>
                                <li>comp 3</li>
                                <li>comp 4</li>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-start_internship">
                        <div class="filter-any_search-top">
                            <p>Debut de l'offre :</p>
                        </div>
                        <div class="filter-any_search-bot">
                            <div class="search_min-max">
                                <label for="minimum_start_internship">Minimum</label>
                                <input type="date" id="minimum_start_internship" inputmode="numeric" />
                            </div>
                            <div class="search_min-max">
                                <label for="maximum_start_internship">Maximum</label>
                                <input type="date" id="maximum_start_internship" inputmode="numeric" />
                            </div>
                        </div>
                    </div>
                    <div class="filter-duration_internship">
                        <div class="filter-any_search-top">
                            <p>Durée du stage :</p>
                        </div>
                        <div class="filter-any_search-bot">
                            <div class="search_min-max">
                                <label for="minimum-duration_internship">Minimum</label>
                                <input type="number" id="minimum-duration_internship" inputmode="numeric" min="0"
                                    max="26" placeholder="de 0 à 26 semaines" />
                                <!--min à 0 et max à 26 car la loi l'impose-->
                            </div>
                            <div class="search_min-max">
                                <label for="maximum-duration_internship">Maximum</label>
                                <input type="number" id="maximum-duration_internship" inputmode="numeric" min="0"
                                    max="26" placeholder="de 0 à 26 semaines" />
                            </div>
                        </div>
                    </div>
                    <div class="filter-company">
                        <div class="filter-any_search-top">
                            <p>Entreprises :</p>
                            <div class="search_bar">
                                <input type="search" placeholder="Rechercher">
                                <button type="button"><img src="../../Assets/Icones/logo_seul.png" alt="V" /></button>
                            </div>
                        </div>
                        <div class="filter-any_search-bot">
                            <ul>
                                <li>Entreprise 1</li>
                                <li>Entrep 2</li>
                            </ul>
                            <ul>
                                <li>Entrep 3</li>
                                <li>Entrep 4</li>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-promotion">
                        <div class="filter-any_search-top">
                            <p>Niveau d'études :</p>
                        </div>
                        <div class="filter-any_search-bot">
                            <div class="search_range">
                                <input type="range" min="0" max="8" step="1" id="rangeInput" value="0">
                                <span id="rangeValue">Bac+0</span>
                            </div>
                        </div>
                    </div>
                    <div class="filter-max_places">
                        <div class="filter-any_search-top">
                            <p>Nombre de places :</p>
                        </div>
                        <div class="filter-any_search-bot">
                            <div class="search_min-max">
                                <label for="minimum-max_places">Minimum</label>
                                <input type="number" id="minimum-max_places" inputmode="numeric" min="0"
                                    placeholder="nombre de place" />
                            </div>
                            <div class="search_min-max">
                                <label for="maximum-max_places">Maximum</label>
                                <input type="number" id="maximum-max_places" inputmode="numeric" min="0"
                                    placeholder="nombre de place" />
                            </div>
                        </div>
                    </div>
                    <div class="filter-postulation">
                        <div class="filter-any_search-top">
                            <p>Nombre de-postulation :</p>
                        </div>
                        <div class="filter-any_search-bot">
                            <div class="search_min-max">
                                <label for="minimum-postulation">Minimum</label>
                                <input type="number" id="minimum-postulation" inputmode="numeric" min="0"
                                    placeholder="nombre de postulation" />
                            </div>
                            <div class="search_min-max">
                                <label for="maximum-postulation">Maximum</label>
                                <input type="number" id="maximum-postulation" inputmode="numeric" min="0"
                                    placeholder="nombre de postulation" />
                            </div>
                        </div>
                    </div>
                    <div class="filter-hourly_rate">
                        <div class="filter-any_search-top">
                            <p>Rémuneration à l'heure:</p>
                        </div>
                        <div class="filter-any_search-bot">
                            <div class="search_min-max">
                                <label for="minimum-hourly_rate">Minimum</label>
                                <input type="number" id="minimum-hourly_rate" inputmode="numeric" min="0"
                                    placeholder="en €" />
                            </div>
                            <div class="search_min-max">
                                <label for="maximum-hourly_rate">Maximum</label>
                                <input type="number" id="maximum-hourly_rate" inputmode="numeric" min="0"
                                    placeholder="en €" />
                            </div>
                        </div>
                    </div>
                    <div class="filter-validate">
                        <button type="button">Valider</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="runway-container">
            <div class="filter-mobile">
                <button type="button" class="filter-button">Filtrer</button>
            </div>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
            <button class="container" id="container">
                <span>
                    <div class="container-intern" id="container-intern">
                        <div class="container-div-para">
                            <h1 class="container-h1">Commercial H/F - Bac+2</h1>
                            <p class="container-paragraph">Orange - Reims</p>
                            <p class="container-paragraph">Début = 31/01/2024</p>
                            <p class="container-paragraph">3 semaines</p>
                            <div class="container-skills">
                                <ul>
                                    <li>Js</li>
                                    <li>Js</li>
                                    <li>Js</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </span>
            </button>
        </div>
    </div>
</body>

<link href="http://e0.extreme-dm.com/s9.g?login=daoudi&jv=n&j=y&srw=1920&srb=24&l=https%3A//www.adaoudi.com/">
<footer>
    <div class="footer-logo">
        <img src="../../Assets/Icones/logo_blanc_entier.png" alt="logo de l'entreprise" class="footer-logo-picture">
    </div>
    <div class="footer-society-list">
        <h1>Société</h1>
        <ul>
            <li>Condition d'utilisation</li>
            <li>Politique de confidentialité</li>
            <li>Politique de cookies</li>
            <li>Carrière</li>
            <li>A propos de nous</li>
        </ul>
    </div>
    <div class="footer-help-list">
        <h1>Aide</h1>
        <ul>
            <li>FAQs</li>
            <li>Nous contacter</li>
        </ul>
    </div>
    <div class="footer-image-list">
        <h1>Suis nous</h1>
        <ul>
            <a href="https://www.facebook.com">
                <li class="logo"><img src="../../Assets/Icones/logo_facebook.png" alt="logo facebook"></li>
            </a>
            <a href="https://www.instagram.com">
                <li class="logo"><img src="../../Assets/Icones/logo_insta.png" alt="logo instagram"></li>
            </a>
            <a href="https://www.youtube.com">
                <li class="logo"><img src="../../Assets/Icones/logo_ytb.png" alt="logo youtube"></li>
            </a>
            <a href="https://www.twitter.com">
                <li class="logo"><img src="../../Assets/Icones/logo_X.png" alt="logo X"></li>
            </a>
        </ul>
    </div>
</footer>

<script>
    var rangeInput = document.getElementById("rangeInput");
    var rangeValue = document.getElementById("rangeValue");
    rangeInput.addEventListener("input", function () { rangeValue.textContent = "Bac+" + this.value; });
</script>
<script>
    const filterShutter = document.querySelector(".filter-button")
    const filterMenu = document.querySelector(".parent-filter")
    const container = document.querySelector(".runway-container")

    filterShutter.addEventListener('click', () => { filterMenu.classList.toggle('filter-mobile_on-filter') })
    filterShutter.addEventListener('click', () => { container.classList.toggle('filter-mobile_on-container') })

    window.addEventListener("resize", () => {
        const widthScreen = window.innerWidth;
        if (widthScreen > 850) {
            filterMenu.classList.remove('filter-mobile_on-filter')
            container.classList.remove('filter-mobile_on-container')

        }
    });

    const menuHamburger = document.querySelector(".navbar-hamburger")
    const navbarLinks = document.querySelector(".navbar-links")

    menuHamburger.addEventListener('click', () => { navbarLinks.classList.toggle('mobile-menu') })
</script>

</html>