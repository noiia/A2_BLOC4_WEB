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
            }
        })
        .catch(error => {
            alert("Une erreur s'est produite lors de la suppression :", error);
        });
}

function openOnInternship(focusedId) {
    document.location.href = "../Stage?id=" + focusedId;
}