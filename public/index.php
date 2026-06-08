<?php
// Punto de entrada principal
require_once dirname(__DIR__) . '/app/config/app.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rutas simples (por ahora redirige a login)
// En el futuro podrás agregar más rutas aquí
$request = isset($_GET['page']) ? $_GET['page'] : 'login';

switch($request) {
    case 'login':
        require_once APP_PATH . '/modules/auth/login.php';
        break;
    case 'register':
        require_once APP_PATH . '/modules/auth/register.php';
        break;
    case 'authenticate':
        require_once APP_PATH . '/modules/auth/authenticate.php';
        break;
    case 'dashboard':
        require_once APP_PATH . '/modules/reportes/principal.php';  // ← Ruta corregida
        break;
    case 'facturas':
        require_once APP_PATH . '/modules/facturas/facturas.php';
        break;
    case 'usuarios':
        require_once APP_PATH . '/modules/usuarios/usuarios.php';  // Si existe
        break;
    case 'clientes':
        require_once APP_PATH . '/modules/usuarios/agregar-usuario.php';
        break;
    case 'deudores':
        require_once APP_PATH . '/modules/reportes/deudores.php';
        break;
    case 'facturacion':
        require_once APP_PATH . '/modules/reportes/facturacion.php';
        break;
    case 'listados':
        require_once APP_PATH . '/modules/reportes/listados.php';
        break;
    case 'precios':
        require_once APP_PATH . '/modules/reportes/precio.php';
        break;
    case 'logout':
        require_once APP_PATH . '/modules/auth/logout.php';
        break;
    case 'create_user':
        require_once APP_PATH . '/modules/auth/create_users.php';
        break;
    case 'agregar_cliente':
        require_once APP_PATH . '/modules/usuarios/agregar-usuario.php';
        break;
    case 'procesar_cliente':
        require_once APP_PATH . '/modules/usuarios/procesar_registro.php';
        break;
    case 'modificar_cliente':
        require_once APP_PATH . '/modules/usuarios/modificar-usuario.php';
        break;
    case 'procesar_modificacion':
        require_once APP_PATH . '/modules/usuarios/procesar_modificacion.php';
        break;
    case 'obtener_ordenes':
        require_once APP_PATH . '/modules/utils/obtener_ordenes.php';
        break;
    case 'eliminar_cliente':
        require_once APP_PATH . '/modules/usuarios/eliminar-usuario.php';
        break;
    default:
        require_once APP_PATH . '/modules/auth/login.php';
        break;
}
?>