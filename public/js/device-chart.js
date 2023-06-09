// Menginisialisasi chart pertama kali
var data = JSON.parse('{!! json_encode($data) !!}');

// Membuat objek konfigurasi untuk chart
var chartConfig = createChartConfig(data);

// Menggambar chart menggunakan Chart.js
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, chartConfig);

// Memperbarui chart secara otomatis setiap 5 detik
setInterval(function() {
    fetchDataAndUpdateChart();
}, 5000);

// Fungsi untuk mengambil data dari URL Zabbix dan memperbarui chart
function fetchDataAndUpdateChart() {
    fetch('{{ url("device/switch") }}')
        .then(response => response.json())
        .then(data => {
            chartConfig = createChartConfig(data);
            chart.destroy();
            chart = new Chart(ctx, chartConfig);
        })
        .catch(error => console.log(error));
}

// Fungsi untuk membuat objek konfigurasi chart
function createChartConfig(data) {
    var labels = [];
    var values = [];
    data.forEach(function(item) {
        labels.push(item.clock);
        values.push(item.value);
    });

    return {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Data from Zabbix',
                data: values,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Value'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Clock'
                    }
                }
            }
        }
    };
}
