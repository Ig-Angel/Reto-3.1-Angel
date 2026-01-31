<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../bd/clientes.php');
$json = array();

// CAMBIO 1: Comparación de métodos
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    $json['message'] = 'Sólo se permite el método POST.';
} else {
      // CAMBIO 2: Validación de datos
    if (!empty($_POST['nombre']) && !empty($_POST['email'])) {
        
        $clientes = new ClientesBD();
        
        // CAMBIO 3: Limpieza de datos
        $clientes->nombre = trim($_POST['nombre']);
        $clientes->email = trim($_POST['email']);
        
        if (($clientes->Insertar() == -1) || $clientes->Error()) {
            $json['message'] = 'Cliente no insertado.';
            http_response_code(501);
        } else {
            $json['message'] = 'Cliente insertado.';
            http_response_code(201);
        }
    } else {
        http_response_code(400);
        $json['message'] = 'Datos incompletos.';
    }
}

// CAMBIO 4: Codigo para mostrar el JSON
echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>