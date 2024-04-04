$(document).ready(function () {
    load_page()
});

function del_filter_block_internshipStats(event = Event, idInput) {
    event.currentTarget.hidden = true;
    let input = document.getElementById(idInput);
    let values = input.dataset.values.split(';');
    values.splice(values.indexOf(event.currentTarget.dataset.value), 1); //suprime la valeur souhaite
    if (idInput === 'input_sector') {
        load_page(values, 'sector');
    } else {
        load_page(values, 'city');
    }
}

function load_filter(event = Event, idFilter = '') {
    if (event.key === 'Enter' || event instanceof PointerEvent) {
        let input = document.getElementById(idFilter);
        let header = "";
        if (idFilter === "input_sector") {
            header = "sector=";
        } else if (idFilter === "input_city") {
            header = "city="
        }
        fetch("https://inter-net.loc/StatistiquesEntreprises/Filtre/" + header + input.value, {
            method: "GET",
            headers: {"Content-Type": "application/json",},
        })
            .then((response) => response.json())
            .then((data) => {
                let add = add_filter_block(idFilter, data);
                if (add) {
                    let values = input.dataset.values;
                    let args = [];
                    if (typeof values !== 'undefined' && values !== '') {
                        args = values.split(';');
                    }
                    load_page(args);
                } else {
                    alert("Si vous voulez ajouter une ville ou un secteur vous devez deja en supprimer une.")
                }
            });
    }
}


function add_filter_block(idInput, data) {
    let input = document.getElementById(idInput);
    let children = input.dataset.children;
    let i = 0;
    while (document.getElementById(children + i) !== null) {
        let li = document.getElementById(children + i);
        if (li.hidden) {
            let txt = document.querySelector('#' + children + i + ' > p');
            txt.textContent = data.name;
            input.value = '';
            //input.dataset.values = '';
            if (input.dataset.values === '' || typeof input.dataset.values == 'undefined') {
                input.dataset.values = data.id;
            } else {
                input.dataset.values = input.dataset.values + ';' + data.id;
            }
            txt.dataset.value = data.id;
            li.removeAttribute("hidden");
            console.log("recherche du filtre: '" + txt.textContent + "' dans " + idInput);
            return true; //à pu ajouter
        }
        i++;
    }
    return false; //n'a pas pu ajouter
}

function load_page(filtre = [], idFiltre = '') {
    let lien = "https://inter-net.loc/StatistiquesEntreprises/api/";
    if (filtre.length === 0) {
        lien += "*";
    } else {
        lien += idFiltre + "=" + filtre.join(';');
    }
    console.log(lien);
    //---avec api -> recup les stages avec compétences et le nb des autres
    fetch(lien, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            //format ->  /!\ peut avoir le même dans JS et PHP
            if (idFiltre === 'sector' || filtre.length === 0) {
                console.log('entre bien');
                document.getElementById('map-sector').src = "public/images/svg/Carte_remplie_departements_français_sectors.svg?timestamp=" + new Date().getTime();
                document.getElementById('var-nb_stages').textContent = data.total;
            }
            if (idFiltre === 'city' || filtre.length === 0) {
                //camambert data
                let pieChartMap = new Map();
                Object.keys(data.city).forEach((city) => {
                    pieChartMap.set(city, data.city[city]);
                });
                let pieChartArray = Array.from(pieChartMap);
                pieChartArray = pieChartArray.sort((a, b) => b[1] - a[1]);
                let i = 2;
                while (pieChartArray.slice(0, i).map((x) => x[1]).reduce((a, b) => a + b, 0) < 0.85 * data.total && i <= pieChartArray.length) {
                    i++;
                }
                let autre = data.total - pieChartArray.map((x) => x[1]).reduce((a, b) => a + b, 0);
                pieChartArray.push(['Autres', autre]);

                // camambert dessin
                Highcharts.chart('graph-city', {
                    chart: {
                        type: 'pie',
                    },
                    title: {
                        text: 'Repartition des entreprises',
                    },
                    backgroundColor: 'transparent',
                    tooltip: {
                        valueSuffix: '%',
                        formatter: function () {
                            let txt = 'Entreprise: <i>' + this.point.name + '</i><br>';
                            txt += '<b>' + this.point.y + '</b> (' + (this.point.y / data.total) * 100 + '%) d\' entreprise';
                            return txt;
                        }
                    },
                    plotOptions: {
                        series: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: [{
                                enabled: true,
                                distance: 10
                            }, {
                                enabled: true,
                                distance: -10,
                                format: '{point.percentage:.1f}%',
                                style: {
                                    fontSize: '0.75rem',
                                    textOutline: 'none',
                                    opacity: 0.7
                                },
                                filter: {
                                    operator: '>',
                                    property: 'percentage',
                                    value: 10
                                }
                            }]
                        }
                    },
                    series: [
                        {
                            colorByPoint: true,
                            data: pieChartArray
                        }
                    ]
                });
            }
        })
}

