var jsBehArray = JSON.parse(window.localStorage.getItem("jsBehArray"));

var size_arr = jsBehArray[0].length;

var column1 = [];
var occurrence = [];

var chartType = jsBehArray[2][1];

topLabel = "";
bottomLabel = "";
leftLabel = "";

if (chartType == "activity") {
    topLabel = "Activity Budget";
    bottomLabel = "Behaviour Type";
    leftLabel = "Percentage (%)";

} else if (chartType == "altitude") {
    topLabel = "Average Altitude Usage";
    bottomLabel = "Animal Name";
    leftLabel = "Meters";

} else if (chartType == "tree") {
    topLabel = "Tree Species Usage";
    bottomLabel = "Tree Specie";
    leftLabel = "Percentage (%)";

}

if (chartType !== "altitude") {
    for (var i = 0; i < size_arr; i++) {
        column1.push(jsBehArray[0][i]);
        occurrence.push(((jsBehArray[1][i] / jsBehArray[2][0]) * 100.00));
    }
} else {
    for (var i = 0; i < size_arr; i++) {
        column1.push(jsBehArray[0][i]);
        occurrence.push(jsBehArray[1][i]);
    }
}

var chartdata = {
    labels: column1,
    datasets: [{
        label: topLabel,
        backgroundColor: 'rgba(200, 200, 200, 0.75)',
        borderColor: 'rgba(200, 200, 200, 0.75)',
        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
        hoverBorderColor: 'rgba(200, 200, 200, 1)',

        data: occurrence
    }]
};

var ctx = $("#mycanvas");

var barGraph = new Chart(ctx, {
    type: 'bar',
    data: chartdata,
    options: {
        legend: {
            labels: {
                fontColor: "black",
                fontSize: 18
            }
        },
        scales: {
            yAxes: [{
                scaleLabel: {
                    fontColor: "black",
                    display: true,
                    labelString: leftLabel
                }
            }],
            xAxes: [{
                scaleLabel: {
                    fontColor: "black",
                    display: true,
                    labelString: bottomLabel
                }
            }]
        }
    }
});