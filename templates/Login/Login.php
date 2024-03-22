<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="../../Assets/Icones/logo_seul_blanc.png">
    <link rel="stylesheet" href="output.css">
    <title>Inter'net - Login</title>
</head>

<body>
    <div class="container-login">
        <img src="../../Assets/Icones/logo_seul_blanc.png" class="logo" alt="logo">
        <form class="bottomelements" action="../Welcome/Welcome.php" method="POST">
            <h1 class="title-username">Nom d'utilisateur</h1>
            <div>
                <input class="tb-login" type="text" class="username" name="username" placeholder="Nom d'utilisateur">
            </div>
            <h1 class="title-password">Mot de passe</h1>
            <div>
                <input class="tb-password" type="password" class="password" name="password" placeholder="Mot de passe">
            </div>
            <input class="connexion-btn" type="submit" value="Connexion">
        </form>
    </div>
    <script>
        const usernameInput = document.querySelector('.tb-login');
        const passwordInput = document.querySelector('.tb-password');
        var loginValue = false;
        var passwValue = false;
        usernameInput.addEventListener('input', function () {
            const connexionBtn = document.querySelector('.connexion-btn');
            if (this.value.trim() === '' && (passwValue === false && loginValue === false)) {
                connexionBtn.classList.add('connexion-btn-hidden');
                loginValue = true;
            } else {
                connexionBtn.classList.remove('connexion-btn-hidden');
                loginValue = false;
            }
        });
        passwordInput.addEventListener('input', function () {
            const connexionBtn = document.querySelector('.connexion-btn');

            if (this.value.trim() === '' && (passwValue === false && loginValue === false)) {
                connexionBtn.classList.add('connexion-btn-hidden');
                passwValue = true;
            } else {
                connexionBtn.classList.remove('connexion-btn-hidden');
                passwValue = false;
            }
        });
    </script>
</body>
<!-- '1', 'mmanchester0', 'gX6)v+U$5V', 'Jennine', 'Myrwyn', '2002-05-31', 'Passionné de développement web et d innovation technologique.', 'mphilpott0@eventbrite.com', '3', '0' -->

</html>