<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $idCategoria = $_POST['idCategoria'];
    $email = $_SESSION['email'];

    $query = "INSERT INTO transacao (descricao, valor, data, tipo, idConta, idCategoria) VALUES ('$descricao', '$valor', '$data', 'gasto', (SELECT id FROM conta WHERE emailUsuario='$email'), '$idCategoria')";
    mysqli_query($conn, $query);
    header('Location: gastos.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Gasto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Gasto</h1>
        <form method="POST">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" class="form-control" name="descricao" required>
            </div>
            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="number" step="0.01" class="form-control" name="valor" required>
            </div>
            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" class="form-control" name="data" required>
            </div>
            <div class="form-group">
                <label for="idCategoria">Categoria:</label>
                <select class="form-control" name="idCategoria" required>
                    <?php
                    $query = "SELECT * FROM categoria";
                    $result = mysqli_query($conn, $query);
                    while ($categoria = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $categoria['id'] . "'>" . $categoria['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
    </div>
</body>
</html>