<?php

$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$db = "farmacia";
$con = new mysqli($host, $usuario, $contraseña, $db);

if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

if (isset($_POST["cargar"])) {
    if (
        !empty($_POST["nombre"]) && !empty($_POST["marca"]) && !empty($_POST["categoria"]) && 
        !empty($_POST["principio_activo"]) && !empty($_POST["concentracion"]) && !empty($_POST["forma_farmaceutica"]) && 
        !empty($_POST["presentacion"]) && !empty($_POST["fecha_caducidad"]) && !empty($_POST["registro_sanitario"]) && 
        !empty($_POST["iva"]) && !empty($_POST["precio"]) && !empty($_POST["disp"]) && !empty($_POST["codigo_barras"])
    ) {

        $nombre = $_POST["nombre"];
        $marca = $_POST["marca"];
        $categoria = $_POST["categoria"];
        $principio_activo = $_POST["principio_activo"];
        $concentracion = $_POST["concentracion"];
        $forma_farmaceutica = $_POST["forma_farmaceutica"];
        $presentacion = $_POST["presentacion"];
        $fecha_caducidad = $_POST["fecha_caducidad"];
        $registro_sanitario = $_POST["registro_sanitario"];
        $iva = $_POST["iva"];
        $precio = $_POST["precio"];
        $stock = $_POST["disp"];
        $codigo_barras = $_POST["codigo_barras"];

        // Calcular IVA
        $iva4 = 0;
        $iva10 = 0;
        switch ($iva) {
            case '4':
                $iva4 = 0.04 * $precio;
                break;
            case '10.5':
                $iva10 = 0.105 * $precio;
                break;
            default:
                $iva4 = 0;
                $iva10 = 0;
                break;
        }

        // Definir una ganancia (porcentaje de ganancia, por ejemplo 20%)
        $ganancia = 20; // Puedes ajustar esto según tus necesidades
        $ganancia_total = $precio * ($ganancia / 100); // División por 100

        // Calcular precio final
        $precio_final = $precio + $iva4 + $iva10 + $ganancia_total;

        // Consulta para insertar datos
        $consulta2 = "INSERT INTO stocks (nombre, marca, categoria, principio_activo, concentracion, forma_farmaceutica, presentacion, fecha_caducidad, registro_sanitario, iva, precio, disp, codigo_barras)
                      VALUES ('$nombre', '$marca', '$categoria', '$principio_activo', '$concentracion', '$forma_farmaceutica', '$presentacion', '$fecha_caducidad', '$registro_sanitario', '$iva', '$precio', '$stock', '$codigo_barras')";

        if ($con->query($consulta2) === TRUE) {
            echo "Datos cargados correctamente. ";
            echo "Será redirigido automáticamente en 3 segundos";
            header("Refresh:3; url=stock.html");
        } else {
            echo "Error al cargar los datos: " . $con->error;
            echo "Será redirigido automáticamente en 3 segundos";
            header("Refresh:3; url=stock.html");
        }
    } else {
        echo "Todos los campos obligatorios deben estar completados";
        header("Refresh:3; url=stock.html");
    }
}

