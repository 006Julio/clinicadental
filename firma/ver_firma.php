<!-- ver_firma.php -->
<?php
$host = 'localhost';
$db   = 'firmas_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener la última firma
    $stmt = $pdo->query("SELECT firma_imagen, fecha FROM firmas ORDER BY id DESC LIMIT 1");
    $firma = $stmt->fetch();

    if ($firma) {
        // Codificar la imagen binaria a Base64
        $base64 = base64_encode($firma['firma_imagen']);
        $fecha = $firma['fecha'];
    } else {
        $base64 = null;
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Ver Firma</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
      text-align: center;
    }
    img {
      border: 2px solid #4b00ff;
      border-radius: 4px;
      max-width: 100%;
      height: auto;
    }
    .info {
      margin-top: 1rem;
      color: #555;
    }
  </style>
</head>
<body>
  <h3>Firma guardada</h3>

  <?php if ($base64): ?>
    <img src="data:image/png;base64,<?= $base64 ?>" alt="Firma digital" />
    <p class="info">Fecha: <?= $fecha ?></p>
  <?php else: ?>
    <p>No hay firmas guardadas.</p>
  <?php endif; ?>

  <a href="index.html">Volver a firmar</a>
</body>
</html>