@extends('layouts.app')
@section('title', 'Switch')
@section('content')
    <div class="col-12 mt-4">
        <div class="row">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            {{-- •	Ping Core Switch  --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Core Switch</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingCoreSwitch" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData = {!! json_encode($chartData) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Mbps)
                function convertToMs(value) {
                    var msValue = value * 1000;
                    return msValue;
                }

                // Konversi nilai pada datasets menjadi megabit per detik (Mbps)
                for (var i = 0; i < chartData.length; i++) {
                    for (var j = 0; j < chartData[i].data.length; j++) {
                        chartData[i].data[j] = convertToMs(chartData[i].data[j]);
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
                        // label: customLabels[i], //untuk custome data
                        label: chartData[i].name,
                        data: chartData[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart = new Chart(document.getElementById('PingCoreSwitch'), {
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingCoreSwitch') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>


            {{-- •	PingAccessSwitchMainOffice   --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Main Office </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchMainOffice" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData1 = {!! json_encode($chartData1) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value *1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData1.length; i++) {
                    for (var j = 0; j < chartData1[i].data.length; j++) {
                        chartData1[i].data[j] = convertToMs(chartData1[i].data[j]);
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
                        // label: customLabels[i], //untuk custome data
                        label: chartData1[i].name,
                        data: chartData1[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart1 = new Chart(document.getElementById('PingAccessSwitchMainOffice'), {
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchMainOffice') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart1.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart1.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart1.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>


            {{-- •	PingAccessSwitchHall1    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Hall 1 </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchHall1" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData2 = {!! json_encode($chartData2) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value *1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData2.length; i++) {
                    for (var j = 0; j < chartData2[i].data.length; j++) {
                        chartData2[i].data[j] = convertToMs(chartData2[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels2 = [];
                for (var i = 0; i < chartData2[0].data.length; i++) {
                    labels2.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets2 = [];
                for (var i = 0; i < chartData2.length; i++) {
                    datasets2.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData2[i].name,
                        data: chartData2[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart2 = new Chart(document.getElementById('PingAccessSwitchHall1'), {
                    type: 'line',
                    data: {
                        labels: labels2,
                        datasets: datasets2
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchHall1') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart2.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart2.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart2.update();
                        }
                    });
                }
                
                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>
            

            {{-- •	Ping Access Switch Workshop     --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Workshop</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchWorkshop" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData3 = {!! json_encode($chartData3) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData3.length; i++) {
                    for (var j = 0; j < chartData3[i].data.length; j++) {
                        chartData3[i].data[j] = convertToMs(chartData3[i].data[j]);
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
                        // label: customLabels[i], //untuk custome data
                        label: chartData3[i].name,
                        data: chartData3[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart3 = new Chart(document.getElementById('PingAccessSwitchWorkshop'), {
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchWorkshop') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart3.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart3.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart3.update();
                        }
                    });
                }


                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>
                        

            {{-- •	Ping Access Switch Hall 2      --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Hall 2</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchHall2" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData4 = {!! json_encode($chartData4) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData4.length; i++) {
                    for (var j = 0; j < chartData4[i].data.length; j++) {
                        chartData4[i].data[j] = convertToMs(chartData4[i].data[j]);
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
                        // label: customLabels[i], //untuk custome data
                        label: chartData4[i].name,
                        data: chartData4[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart4 = new Chart(document.getElementById('PingAccessSwitchHall2'), {
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchHall2') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart4.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart4.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart4.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>

            {{-- •	Ping Access Switch Hall 3    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Hall 3</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchHall3" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData5 = {!! json_encode($chartData5) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData5.length; i++) {
                    for (var j = 0; j < chartData5[i].data.length; j++) {
                        chartData5[i].data[j] = convertToMs(chartData5[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels5 = [];
                for (var i = 0; i < chartData5[0].data.length; i++) {
                    labels5.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets5 = [];
                for (var i = 0; i < chartData5.length; i++) {
                    datasets5.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData5[i].name,
                        data: chartData5[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart5 = new Chart(document.getElementById('PingAccessSwitchHall3'), {
                    type: 'line',
                    data: {
                        labels: labels5,
                        datasets: datasets5
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchHall3') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart5.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart5.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart5.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>
            

            {{-- •	Ping Access Switch Small Office Area 1      --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Small Office Area 1</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchSmallOfficeArea1" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData6 = {!! json_encode($chartData6) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData6.length; i++) {
                    for (var j = 0; j < chartData6[i].data.length; j++) {
                        chartData6[i].data[j] = convertToMs(chartData6[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels6 = [];
                for (var i = 0; i < chartData6[0].data.length; i++) {
                    labels6.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets6 = [];
                for (var i = 0; i < chartData6.length; i++) {
                    datasets6.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData6[i].name,
                        data: chartData6[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart6 = new Chart(document.getElementById('PingAccessSwitchSmallOfficeArea1'), {
                    type: 'line',
                    data: {
                        labels: labels6,
                        datasets: datasets6
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchSmallOfficeArea1') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart6.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart6.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart6.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>


            {{-- •	Ping Access Switch Small Office Area 2      --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Small Office Area 2</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchSmallOfficeArea2" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData7 = {!! json_encode($chartData7) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData7.length; i++) {
                    for (var j = 0; j < chartData7[i].data.length; j++) {
                        chartData7[i].data[j] = convertToMs(chartData7[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels7 = [];
                for (var i = 0; i < chartData7[0].data.length; i++) {
                    labels7.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets7 = [];
                for (var i = 0; i < chartData7.length; i++) {
                    datasets7.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData7[i].name,
                        data: chartData7[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart7 = new Chart(document.getElementById('PingAccessSwitchSmallOfficeArea2'), {
                    type: 'line',
                    data: {
                        labels: labels7,
                        datasets: datasets7
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchSmallOfficeArea2') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart7.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart7.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart7.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>


            {{-- •	Ping Access Switch Security Front   --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Security Front</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchSecurityFront" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData8 = {!! json_encode($chartData8) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData8.length; i++) {
                    for (var j = 0; j < chartData8[i].data.length; j++) {
                        chartData8[i].data[j] = convertToMs(chartData8[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels8 = [];
                for (var i = 0; i < chartData8[0].data.length; i++) {
                    labels8.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets8 = [];
                for (var i = 0; i < chartData8.length; i++) {
                    datasets8.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData8[i].name,
                        data: chartData8[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart8 = new Chart(document.getElementById('PingAccessSwitchSecurityFront'), {
                    type: 'line',
                    data: {
                        labels: labels8,
                        datasets: datasets8
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
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
                        url: '{{ route('PingAccessSwitchSecurityFront') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart8.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart8.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart8.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>


            {{-- •	Ping Access Switch Security Side    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Access Switch Security Side</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingAccessSwitchSecuritySide" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData9 = {!! json_encode($chartData9) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData9.length; i++) {
                    for (var j = 0; j < chartData9[i].data.length; j++) {
                        chartData9[i].data[j] = convertToMs(chartData9[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels9 = [];
                for (var i = 0; i < chartData9[0].data.length; i++) {
                    labels9.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets9 = [];
                for (var i = 0; i < chartData9.length; i++) {
                    datasets9.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData9[i].name,
                        data: chartData9[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart9 = new Chart(document.getElementById('PingAccessSwitchSecuritySide'), {
                    type: 'line',
                    data: {
                        labels: labels9,
                        datasets: datasets9
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
                                    }
                                },
                                min: 0 
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
                        url: '{{ route('PingAccessSwitchSecuritySide') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart9.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart9.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart9.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>

            {{-- •	Ping Server Farm Switch    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping Server Farm Switch</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingServerFarmSwitch" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData10 = {!! json_encode($chartData10) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData10.length; i++) {
                    for (var j = 0; j < chartData10[i].data.length; j++) {
                        chartData10[i].data[j] = convertToMs(chartData10[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels10 = [];
                for (var i = 0; i < chartData10[0].data.length; i++) {
                    labels10.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets10 = [];
                for (var i = 0; i < chartData10.length; i++) {
                    datasets10.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData10[i].name,
                        data: chartData10[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart10 = new Chart(document.getElementById('PingServerFarmSwitch'), {
                    type: 'line',
                    data: {
                        labels: labels10,
                        datasets: datasets10
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
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
                                    }
                                },
                                min: 0 
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
                        url: '{{ route('PingServerFarmSwitch') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart10.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart10.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart10.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>

            {{-- •	Ping WAN Distribution Switch ISP Cyberplus     --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping WAN Distribution Switch ISP Cyberplus</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingWANDistributionSwitchISPCyberplus" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData11 = {!! json_encode($chartData11) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData11.length; i++) {
                    for (var j = 0; j < chartData11[i].data.length; j++) {
                        chartData11[i].data[j] = convertToMs(chartData11[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels11 = [];
                for (var i = 0; i < chartData11[0].data.length; i++) {
                    labels11.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets11 = [];
                for (var i = 0; i < chartData11.length; i++) {
                    datasets11.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData11[i].name,
                        data: chartData11[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart11 = new Chart(document.getElementById('PingWANDistributionSwitchISPCyberplus'), {
                    type: 'line',
                    data: {
                        labels: labels11,
                        datasets: datasets11
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
                                    }
                                },
                                min: 0 
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
                        url: '{{ route('PingWANDistributionSwitchISPCyberplus') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart11.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart11.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart11.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>

            {{-- •	Ping WAN Distribution Switch ISP Linknet    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Ping WAN Distribution Switch ISP Linknet</h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="PingWANDistributionSwitchISPLinknet" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData12 = {!! json_encode($chartData12) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMs(value) {

                    var msValue = value * 1000;
                    return msValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData12.length; i++) {
                    for (var j = 0; j < chartData12[i].data.length; j++) {
                        chartData12[i].data[j] = convertToMs(chartData12[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels12 = [];
                for (var i = 0; i < chartData12[0].data.length; i++) {
                    labels12.push(i + 1);
                }


                // Buat array untuk datasets
                var datasets12 = [];
                for (var i = 0; i < chartData12.length; i++) {
                    datasets12.push({
                        // label: customLabels[i], //untuk custome data
                        label: chartData12[i].name,
                        data: chartData12[i].data,
                        fill: true,
                        borderColor: getRandomColor(),
                        // borderWidth: 2;
                    });
                }

                // Buat chart menggunakan Chart.js
                var myChart12 = new Chart(document.getElementById('PingWANDistributionSwitchISPLinknet'), {
                    type: 'line',
                    data: {
                        labels: labels12,
                        datasets: datasets12
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
                                    text: 'Value (ms)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " ms";
                                    }
                                },
                                min: 0 
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
                        url: '{{ route('PingWANDistributionSwitchISPLinknet') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart12.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart12.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMs(value);
                                });
                            }

                            myChart12.update();
                        }
                    });
                }

                // Panggil fungsi updateChart untuk pertama kali
                updateChart();

                // Perbarui grafik setiap 5 detik
                setInterval(updateChart, 15000);
            </script>


            
        </div>
    </div>
@endsection
