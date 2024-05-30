    function updateTime() {
        $.ajax({
            url: '/get-time',
            type: 'GET',
            success: function(response) {
                var dateTime = new Date(response.time);
                var formattedDateTime = formatDateTime(dateTime);
                $('#realtime-clock').text(formattedDateTime);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function formatDateTime(dateTime) {
        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        return days[dateTime.getDay()] + ', ' +
               dateTime.getDate() + ' ' +
               months[dateTime.getMonth()] + ' ' +
               dateTime.getFullYear() + ' ' +
               ('0' + dateTime.getHours()).slice(-2) + ':' +
               ('0' + dateTime.getMinutes()).slice(-2) + ':' +
               ('0' + dateTime.getSeconds()).slice(-2);
    }

//Chart 1   
var ctx1 = document.getElementById('chartJumlahMasuk').getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: [], // Label sumbu X dalam format waktu yang diharapkan
        datasets: [{
            label: 'Jumlah Pengguna Masuk',
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: [], // Data untuk sumbu Y
            fill: false,
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        scales: {
            xAxes: [{
                type: 'time', // Jenis sumbu X: waktu
                time: {
                    unit: 'hour',
                    displayFormats: {
                        hour: 'HH:mm' // Format waktu yang diinginkan
                    }
                }
            }],
            yAxes: [{}]
        }
    }
});

var ctx2 = document.getElementById('chartPayments').getContext('2d');
var myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: [], // Label sumbu X dalam format waktu yang diharapkan
        datasets: [{
            label: 'Jumlah Pembayaran',
            backgroundColor: "rgba(255,0,0,1.0)",
            borderColor: "rgba(255,0,0,0.1)",
            data: [], // Data untuk sumbu Y
            fill: false,
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        scales: {
            xAxes: [{
                type: 'time', // Jenis sumbu X: waktu
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'YYYY-MM-DD' // Format waktu yang diinginkan
                    }
                }
            }],
            yAxes: [{}]
        }
    }
});

function updateCharts() {
    $.ajax({
        url: "/get-chart-data",
        method: "GET",
        dataType: "json",
        success: function (data) {
            myChart1.data.labels = data.labels_access_log;
            myChart1.data.datasets[0].data = data.jumlah_masuk;
            myChart1.update();

            myChart2.data.labels = data.labels_payments;
            myChart2.data.datasets[0].data = data.payments;
            myChart2.update();
        },
        complete: function () {
            setTimeout(updateCharts, 5000);
        }
    });
}


    
    
    function updatePayment() {
        $.ajax({
            url: "/get-payments",
            method: "GET",
            dataType: "json",
            success: function(data) {
                $('#totalPendapatan').text('Total Pembayaran Hari Ini: Rp ' + data.totalPendapatan);
                $('#jumlahTransaksi').text('Jumlah Transaksi: ' + data.transaksi);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            },
            complete: function () {
                setTimeout(updatePayment, 1000);
            }
        });
    }
    
    function updateSlot(){
        $.ajax({
            url: "/get-slot",
            method: "GET",
            dataType: "json",
            success: function(data){
                $('#slot').text('Slot Tersedia: '+data.slot);
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            },
            complete: function () {
                setTimeout(updateSlot, 1000);
            }
        });
    }
    
    Pusher.logToConsole = true;

    var pusher = new Pusher('285faf09a1aaa779e023', {
        cluster: 'ap1',
        encrypted: true
    });

        var channel = pusher.subscribe('gate-notification-channel');
        channel.bind('gate-notification-event', function(data) {
            showNotification(data);
        });

        function showNotification(data) {
    var notificationContainer = document.getElementById('notification-container');
    var notificationElement = document.createElement('div');
    notificationElement.classList.add('notification');

    var message = data.message + ' baru saja keluar';

    notificationElement.innerHTML = `
        <span class="notification-close-btn">&times;</span> <!-- Tombol "X" -->
        <div class="notification-title">${data.no_plat}</div>
        <div class="notification-message">${message}</div>
        <div class="notification-time">${data.time}</div>
    `;

    notificationContainer.appendChild(notificationElement);

    var closeBtn = notificationElement.querySelector('.notification-close-btn');
    closeBtn.addEventListener('click', function() {
        notificationElement.remove();
    });

    setTimeout(function(){
        notificationElement.remove();
    }, 10000);
}

    $(document).ready(function () {
        updateCharts();
        updateTime();
        updatePayment();
        updateSlot();
        setInterval(updateTime, 1000);
   });
