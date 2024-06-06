<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
include('db.php');

$email = $_SESSION['email'];
$query = "SELECT nomeCompleto FROM usuario WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo $user['nomeCompleto']; ?>!</h1>
        <div class="row">
            <div class="col-md-4">
                <a href="gastos.php" class="btn btn-primary btn-block">Gastos</a>
            </div>
            <div class="col-md-4">
                <a href="economias.php" class="btn btn-primary btn-block">Economias</a>
            </div>
            <div class="col-md-4">
                <a href="investimentos.php" class="btn btn-primary btn-block">Investimentos</a>
            </div>
        </div>
    </div>
</body>
</html>