function load_filter(event = Event, idFilter = '') {
    if (event.key === 'Enter' || event instanceof PointerEvent) {
        let input = document.getElementById('input_skills');
        fetch("https://inter-net.loc/StatistiquesStages/Filtre/" + input.value, {
            method: "GET",
            headers: {"Content-Type": "application/json",},
        })
            .then((response) => response.json())
            .then((data) => {
                add_filter_block("input_skills", data);
                let values = input.dataset.values;
                let args = [];
                if (typeof values !== 'undefined' && values !== '') {
                    args = values.split(';');
                }
                load_page(args);
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
            break;
        }
        i++;
    }
}

function load_page(filtre = []) {
    //filtre = [1, 5, 4];
    let lien = "https://inter-net.loc/StatistiquesStages/api/";
    if (filtre.length === 0) {
        lien += "*";
    } else {
        lien += filtre.join(';');
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
            //format -> {tot:26, stages:{'JS':[stage1, stage2, ...], 'PHP':[stage2, stage9, ...]}; /!\ peut avoir le même dans JS et PHP
            //camambert data
            let pieChartMap = new Map();
            Object.keys(data.stages).forEach((skill) => {
                pieChartMap.set(skill, data.stages[skill].length);
            });
            let pieChartArray = Array.from(pieChartMap);
            pieChartArray = pieChartArray.sort((a, b) => b[1] - a[1]);
            let i = 2;
            while (pieChartArray.slice(0, i).map((x) => x[1]).reduce((a, b) => a + b, 0) < 0.85 * data.total && i <= pieChartArray.length) {
                i++;
            }
            let j = pieChartArray.length;
            while (j > i) {
                j -= 1;
            }
            let autre = data.total - pieChartArray.map((x) => x[1]).reduce((a, b) => a + b, 0);
            pieChartArray.push(['Autres', autre]);
            //area data
            let areaChartArray = [];
            let areaChartMap = new Map();
            Object.keys(data.stages).forEach((skill) => {
                areaChartMap.set(skill, data.stages[skill].map((x) => x['duree']));
            })
            if (filtre.length === 0) {
                let array = '0'.repeat(26).split('').map((x) => parseInt(x)); //array de 60 rempli de 0
                for (let [skill, length] of areaChartMap) {
                    for (let l of length) {
                        array[l] += 1;
                    }
                }
                areaChartArray = [{name: 'Tous', data: array}];
            } else {
                for (let [skill, length] of areaChartMap) {
                    let array = new Array(26).fill(0);
                    for (let l of length) {
                        array[l] += 1;
                    }
                    areaChartArray.push({name: skill, data: array});
                }
            }
            // bar data
            let barChartMap = new Map();
            let barChartMap2 = new Map();
            Object.keys(data.stages).forEach((skill) => {
                barChartMap.set(skill, data.stages[skill].map((x) => x['promotion']));
            })
            console.log(barChartMap);
            if (filtre.length === 0) {
                let arrayProm = [];
                let arrayValue = [];
                for (let [skill, promotions] of barChartMap) {
                    for (let p of promotions) {
                        if (!arrayProm.includes(p)) {
                            arrayProm.push(p);
                            arrayValue[arrayProm.indexOf(p)] = 1;
                        } else {
                            arrayValue[arrayProm.indexOf(p)] += 1;
                        }
                    }
                }
                barChartMap2.set('promotions', arrayProm);
                barChartMap2.set('values', [{name: 'Tous', data: arrayValue}]);
            } else {
                let barArray = [];
                let arrayProm = [];
                for (let [skill, promotions] of barChartMap) {
                    let arrayValue = new Array(arrayProm.length).fill(0);
                    for (let p of promotions) {
                        if (!arrayProm.includes(p)) {
                            arrayProm.push(p);
                            arrayValue[arrayProm.indexOf(p)] = 1;
                        } else {
                            arrayValue[arrayProm.indexOf(p)] += 1;
                        }
                    }
                    barArray.push({name: skill, data: arrayValue});
                }
                barChartMap2.set('promotions', arrayProm);
                barChartMap2.set('values', barArray);
            }
            // camambert dessin
            Highcharts.chart('graph-skill', {
                chart: {
                    type: 'pie',
                },
                title: {
                    text: 'Repartition des compétences',
                },
                tooltip: {
                    valueSuffix: '%',
                    formatter: function () {
                        let txt = 'Stage: <i>' + this.point.name + '</i><br>';
                        txt += '<b>' + this.point.y + '</b> (' + (this.point.y / data.total) * 100 + '%) stages ayant cette compétence';
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
            // time dessin
            Highcharts.chart('graph-time', {// nb de stage par rapport à la durée
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Durée des stages'
                },
                xAxis: {
                    allowDecimals: false,
                    title: {text: 'Durée du stage'},
                },
                yAxis: {
                    title: {text: 'nombre de stage'},
                },
                tooltip: {
                    pointFormat: "<b>{point.y}</b> stages avec la compétence '<i>{series.name}</i>' ont une durée de <b>{point.x}</b> semaines"
                },
                plotOptions: {
                    area: {
                        pointStart: 0,
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {hover: {enabled: true}}
                        }
                    }
                },
                series: areaChartArray,
            });
            // promotions dessin
            Highcharts.chart('graph-prom', {//nombre de stages en fonctions des compétences et des promotions
                chart: {type: 'column'},
                title: {
                    text: 'Nombre de stage selon les compétences et par promotion',
                },
                xAxis: {
                    categories: barChartMap2.get('promotions'),
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {text: 'Nombre de stages'}
                },
                tooltip: {valueSuffix: ' stages'},
                series: barChartMap2.get('values')
            });
        })
}



