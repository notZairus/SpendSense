
let chart = document.getElementById("myChart");

new Chart(chart, {
  type: 'line',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1,
      fill: true,
      backgroundColor: "rgba(0, 255, 0, 0.5)"
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});