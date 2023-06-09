@extends('layouts.app')
@section('title', 'Server')
@section('content')
    <div class="col-12 mt-4">
        <div class="row">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


            {{-- •	Memory Usage (QAD Server)    --}}
            <div class="col-4">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Memory Usage (QAD Server)</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="MemoryUsageQAD" height="150px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData = {!! json_encode($chartData) !!};
                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Mbps)
                function convertToGB1(value) {

                    var mbpsValue = value / 1000000000;
                    return mbpsValue;
                }

                // Konversi nilai pada datasets menjadi megabit per detik (Mbps)
                for (var i = 0; i < chartData.length; i++) {
                    for (var j = 0; j < chartData[i].data.length; j++) {
                        chartData[i].data[j] = convertToGB1(chartData[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels = [];
                for (var i = 0; i < chartData[0].data.length; i++) {
                    labels.push(i + 1);
                }

                // Buat array untuk datasets
                var datasets = [];
                for (var i = 0; i < chartData.length; i++) {
                    datasets.push({
                        label: chartData[i].name,
                        data: chartData[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart = new Chart(document.getElementById('MemoryUsageQAD'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Time'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    callback: function(value, index, values) {
                                        return value + " GB";
                                    }
                                }
                            }
                        }
                    }
                });

                // Fungsi untuk mendapatkan warna acak
                function getRandomColor() {
                    var letters = '0123456789ABCDEF';
                    var color = '#';
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }

                function updateChart() {
                    // Kirim permintaan AJAX ke server untuk mendapatkan data terbaru
                    $.ajax({
                        url: '{{ route('MemoryUsageQAD') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToGB1(value);
                                });
                            }

                            myChart.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 5000);
            </script>


            {{-- •	CPU Utilization (QAD Server)     --}}
            <div class="col-4">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">CPU Utilization (QAD Server)</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="CPUUtillQAD" height="150px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData1 = {!! json_encode($chartData1) !!};
                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Mbps)
                function convertToPersen1(value) {
                    var mbpsValue = value;
                    return mbpsValue;
                }

                // Konversi nilai pada datasets menjadi megabit per detik (Mbps)
                for (var i = 0; i < chartData1.length; i++) {
                    for (var j = 0; j < chartData1[i].data.length; j++) {
                        chartData1[i].data[j] = convertToPersen1(chartData1[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels1 = [];
                for (var i = 0; i < chartData1[0].data.length; i++) {
                    labels1.push(i + 1);
                }

                // Buat array untuk datasets
                var datasets1 = [];
                for (var i = 0; i < chartData1.length; i++) {
                    datasets1.push({
                        label: chartData1[i].name,
                        data: chartData1[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart1 = new Chart(document.getElementById('CPUUtillQAD'), {
                    type: 'line',
                    data: {
                        labels: labels1,
                        datasets: datasets1
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Time'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    callback: function(value, index, values) {
                                        return value + " %";
                                    }
                                }
                            }
                        }
                    }
                });

                // Fungsi untuk mendapatkan warna acak
                function getRandomColor() {
                    var letters = '0123456789ABCDEF';
                    var color = '#';
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }

                function updateChart() {
                    // Kirim permintaan AJAX ke server untuk mendapatkan data terbaru
                    $.ajax({
                        url: '{{ route('CPUUtillQAD') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart1.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart1.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToPersen1(value);
                                });
                            }

                            myChart1.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 5000);
            </script>

            {{-- •	Disk Space Usage (QAD Server)   --}}
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header" style="padding: 5px">

                            <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Disk Space Usage (QAD Server)</h6>
                        </div>
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <div id="DiskSpaceUsageQAD"  height="150px"></div>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                var chartData2 = {!! json_encode($chartData2) !!};

                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Label');
                    data.addColumn('number', 'Value');

                    chartData2.forEach(function(chartData) {
                        var value = parseFloat(chartData[1]); // Mengubah string menjadi tipe data numerik
                        data.addRow([chartData[0], value]);
                    });

                    var options = {
                        chartArea: { width: '100%', height: '90%' },
                        legend: { position: 'right' },
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('DiskSpaceUsageQAD'));

                    chart.draw(data, options);
                }
            </script>


            {{-- •	Memory utilization (Attandance Server)    --}}
            <div class="col-4">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Memory utilization (Attandance
                            Server)</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="MemoryUtilATT" height="150px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData3 = {!! json_encode($chartData3) !!};
                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Mbps)
                function convertToPersen2(value) {

                    var mbpsValue = value;
                    return mbpsValue;
                }

                // Konversi nilai pada datasets menjadi megabit per detik (Mbps)
                for (var i = 0; i < chartData3.length; i++) {
                    for (var j = 0; j < chartData3[i].data.length; j++) {
                        chartData3[i].data[j] = convertToPersen2(chartData3[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels3 = [];
                for (var i = 0; i < chartData3[0].data.length; i++) {
                    labels3.push(i + 1);
                }

                // Buat array untuk datasets
                var datasets3 = [];
                for (var i = 0; i < chartData3.length; i++) {
                    datasets3.push({
                        label: chartData3[i].name,
                        data: chartData3[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart3 = new Chart(document.getElementById('MemoryUtilATT'), {
                    type: 'line',
                    data: {
                        labels: labels3,
                        datasets: datasets3
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Time'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    callback: function(value, index, values) {
                                        return value + " %";
                                    }
                                }
                            }
                        }
                    }
                });

                // Fungsi untuk mendapatkan warna acak
                function getRandomColor() {
                    var letters = '0123456789ABCDEF';
                    var color = '#';
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }

                function updateChart() {
                    // Kirim permintaan AJAX ke server untuk mendapatkan data terbaru
                    $.ajax({
                        url: '{{ route('MemoryUtilATT') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart3.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart3.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToPersen2(value);
                                });
                            }

                            myChart3.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 5000);
            </script>



            {{-- •	CPU Utilization (Attandance Server)     --}}
            <div class="col-4">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">CPU Utilization (Attandance
                            Server)</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="CPUUtillATT" height="150px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData4 = {!! json_encode($chartData4) !!};
                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Mbps)
                function convertToPersen3(value) {

                    var mbpsValue = value;
                    return mbpsValue;
                }

                // Konversi nilai pada datasets menjadi megabit per detik (Mbps)
                for (var i = 0; i < chartData1.length; i++) {
                    for (var j = 0; j < chartData4[i].data.length; j++) {
                        chartData4[i].data[j] = convertToPersen3(chartData4[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels4 = [];
                for (var i = 0; i < chartData4[0].data.length; i++) {
                    labels4.push(i + 1);
                }

                // Buat array untuk datasets
                var datasets4 = [];
                for (var i = 0; i < chartData4.length; i++) {
                    datasets4.push({
                        label: chartData4[i].name,
                        data: chartData4[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart4 = new Chart(document.getElementById('CPUUtillATT'), {
                    type: 'line',
                    data: {
                        labels: labels4,
                        datasets: datasets4
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Time'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: false,
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    callback: function(value, index, values) {
                                        return value + " %";
                                    }
                                }
                            }
                        }
                    }
                });

                // Fungsi untuk mendapatkan warna acak
                function getRandomColor() {
                    var letters = '0123456789ABCDEF';
                    var color = '#';
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }

                function updateChart() {
                    // Kirim permintaan AJAX ke server untuk mendapatkan data terbaru
                    $.ajax({
                        url: '{{ route('CPUUtillATT') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart4.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart4.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToPersen3(value);
                                });
                            }

                            myChart4.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 5000);
            </script>


            {{-- •	Disk Space Usage (Attandance Server)    --}}
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header" style="padding: 5px">

                            <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Disk Space Usage (Attandance Server)</h6>
                        </div>
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <div id="DiskSpaceUsageATT" height="150px"></div>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                var chartData5 = {!! json_encode($chartData5) !!};

                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Label');
                    data.addColumn('number', 'Value');

                    chartData5.forEach(function(chartData) {
                        var value = parseFloat(chartData[1]); // Mengubah string menjadi tipe data numerik
                        data.addRow([chartData[0], value]);
                    });

                    var options = {
                        chartArea: { width: '100%', height: '90%' },
                        legend: { position: 'right' },
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('DiskSpaceUsageATT'));

                    chart.draw(data, options);
                }
            </script>
            
        </div>
    </div>
@endsection