// Mostrar datos
if (isset($_POST["mostrar"])) {
    $cargar = "SELECT * FROM stocks";
    $consulta1 = $con->query($cargar);

    if ($consulta1->num_rows > 0) {
        echo "<table border='1'>
        <tr> 
            <th>id</th>
            <th>nombre</th>
            <th>marca</th>
            <th>categoria</th>
            <th>principio_activo</th>
            <th>concentracion</th>
            <th>forma_farmaceutica</th>
            <th>presentacion</th>
            <th>fecha_caducidad</th>
            <th>registro_sanitario</th>
            <th>iva</th>
            <th>precio</th>
            <th>disp</th>
            <th>codigo_barras</th>
        </tr>";

        while ($row = $consulta1->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['marca']}</td>
                <td>{$row['categoria']}</td>
                <td>{$row['principio_activo']}</td>
                <td>{$row['concentracion']}</td>
                <td>{$row['forma_farmaceutica']}</td>
                <td>{$row['presentacion']}</td>
                <td>{$row['fecha_caducidad']}</td>
                <td>{$row['registro_sanitario']}</td>
                <td>{$row['iva']}</td>
                <td>{$row['precio']}</td>
                <td>{$row['disp']}</td>
                <td>{$row['codigo_barras']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No hay datos para mostrar. Será redirigido al inicio en 3 segundos";
        header("Refresh:3; url=stock.html");
    }
}

// Modificar datos 
if (isset($_POST["modificar"])) {
    echo "<form action='stock.php' method='POST'>
        <label for='idmod'>Ingrese ID a modificar:</label>
        <input type='number' name='idmod' required>
        <label for='valor'>Seleccione el campo a modificar:</label>
        <select name='valor' id='valor' required>
            <option value='2'>nombre</option>
            <option value='3'>marca</option>
            <option value='4'>categoria</option>
            <option value='5'>disp</option>
        </select>
        <input type='submit' name='chequeo' value='Aceptar'>
    </form>";
}

// Mostrar formulario para actualizar el campo seleccionado
if (isset($_POST["chequeo"])) {
    $opcion = $_POST["valor"];
    $idmod = $_POST["idmod"];

    // Verificar si el ID existe
    $consulta = "SELECT * FROM stocks WHERE id='$idmod'";
    $resultado = $con->query($consulta);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        echo "<form action='stock.php' method='POST'>";
        echo "<input type='hidden' name='idmod' value='$idmod'>";

        switch ($opcion) {
            case "2":
                echo "<label for='nombre'>Nuevo nombre:</label>";
                echo "<input type='text' name='nombre' value='{$fila['nombre']}' required>";
                break;
            case "3":
                echo "<label for='marca'>Nueva marca:</label>";
                echo "<input type='text' name='marca' value='{$fila['marca']}' required>";
                break;
            case "4":
                echo "<label for='categoria'>Nueva categoria:</label>";
                echo "<select name='categoria' required>
                    <option value='{$fila['categoria']}' selected>{$fila['categoria']}</option>
                    <option value='A'>analgesicos</option>
                    <option value='AN'>antibioticos</option>
                    <option value='V'>vitaminas</option>
                    <option value='P'>productos cuidado personal</option>
                </select>";
                break;
            case "5":
                echo "<label for='disp'>Modifique la disponibilidad:</label>";
                echo "<input type='number' name='disp' value='{$fila['disp']}' required>";
                break;
            default:
                echo "<p>Opción no válida</p>";
                break;
        }
        echo "<input type='submit' name='actualizar' value='Actualizar'>";
        echo "</form>";
    } else {
        echo "El ID proporcionado no existe. Será redirigido al inicio en 3 segundos";
        header("Refresh:3; url=stock.html");
    }
}

// Actualizar los datos en la base de datos
if (isset($_POST['actualizar'])) {
    $idmod = $_POST["idmod"];
    $nombre = $_POST["nombre"] ?? null;
    $marca = $_POST["marca"] ?? null;
    $categoria = $_POST["categoria"] ?? null;
    $disp = $_POST["disp"] ?? null;

    // Verificar si el id existe
    $consulta = "SELECT * FROM stocks WHERE id='$idmod'";
    $resultado = $con->query($consulta);

    if ($resultado->num_rows > 0) {
        $campos = [];

        // Actualizar los campos modificados
        if ($nombre !== null) $campos[] = "nombre='$nombre'";
        if ($marca !== null) $campos[] = "marca='$marca'";
        if ($categoria !== null) $campos[] = "categoria='$categoria'";
        if ($disp !== null) $campos[] = "disp='$disp'";

        if (!empty($campos)) {
            $query = "UPDATE stocks SET " . implode(',', $campos) . " WHERE id='$idmod'";

            if ($con->query($query) === TRUE) {
                echo "Datos modificados correctamente. Será redirigido automáticamente en 3 segundos";
                header("Refresh:3; url=stock.html");
            } else {
                echo "Error al modificar los datos: " . $con->error;
                echo "Será redirigido automáticamente en 3 segundos";
                header("Refresh:3; url=stock.html");
            }
        } else {
            echo "No se seleccionó ningún campo para modificar. Será redirigido en 3 segundos";
            header("Refresh:3; url=stock.html");
        }
    } else {
        echo "El ID proporcionado no existe. Será redirigido automáticamente en 3 segundos";
        header("Refresh:3; url=stock.html");
    }
}

$con->close();
?>