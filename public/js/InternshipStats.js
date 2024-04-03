function loadPage(filtre = []) {
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
                    let array = '0'.repeat(26).split('').map((x) => parseInt(x)); //array de 60 rempli de 0
                    for (let l of length) {
                        array[l] += 1;
                    }
                    areaChartArray.push({name: skill, data: array});
                }
            }
            // bar data
            let barChartArray = [];
            let barChartMap = new Map();
            

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
                            distance: -5,
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
            // promotions dessin            //nombre de stages en fonctions des compétences et des promotions
            Highcharts.chart('graph-prom', {
                chart: {type: 'column'},
                title: {
                    text: 'Nombre de stage selon les compétences et par promotion',
                },
                xAxis: {
                    categories: ['USA', 'China', 'Brazil', 'EU', 'India', 'Russia'],
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {text: 'Nombre de stages'}
                },
                tooltip: {valueSuffix: ' stages'},
                series: [
                    {
                        name: 'Corn',
                        data: [406292, 260000, 107000, 68300, 27500, 14500]
                    },
                    {
                        name: 'Wheat',
                        data: [51086, 136000, 5500, 141000, 107180, 77000]
                    }
                ]
            });
        })
}