import Chart from 'chart.js/auto';
import { style_chart_handler } from './style_chart_handler.js';

if (document.querySelector('.active-users-graph')!=undefined) {

    let active_users_graph_element = document.querySelector('.active-users-graph').getContext('2d');

    if (document.querySelector('.graph-container') != undefined) {
        document.querySelector('.active-users-bar-chart').classList.add('selected-type');
        fetch('/active-users', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then ((response)=>response.json())
        .then ((data)=>{
            let barColors = ["rgb(247, 80, 3)", "rgb(247, 162, 3)", "rgb(243, 247, 3)", 
                            "rgb(162, 247, 3)", "rgb(3, 247, 36)", "rgb(3, 247, 247)", 
                            "rgb(3, 137, 247)", "rgb(19, 3, 247)", "rgb(190, 3, 247)", "rgb(247, 3, 194)"];
            let active_users_graph = new Chart(active_users_graph_element, {
                type: 'bar',
                data: {
                    labels: data[0],
                    datasets: [{
                        label: 'Articles / User',
                        data: data[1],
                        backgroundColor: barColors,
                        borderDash: [10, 5],
                        pointStyle: 'triangle',
                        pointRadius: 10
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: false,
                            text: '10 ACTIVE USERS',
                            align: 'center',
                            padding: {
                                bottom: 10
                            },
                            font: {
                                size: 20,
                                family: 'tahoma',
                                weight: 600,
                            },
                            color: 'blue',
                        },
                        legend: {
                            // display: false,  // https://www.chartjs.org/docs/latest/configuration/legend.html
                            position: 'top'
                        },

                    },
                    scales: {
                        y: {
                            title: {
                                display: true,
                                text: 'Number of posted articles',
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
                                text: "User's Pseudo",
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
                
            });

            let barElement = document.querySelector('.active-users-bar-chart');
            let doughnutElement = document.querySelector('.active-users-doughnut-chart');
            let pieElement = document.querySelector('.active-users-pie-chart');
            let lineElement = document.querySelector('.active-users-line-chart');
            style_chart_handler(active_users_graph, barElement, doughnutElement, pieElement, lineElement);
            
        })
    }
}
