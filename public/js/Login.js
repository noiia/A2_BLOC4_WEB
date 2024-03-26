function login() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    if(username !== "" && password !== ""){
        var json_data = {
            username: username,
            password: password
        };

        $.post("../Login/Auth", { json: JSON.stringify(json_data) }, function(response) {
            console.log("Réponse du serveur : ", response);
            if (response.success) {
                alert("Connexion réussie !");
            } else {
                alert("Échec de la connexion : " + response.error);
            }
        }, 'json')
            .fail(function(xhr, status, error) {
                console.error("Statut de la requête : ", status);
                console.error("Réponse du serveur : ", xhr.responseText);
                console.error("Erreur : ", error);
                alert("Erreur lors de la connexion : " + xhr.responseText);
            });
        document.getElementById('error-zone').textContent = "";
    } else {
        document.getElementById('error-zone').textContent = "Champs vide";
    }

}