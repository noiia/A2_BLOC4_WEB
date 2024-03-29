function delInternshipFromWishlist(focusedElementId) {
    console.log('poubelle ' + focusedElementId)

    fetch("https://inter-net.loc/Wishlist/delete/" + focusedElementId, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
        },
    });
}

function openOnInternship(focusedId) {
    console.log(focusedId);
    document.location.href = "../Stage?id=" + focusedId;
}