export function style_chart_handler(active_users_graph, barElement, doughnutElement, pieElement, lineElement) {
    
    barElement.onclick = ()=>{
        active_users_graph.config._config.type = 'bar'
        active_users_graph.update();
        barElement.classList.add('selected-type');
        doughnutElement.classList.remove('selected-type');
        pieElement.classList.remove('selected-type');
        lineElement.classList.remove('selected-type');
    }
    doughnutElement.onclick = ()=>{
        active_users_graph.config._config.type = 'doughnut'
        active_users_graph.update();
        barElement.classList.remove('selected-type');
        doughnutElement.classList.add('selected-type');
        pieElement.classList.remove('selected-type');
        lineElement.classList.remove('selected-type');
    }
    pieElement.onclick = ()=>{
        active_users_graph.config._config.type = 'pie'
        active_users_graph.update();
        barElement.classList.remove('selected-type');
        doughnutElement.classList.remove('selected-type');
        pieElement.classList.add('selected-type');
        lineElement.classList.remove('selected-type');
    }
    lineElement.onclick = ()=>{
        active_users_graph.config._config.type = 'line'
        active_users_graph.update();
        barElement.classList.remove('selected-type');
        doughnutElement.classList.remove('selected-type');
        pieElement.classList.remove('selected-type');
        lineElement.classList.add('selected-type');
    }
}