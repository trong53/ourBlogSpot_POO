import Chart from 'chart.js/auto';
import { style_chart_handler } from './style_chart_handler.js';

if (document.querySelector('.abonnement-stat-graph')!=undefined) {

    let abonnement_stat_element = document.querySelector('.abonnement-stat-graph').getContext('2d');

    if (document.querySelector('.graph-container') != undefined) {
        let year = document.querySelector('#year').value;
        abonnement_stat_graphHandler(year);
        document.querySelector('.abonnement-stat-bar-chart').classList.add('selected-type');
    }

    function abonnement_stat_graphHandler (year) {
        fetch('/user-abonnement', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(year),
        })
        .then ((response)=>response.json())
        .then ((ajax_data)=>{
            
            if (ajax_data == 'no data') {
                document.querySelector('.annoncement').style.display = 'block';
            
            }else{
                document.querySelector('.annoncement').style.display = 'none';

                let barColors = ["rgb(253, 72, 72)", "rgb(218, 46, 3)", "rgb(252, 138, 31)", 
                "rgb(228, 149, 3)", "rgb(252, 229, 29)", "rgb(210, 247, 3)", 
                "rgb(80, 247, 3)", "rgb(3, 247, 145)", "rgb(3, 219, 247)", "rgb(3, 48, 247)", 
                "rgb(198, 3, 247)","rgb(247, 3, 154)"];

                let abonnement_stat_graph = new Chart(abonnement_stat_element, {
                    type: 'bar',
                    data: {
                        labels: ajax_data[0],
                        datasets: [{
                            label: 'number of articles',
                            data: ajax_data[1],
                            backgroundColor: barColors,
                            borderDash: [10, 5],
                            pointStyle: 'triangle',
                            pointRadius: 10
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right'
                            },
                        },
                        scales: {
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of subscriptions',
                                    font: {
                                        size: 15,
                                        family: 'tahoma',
                                        weight: 600,
                                    },
                                    color: 'rgb(16, 0, 104)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: "Months of year",
                                    font: {
                                        size: 15,
                                        family: 'tahoma',
                                        weight: 600,
                                    },
                                    padding: {
                                        top: 10
                                    },
                                    color: 'rgb(16, 0, 104)'
                                }
                            }
                        }
                    },
                    
                })   

                abonnement_stat_graph.data.datasets.forEach(dataset => {
                    dataset.data = ajax_data[1]
                    });
                    
                let Abon_barElement = document.querySelector('.abonnement-stat-bar-chart');
                let Abon_doughnutElement = document.querySelector('.abonnement-stat-doughnut-chart');
                let Abon_pieElement = document.querySelector('.abonnement-stat-pie-chart');
                let Abon_lineElement = document.querySelector('.abonnement-stat-line-chart');
                style_chart_handler(abonnement_stat_graph, Abon_barElement, Abon_doughnutElement, Abon_pieElement, Abon_lineElement);

                document.querySelector('#year').onblur = function(e) {
                    year = e.target.value;
                    fetch('/user-abonnement', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(year),
                    })
                    .then ((response)=>response.json())
                    .then ((ajax_data)=>{
                        document.querySelector('.annoncement').style.display = 'none';
                        abonnement_stat_graph.data.datasets.forEach(dataset => {
                            dataset.data = ajax_data[1]
                            });
                        abonnement_stat_graph.update();
                        if (ajax_data == 'no data') {
                            document.querySelector('.annoncement').style.display = 'block';
                        }
                        
                    })
                    
                }
            }
        })
    }

}
    