@extends('layouts.app')
@section('title', 'Switch')
@section('content')
    <div class="col-12 mt-4">
        <div class="row">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            {{-- •	•	Networktrafficint112Uplink (core switch  --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/1/2 Uplink Firewall (core swtich)
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint112Uplink" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData = {!! json_encode($chartData) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Mbps)
                function convertToMbps(value) {
                    var mbpsValue = value / 1000000;
                    return mbpsValue;
                }

                // Konversi nilai pada datasets menjadi megabit per detik (Mbps)
                for (var i = 0; i < chartData.length; i++) {
                    for (var j = 0; j < chartData[i].data.length; j++) {
                        chartData[i].data[j] = convertToMbps(chartData[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels = [];
                for (var i = 0; i < chartData[0].data.length; i++) {
                    labels.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart = new Chart(document.getElementById('Networktrafficint112Uplink'), {
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
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint112Uplink') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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


            {{-- •	Networktrafficint141DownlinkMainOffice (core switch)   --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/4/1
                            Downlink Main Office (core switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint141DownlinkMainOffice" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData1 = {!! json_encode($chartData1) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData1.length; i++) {
                    for (var j = 0; j < chartData1[i].data.length; j++) {
                        chartData1[i].data[j] = convertToMbps(chartData1[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels1 = [];
                for (var i = 0; i < chartData1[0].data.length; i++) {
                    labels1.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart1 = new Chart(document.getElementById('Networktrafficint141DownlinkMainOffice'), {
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
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint141DownlinkMainOffice') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart1.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart1.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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


            {{-- •	Networktrafficint121DownlinkHall1 (core switch)    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/2/1 Downlink Hall 1 (core switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint121DownlinkHall1" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData2 = {!! json_encode($chartData2) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData2.length; i++) {
                    for (var j = 0; j < chartData2[i].data.length; j++) {
                        chartData2[i].data[j] = convertToMbps(chartData2[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels2 = [];
                for (var i = 0; i < chartData2[0].data.length; i++) {
                    labels2.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart2 = new Chart(document.getElementById('Networktrafficint121DownlinkHall1'), {
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
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint121DownlinkHall1') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart2.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart2.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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
            

            {{-- •	Networktrafficint122DownlinkWorkshop (core switch)     --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/2/2 Downlink Workshop (core switch)  </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint122DownlinkWorkshop" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData3 = {!! json_encode($chartData3) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData3.length; i++) {
                    for (var j = 0; j < chartData3[i].data.length; j++) {
                        chartData3[i].data[j] = convertToMbps(chartData3[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels3 = [];
                for (var i = 0; i < chartData3[0].data.length; i++) {
                    labels3.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart3 = new Chart(document.getElementById('Networktrafficint122DownlinkWorkshop'), {
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
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint122DownlinkWorkshop') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart3.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart3.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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
                        

            {{-- •	Networktrafficint142DownlinkHall2 (core switch)     --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/4/2 Downlink Hall 2 (core switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint142DownlinkHall2" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData4 = {!! json_encode($chartData4) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData4.length; i++) {
                    for (var j = 0; j < chartData4[i].data.length; j++) {
                        chartData4[i].data[j] = convertToMbps(chartData4[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels4 = [];
                for (var i = 0; i < chartData4[0].data.length; i++) {
                    labels4.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart4 = new Chart(document.getElementById('Networktrafficint142DownlinkHall2'), {
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
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint142DownlinkHall2') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart4.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart4.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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


            {{-- •	Networktrafficint143DownlinkHall3 (core switch    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">•	Network traffic int 1/4/3 Downlink Hall 3 (core switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint143DownlinkHall3" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData5 = {!! json_encode($chartData5) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData5.length; i++) {
                    for (var j = 0; j < chartData5[i].data.length; j++) {
                        chartData5[i].data[j] = convertToMbps(chartData5[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels5 = [];
                for (var i = 0; i < chartData5[0].data.length; i++) {
                    labels5.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart5 = new Chart(document.getElementById('Networktrafficint143DownlinkHall3'), {
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
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint143DownlinkHall3') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart5.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart5.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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
            

            {{-- •	•	Networktrafficint131DownlinkSmalloffice1 (core switch)     --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/3/1 Downlink Small office 1(core switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint131DownlinkSmalloffice1" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData6 = {!! json_encode($chartData6) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData6.length; i++) {
                    for (var j = 0; j < chartData6[i].data.length; j++) {
                        chartData6[i].data[j] = convertToMbps(chartData6[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels6 = [];
                for (var i = 0; i < chartData6[0].data.length; i++) {
                    labels6.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart6 = new Chart(document.getElementById('Networktrafficint131DownlinkSmalloffice1'), {
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
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint131DownlinkSmalloffice1') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart6.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart6.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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


            {{-- •	Networktrafficint132DownlinkSmalloffice2(core switch)     --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/3/2 Downlink Small office 2(core switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint132DownlinkSmalloffice2" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData7 = {!! json_encode($chartData7) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData7.length; i++) {
                    for (var j = 0; j < chartData7[i].data.length; j++) {
                        chartData7[i].data[j] = convertToMbps(chartData7[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels7 = [];
                for (var i = 0; i < chartData7[0].data.length; i++) {
                    labels7.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart7 = new Chart(document.getElementById('Networktrafficint132DownlinkSmalloffice2'), {
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
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint132DownlinkSmalloffice2') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart7.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart7.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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


            {{-- •	Networktrafficint121ISPCyberplus (WAN switch)    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/2/1 ISP Cyberplus (WAN switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint121ISPCyberplus" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData8 = {!! json_encode($chartData8) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData8.length; i++) {
                    for (var j = 0; j < chartData8[i].data.length; j++) {
                        chartData8[i].data[j] = convertToMbps(chartData8[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels8 = [];
                for (var i = 0; i < chartData8[0].data.length; i++) {
                    labels8.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart8 = new Chart(document.getElementById('Networktrafficint121ISPCyberplus'), {
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
                                    text: 'Value (Mbps)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + " Mbps";
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
                        url: '{{ route('Networktrafficint121ISPCyberplus') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart8.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart8.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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


            {{-- •	Networktrafficint112ISPLinknet (WAN switch)    --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-header" style="padding: 5px">

                        <h6 class="text-center" style="font-size: 14px; margin-bottom: 0;">Network traffic int 1/1/2 ISP Linknet (WAN switch) </h6>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan chart di sini dengan menggunakan data riwayat yang sesuai -->
                        <canvas id="Networktrafficint112ISPLinknet" height="200px"></canvas>
                    </div>
                </div>
            </div>
            <script>
                // Ambil data yang dikirim dari kontroler
                var chartData9 = {!! json_encode($chartData9) !!};

                // Fungsi untuk mengonversi nilai menjadi megabit per detik (Ms)
                function convertToMbps(value) {

                    var mbpsValue = value / 1000000;
                    return mbpsValue;

                }

                // Konversi nilai pada datasets menjadi megabit per detik (Ms)
                for (var i = 0; i < chartData9.length; i++) {
                    for (var j = 0; j < chartData9[i].data.length; j++) {
                        chartData9[i].data[j] = convertToMbps(chartData9[i].data[j]);
                    }
                }

                // Buat array untuk label sumbu X (waktu)
                var labels9 = [];
                for (var i = 0; i < chartData9[0].data.length; i++) {
                    labels9.push(i + 1);
                }

                // var customLabels = ['Label 1', 'Label 2']; // Array label manual

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
                var myChart9 = new Chart(document.getElementById('Networktrafficint112ISPLinknet'), {
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
                        url: '{{ route('Networktrafficint112ISPLinknet') }}', // Ganti dengan URL yang sesuai untuk mengambil data terbaru dari server
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            myChart9.data.labels = response[0].labels.reverse().map(function(label) {
                                var time = label.slice(-9); // Mengambil 9 karakter terakhir
                                return time;
                            });

                            for (var i = 0; i < response.length; i++) {
                                myChart9.data.datasets[i].data = response[i].values.reverse().map(function(value) {
                                    return convertToMbps(value);
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

        </div>
    </div>
@endsection
