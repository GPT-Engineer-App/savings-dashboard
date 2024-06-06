<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
include('db.php');

$email = $_SESSION['email'];
$query = "SELECT * FROM transacao WHERE idConta IN (SELECT id FROM conta WHERE emailUsuario='$email') AND tipo='gasto'";
$result = mysqli_query($conn, $query);
$gastos = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Gastos</h1>
        <canvas id="gastosChart"></canvas>
        <table class="table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gastos as $gasto): ?>
                <tr>
                    <td><?php echo $gasto['descricao']; ?></td>
                    <td><?php echo $gasto['valor']; ?></td>
                    <td><?php echo $gasto['data']; ?></td>
                    <td><?php echo $gasto['idCategoria']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_gasto.php" class="btn btn-primary">Adicionar Gasto</a>
    </div>
    <script>
        const ctx = document.getElementById('gastosChart').getContext('2d');
        const gastosChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php foreach ($gastos as $gasto) { echo "'" . $gasto['data'] . "',"; } ?>],
                datasets: [{
                    label: 'Gastos',
                    data: [<?php foreach ($gastos as $gasto) { echo $gasto['valor'] . ","; } ?>],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
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
    </script>
</body>
</html>