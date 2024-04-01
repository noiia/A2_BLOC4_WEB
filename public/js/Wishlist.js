$(document).ready(function(){
    var Value = 3;
    var PHPfiles = "Wishlist.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $(".main_left").append(response);
    })
})

function delInternshipFromWishlist(focusedElementId) {
    fetch("https://inter-net.loc/Wishlist/delete/" + focusedElementId, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then(response => {
            if (response.ok) {
                document.location.href = "../Wishlist";
            } else {
                alert("La suppression a échoué.");
                console.log(focusedElementId)
            }
        })
        .catch(error => {
            alert("Une erreur s'est produite lors de la suppression :", error);
        });
}

function openOnInternship(focusedId) {
    document.location.href = "../Stage?id=" + focusedId;
}