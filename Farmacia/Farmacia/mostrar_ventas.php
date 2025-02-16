<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$db = "farmacia";

$conn = new mysqli($servidor, $usuario, $contraseña, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT v.ID, v.FechaTransaccion, v.TipoFactura, v.NumeroFactura, s.nombre AS producto_nombre, 
v.CantidadVendida, v.PrecioUnitario, v.MetodoPago, c.NombreCompleto AS cliente_nombre, e.nombres AS vendedor_nombre, 
v.CanalVenta, v.Descuentos, v.Intereses, v.TotalVenta, v.PrecioDescuento, v.PrecioIntereses, v.PrecioTotal 
FROM ventas v
INNER JOIN empleados e ON v.IDVendedor = e.id
INNER JOIN clientes c ON v.IDCliente = c.id
INNER JOIN stocks s ON v.ProductoVendido = s.id";

$result = $conn->query($sql);

// Verifica si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Ventas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <h1>Listado de Ventas</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
            <th>ID</th>
            <th>Fecha de Transacción</th>
            <th>Tipo de Factura</th>
            <th>Número de Factura</th>
            <th>Nombre del Producto</th>
            <th>Cantidad Vendida</th>
            <th>Precio Unitario</th>
            <th>Método de Pago</th>
            <th>Nombre del Cliente</th>
            <th>Nombre del Vendedor</th>
            <th>Canal de Venta</th>
            <th>Descuentos</th>
            <th>Intereses</th>
            <th>Total de Venta</th>
            <th>Precio de Descuento</th>
            <th>Precio de Intereses</th>
            <th>Precio Total</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["ID"]) . "</td>
                <td>" . htmlspecialchars($row["FechaTransaccion"]) . "</td>
                <td>" . htmlspecialchars($row["TipoFactura"]) . "</td>
                <td>" . htmlspecialchars($row["NumeroFactura"]) . "</td>
                <td>" . htmlspecialchars($row["producto_nombre"]) . "</td>
                <td>" . htmlspecialchars($row["CantidadVendida"]) . "</td>
                <td>" . htmlspecialchars($row["PrecioUnitario"]) . "</td>
                <td>" . htmlspecialchars($row["MetodoPago"]) . "</td>
                <td>" . htmlspecialchars($row["cliente_nombre"]) . "</td>
                <td>" . htmlspecialchars($row["vendedor_nombre"]) . "</td>
                <td>" . htmlspecialchars($row["CanalVenta"]) . "</td>
                <td>" . htmlspecialchars($row["Descuentos"]) . "</td>
                <td>" . htmlspecialchars($row["Intereses"]) . "</td>
                <td>" . htmlspecialchars($row["TotalVenta"]) . "</td>
                <td>" . htmlspecialchars($row["PrecioDescuento"]) . "</td>
                <td>" . htmlspecialchars($row["PrecioIntereses"]) . "</td>
                <td>" . htmlspecialchars($row["PrecioTotal"]) . "</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron ventas.";
    }

    $conn->close();
    ?>
</body>
</html>
