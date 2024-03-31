function loadCompanyBubbleData(id = 1){
    fetch("https://inter-net.loc/Entreprise/api/" + id, {
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
        bubbleTemplate.getElementById("Big-bubble-logo").src = data.logo_path;
        bubbleContainer.append(bubbleTemplate);


        const miniInternshipTemplate = document.getElementById("mini-internship");
        const sectorTemplate = document.getElementById("sector-template");
        const commentTemplate = document.getElementById("comment-template");
        const skillTemplate = document.getElementById("skill-template");
        const sectorContainer = document.getElementById("container-company-details-sector-name-list");
        const internshipContainer = document.getElementById("mini-internship-container");
        const commentContainer = document.getElementById("comment-container");
        const skillContainer = document.getElementById("skill-container");

        console.log(data.sector);
        i = 0;
        for (let sector of data.sector) {
            const cloneSectorTemplate = sectorTemplate.content.cloneNode(true);
            console.log(i++);
            console.log(sector[0]);
            console.log(sector[1]);
            cloneSectorTemplate.getElementById("sector-ref-1").textContent = sector[0];
            if (sector[1] != null){
                cloneSectorTemplate.getElementById("sector-ref-2").textContent = sector[1];
            } else if (document.getElementById("sector-ref-2").textContent === null) {
                document.getElementById("sector-ref-2").remove()
                console.log("true");
            }
            sectorContainer.append(cloneSectorTemplate);
        }
        for (let internship of data.internship) {
            const cloneInternshipTemplate = miniInternshipTemplate.content.cloneNode(true);
            cloneInternshipTemplate.getElementById("test").href = 'https://inter-net.loc/Stage?ID_Internship='+internship.id;
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
        for (let skill of data.skill) {
            const cloneSkillTemplate = skillTemplate.content.cloneNode(true);
            cloneSkillTemplate.getElementById("skill").textContent = skill.name;
            skillContainer.append(cloneSkillTemplate);
        }
    });
}
const runway = document.getElementById("runway-element")
var oldElement = 1;
loadCompanyBubbleData(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    console.log(focusedBubble);
    if(oldElement !== focusedBubble && focusedBubble > 0){
        document.getElementById("runway-container-intern-details").remove();
        loadCompanyBubbleData(focusedBubble);
        oldElement = focusedBubble;
    }
});

//filtre

function load_filter(event = Event, idFilter = '') {
    if (event.key === 'Enter' || event instanceof PointerEvent) {
        const idToName = new Map([["input_localite", 'locations'], ['input_activity', 'sector']]);
        let input = document.getElementById(idFilter);
        console.log(idToName.get(idFilter));
        fetch("https://inter-net.loc/Entreprise/Filtre/" + idToName.get(idFilter) + '=' + input.value, {
            method: "GET",
            headers: {"Content-Type": "application/json",},
        })
            .then((response) => response.json())
            .then((data) => {
                for (let [id, name] of idToName) {
                    if (idFilter === id) {
                        add_filter_block(idFilter, data);
                        break;
                    }
                }
            });
    }
}

function input_filter(){
    document.getElementById("rangeValue").textContent = document.getElementById("rangeInput").value + "/10";
}

function submitFilter(event = Event) {
    let url = [];
    const filters_html = ["input_localite", "input_activity"];
    const filters_url = ["locations", "sector"];
    if (document.getElementById("general-search_bar").value !== '') {
        url.push('Name=' + document.getElementById("general-search_bar").value);
    }
    for (let f in filters_html) {
        let args = [];
        let values = document.getElementById(filters_html[f]).dataset.values;
        if (typeof values !== 'undefined' && values !== '') {
            args = document.getElementById(filters_html[f]).dataset.values.split(';');
            url.push(filters_url[f] + '=' + args.join(';'));
        }
    }
    let range = document.getElementById('rangeInput').value;
    if (range !== '1'){
        url.push('rates=' + range);
    }

    let min = document.getElementById('minimum-duration_internship').value;
    let max = document.getElementById('maximum-duration_internship').value;
    if (max !== '' || min !== '') {
        url.push('users=' + min + ';' + max);
    }
    console.log(url);
    document.location.href = '?' + url.join('&');
}

//fin filtre
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

function post_comment() {
    var companyId = Number(document.activeElement.id);
    //var userId = Number();
    var rate = Number(document.getElementById("rangeValue3").textContent);
    var comment = document.getElementById("comment-area").textContent;

    var json_data = {
        companyId : companyId,
        userId : userId,
        rate: rate,
        comment: comment
    };

    $.post("../Entreprise/addComment", { json: JSON.stringify(json_data) }, function(response) {
        console.log(response);
        },
        'json')
        .fail(function(xhr, status, error) {
            console.error(status);
            console.error(xhr.responseText);
            console.error(error);
        });
}