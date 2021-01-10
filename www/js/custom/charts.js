
function createMemberRankChart(canvas, labels, data) {
    return new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                borderWidth: 1,
                backgroundColor: [
                    "rgb(215,215,215)",
                    "rgba(51, 179, 90, 1)",
                    "rgba(75,192,192,1)",
                    "#ffa721"
                ],
                hoverBackgroundColor: [
                    "rgb(238,238,238)",
                    "rgb(61,217,109)",
                    "rgb(87,222,222)",
                    "#ffc168"
                ]
            }]
        }
    });
}

// todo improve colors
function createMemberFacultyChart(canvas, labels, maleData, femaleData) {

    return new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "dicks",
                data: maleData,
                borderWidth: 1,
                backgroundColor: "blue",
                hoverBackgroundColo: "blue"
            },
                {
                    label: "boobs",
                    data: femaleData,
                    borderWidth: 1,
                    backgroundColor: "red",
                    hoverBackgroundColor: "red"
                }
            ]
        },
        options: {
            scales: {
                xAxes: [{stacked: true}],
                yAxes: [{
                    stacked: true,
                    ticks: {stepSize: 1}
                }]
            }
        }
    });
}

// todo improve colors
function createMemberWgChart(canvas, labels, data) {
    return new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                borderWidth: 1,
                backgroundColor: [
                    "red",
                    "blue",
                    "green"
                ],
                hoverBackgroundColor: [
                    "red",
                    "blue",
                    "green"
                ]
            }]
        }
    })
}
