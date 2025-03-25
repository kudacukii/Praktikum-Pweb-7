<body>

<div class="container pt-5">
    <h1 class="text-center"> membuat Grafik dengan PHP dan MySQL</h1>
    <div class="chart-container" style="position: relative; height: 80%; width: 80vw;">
        <canvas id="myChart"></canvas>
    </div>
    <button id="downloadPdf">Download PDF</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
    <?php
    include 'koneksi.php';

    $query  = "SELECT jurusan, COUNT(*) AS jml_mahasiswa FROM mahasiswa GROUP BY jurusan";
    $result = mysqli_query($conn, $query);

    $jurusan = [];
    $jumlah = [];

    while ($data = mysqli_fetch_array($result)) {
        $jurusan[] = $data['jurusan'];
        $jumlah[] = $data['jml_mahasiswa'];
    }
    ?>

    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($jurusan); ?>,
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: <?php echo json_encode($jumlah); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    document.getElementById('downloadPdf').addEventListener('click', function () {
        html2canvas(document.querySelector('.chart-container')).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('landscape');
            pdf.addImage(imgData, 'PNG', 10, 10);
            pdf.save('chart.pdf');
        });
    });
</script>
</html>
