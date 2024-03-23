function loadCompanyBubbleData(id = 1){
    fetch("https://inter-net.loc/Entreprise/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        const mainTemplate = document.getElementById("main-company");
        const bubbleContainer = document.getElementById("bubble-place");
        const bubbleTemplate = mainTemplate.content.cloneNode(true);

        bubbleTemplate.getElementById("Big-bubble-name").textContent = data.company;
        bubbleTemplate.getElementById("Big-bubble-location").textContent = data.zip_code + ' - ' + data.location;
        bubbleTemplate.getElementById("Big-bubble-number-student").textContent = data.number_former_intern + ' étudiants';
        bubbleTemplate.getElementById("rangeValue2").textContent = data.medium_rate;
        bubbleTemplate.getElementById("rangeInput2").value = data.medium_rate;
        bubbleTemplate.getElementById("Big-bubble-description").textContent = data.description;
        bubbleTemplate.getElementById("internship-number").textContent = data.number_of_internship + " stages disponibles:";
        //bubbleTemplate.getElementById("Big-bubble-logo").src = data.logo_path;
        bubbleContainer.append(bubbleTemplate);

        const miniInternshipTemplate = document.getElementById("mini-internship");
        const sectorTemplate = document.getElementById("sector-template");
        const commentTemplate = document.getElementById("comment-template");
        const sectorContainer = document.getElementById("container-company-details-sector-name-list");
        const internshipContainer = document.getElementById("mini-internship-container");
        const commentContainer = document.getElementById("comment-container");

        for (let sector of data.sector) {
            const cloneSectorTemplate = sectorTemplate.content.cloneNode(true);
            cloneSectorTemplate.getElementById("sector-ref").textContent = sector;
            sectorContainer.append(cloneSectorTemplate);
        }
        for (let internship of data.internship) {
            const cloneInternshipTemplate = miniInternshipTemplate.content.cloneNode(true);
            cloneInternshipTemplate.getElementById("internship-title").textContent = internship.title;
            cloneInternshipTemplate.getElementById("internship-location").textContent = "site de : " + internship.location;
            cloneInternshipTemplate.getElementById("internship-starting-date").textContent = "A partir du " + internship.starting_date;
            cloneInternshipTemplate.getElementById("internship-duration").textContent = internship.duration + " semaines";
            internshipContainer.append(cloneInternshipTemplate);
        }
        for (let comment of data.comment) {
            const cloneCommentTemplate = commentTemplate.content.cloneNode(true);
            cloneCommentTemplate.getElementById("comment-user").textContent = comment.user + " - " + comment.note + "/10";
            cloneCommentTemplate.getElementById("comment-description").textContent = comment.description;
            commentContainer.append(cloneCommentTemplate);
        }
    });
}
const runway = document.getElementById("runway-element")
var oldElement = 1;
loadCompanyBubbleData(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if(oldElement !== focusedBubble && focusedBubble > 0){
        document.getElementById("runway-container-intern-details").remove();
        loadCompanyBubbleData(focusedBubble);
        oldElement = focusedBubble;
    }
});
function input_filter(){
    document.getElementById("rangeValue").textContent = document.getElementById("rangeInput").value + "/10";
}

function toggle_bubulle(){
    document.querySelector(".container-intern-details").classList.toggle('close-tab-clicked');
    document.querySelector("body").classList.toggle('mobile-scroll');
}

window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        document.querySelector(".parent-filter").classList.remove('filter-mobile_on-filter');
        document.querySelector(".runway-container").classList.remove('filter-mobile_on-container');
    }
});

// ----------------------FIN JS SCRIPT STEPHAN BUBULLE-------------------------- -->
