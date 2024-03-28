$(document).ready(function () {
    var Value = "role";
    var PHPfiles = "WishList.php";
    data = {
        action: Value
    };
    $.post(PHPfiles, data, function (response) {
        $(".main_left").append(response);
    })
})

function delInternshipFromWishlist() {
    var focusedElementId = Number(document.activeElement.id);

    fetch("https://inter-net.loc/Wishlist/delete/" + focusedElementId, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
        },
    });
}