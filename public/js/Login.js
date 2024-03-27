function login() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    if(username !== "" && password !== ""){
        var json_data = {
            username: username,
            password: password
        };

        $.post("../Login/Auth", { json: JSON.stringify(json_data) }, function(response) {
            if (response.success) {
                console.log("succeed");
                document.location.href = "../Stage";
            } else {
                console.log("raté");
                document.location.href = "../Login";
            }
        }, 'json')
            .fail(function(xhr, status, error) {
                console.error("Statut de la requête : ", status);
                console.error("Réponse du serveur : ", xhr.responseText);
                console.error("Erreur : ", error);
                document.getElementById('error-zone').textContent = xhr.responseText;
                debugger;
            });
    } else {
        document.getElementById('error-zone').textContent = "Champs vide";
    }

}