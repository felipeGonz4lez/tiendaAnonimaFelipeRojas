<?php
session_start();
if(!isset($_SESSION["id"])){
    header("Location: iniciarSesion.php");
}
$id = $_SESSION["id"];
require ("logica/Persona.php");
require ("logica/Administrador.php");

$administrador = new Administrador($id);
$administrador->consultar();

require_once ("logica/Producto.php");
require_once ("persistencia/Conexion.php"); // Asegúrate de incluir la conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precioCompra = $_POST['precioCompra'];
    $precioVenta = $_POST['precioVenta'];
    $marcaId = $_POST['marca'];
    $categoriaId = $_POST['categoria'];
    
    // Crear conexión
    $conexion = new Conexion();
    $conexion->abrirConexion();
    
    // Consulta para insertar el producto
    $query = "INSERT INTO Producto (nombre, cantidad, precioCompra, precioVenta, Marca_idMarca, Categoria_idCategoria, Administrador_idAdministrador)
              VALUES ('$nombre', $cantidad, $precioCompra, $precioVenta, $marcaId, $categoriaId, $id)";
    
    if ($conexion->ejecutarConsulta($query)) {
        echo "<div class='alert alert-success'>Producto agregado con éxito.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al agregar el producto.</div>";
    }
    
    $conexion->cerrarConexion(); // Cierra la conexión
}
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include ("encabezado.php");?>

    <div class="container mt-5">
        <h2>Nuevo Producto</h2>
        <form method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="mb-3">
                <label for="precioCompra" class="form-label">Precio de Compra</label>
                <input type="number" class="form-control" id="precioCompra" name="precioCompra" required>
            </div>
            <div class="mb-3">
                <label for="precioVenta" class="form-label">Precio de Venta</label>
                <input type="number" class="form-control" id="precioVenta" name="precioVenta" required>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <select class="form-select" id="marca" name="marca" required>
                    <option value="101">Whirlpool</option>
                    <option value="102">Kalley</option>
                    <option value="103">LG</option>
                    <option value="104">Samsung</option>
                    <option value="105">Challenger</option>
                    <option value="106">DJI</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="201">Nevera</option>
                    <option value="202">Lavadora</option>
                    <option value="203">Televisores</option>
                    <option value="204">Audio</option>
                    <option value="205">Drones</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
        </form>
    </div>
</body>
</html>
