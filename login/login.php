<?php
// login.php - Procesa el login del usuario

header('Content-Type: application/json; charset=utf-8');

// Datos de conexión
$host = 'localhost';
$dbname = 'clinica_dental';
$username = 'root';     // Cambia si usas otro usuario
$password = '';         // Cambia si tu root tiene contraseña (en XAMPP por defecto no tiene)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']);
    exit;
}

// Solo procesamos si es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

// Recibir datos del frontend
$data = json_decode(file_get_contents('php://input'), true);

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$role = $data['role'] ?? '';

// Validar campos
if (empty($email) || empty($password) || empty($role)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

// Buscar usuario en la base de datos
$stmt = $pdo->prepare("SELECT id, nombre, email, rol FROM usuarios WHERE email = ? AND password = ? AND rol = ?");
$stmt->execute([$email, $password, $role]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Iniciar sesión (opcional, para mantener login en otras páginas)
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['nombre'];
    $_SESSION['user_role'] = $user['rol'];

    echo json_encode([
        'success' => true,
        'message' => 'Login exitoso. Redirigiendo...',
        'user' => [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'email' => $user['email'],
            'rol' => $user['rol']
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas o rol no coincide.']);
}