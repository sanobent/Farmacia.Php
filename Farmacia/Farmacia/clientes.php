<?php

$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$db = "farmacia";
$con = new mysqli($host, $usuario, $contraseña, $db);

// Conexión a la base de datos
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

// Verificar si el formulario ha sido enviado
if (isset($_POST["cargar"])) {
    if (
        !empty($_POST["NombreCompleto"]) && !empty($_POST["Email"]) && !empty($_POST["Telefono"]) && 
        !empty($_POST["Genero"]) && !empty($_POST["DNI"]) && !empty($_POST["Preferencias"]) && 
        !empty($_POST["Intereses"]) && !empty($_POST["FechaRegistro"]) 
    ) {

        $NombreCompleto = $_POST["NombreCompleto"];
        $Email = $_POST["Email"];
        $Telefono = $_POST["Telefono"];
        $Genero = $_POST["Genero"];
        $DNI = $_POST["DNI"];
        $Preferencias = $_POST["Preferencias"];
        $Intereses = $_POST["Intereses"];
        $FechaRegistro = $_POST["FechaRegistro"];
       
        $consulta2 = "INSERT INTO clientes (NombreCompleto, Email, Telefono, Genero, DNI, Preferencias, Intereses, FechaRegistro)
                      VALUES ('$NombreCompleto', '$Email', '$Telefono', '$Genero', '$DNI', '$Preferencias', '$Intereses', '$FechaRegistro')";

        if ($con->query($consulta2) === TRUE) {
            echo "Datos cargados correctamente. ";
            echo "Será redirigido automáticamente en 3 segundos";
            header("Refresh:3; url=clientes.html");
        } else {
            echo "Error al cargar los datos: " . $con->error;
            echo "Será redirigido automáticamente en 3 segundos";
            header("Refresh:3; url=clientes.html");
        }
    } else {
        echo "Todos los campos obligatorios deben estar completados";
        header("Refresh:3; url=clientes.html");
    }
}

// Mostrar datos
if (isset($_POST["mostrar"])) {
    $cargar = "SELECT * FROM clientes";
    $consulta1 = $con->query($cargar);

    if ($consulta1->num_rows > 0) {
        echo "<table border='1'>
        <tr> 
            <th>ID</th>
            <th>NombreCompleto</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Genero</th>
            <th>DNI</th>
            <th>Preferencias</th>
            <th>Intereses</th>
            <th>FechaRegistro</th>
        </tr>";

        while ($row = $consulta1->fetch_assoc()) {
            echo "<tr>
                <td>{$row['ID']}</td>
                <td>{$row['NombreCompleto']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['Telefono']}</td>
                <td>{$row['Genero']}</td>
                <td>{$row['DNI']}</td>
                <td>{$row['Preferencias']}</td>
                <td>{$row['Intereses']}</td>
                <td>{$row['FechaRegistro']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No hay datos para mostrar. Será redirigido al inicio en 3 segundos";
        header("Refresh:3; url=clientes.html");
    }
}

// Modificar datos 
if (isset($_POST["modificar"])) {
    echo "<form action='clientes.php' method='POST'>
        <label for='idmod'>Ingrese ID a modificar:</label>
        <input type='number' name='idmod' required>
        <label for='valor'>Seleccione el campo a modificar:</label>
        <select name='valor' id='valor' required>
            <option value='2'>NombreCompleto</option>
            <option value='3'>Email</option>
            <option value='4'>Telefono</option>
            <option value='5'>Intereses</option>
        </select>
        <input type='submit' name='chequeo' value='Aceptar'>
    </form>";
}

// Mostrar formulario para actualizar el campo seleccionado
if (isset($_POST["chequeo"])) {
    $opcion = $_POST["valor"];
    $idmod = $_POST["idmod"];

    // Verificar si el ID existe
    $consulta = "SELECT * FROM clientes WHERE ID='$idmod'";
    $resultado = $con->query($consulta);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        echo "<form action='clientes.php' method='POST'>";
        echo "<input type='hidden' name='idmod' value='$idmod'>";

        switch ($opcion) {
            case "2":
                echo "<label for='NombreCompleto'>Nuevo nombre:</label>";
                echo "<input type='text' name='NombreCompleto' value='{$fila['NombreCompleto']}' required>";
                break;
            case "3":
                echo "<label for='Email'>Nuevo email:</label>";
                echo "<input type='text' name='Email' value='{$fila['Email']}' required>";
                break;
            case "4":
                echo "<label for='Telefono'>Nuevo Telefono:</label>";
                echo "<input type='number' name='Telefono' value='{$fila['Telefono']}' required>";
                break;
            case "5":
                echo "<label for='Intereses'>Modifique los intereses:</label>";
                echo "<input type='text' name='Intereses' value='{$fila['Intereses']}' required>";
                break;
            default:
                echo "<p>Opción no válida</p>";
                break;
        }
        echo "<input type='submit' name='actualizar' value='Actualizar'>";
        echo "</form>";
    } else {
        echo "El ID proporcionado no existe. Será redirigido al inicio en 3 segundos";
        header("Refresh:3; url=clientes.html");
    }
}

// Actualizar los datos en la base de datos
if (isset($_POST['actualizar'])) {
    $idmod = $_POST["idmod"];
    $NombreCompleto = $_POST["NombreCompleto"] ?? null;
    $Email = $_POST["Email"] ?? null;
    $Telefono = $_POST["Telefono"] ?? null;
    $Intereses = $_POST["Intereses"] ?? null;

    // Verificar si el id existe
    $consulta = "SELECT * FROM clientes WHERE ID='$idmod'";
    $resultado = $con->query($consulta);

    if ($resultado->num_rows > 0) {
        $campos = [];

        // Actualizar los campos modificados
        if ($NombreCompleto !== null) $campos[] = "NombreCompleto='$NombreCompleto'";
        if ($Email !== null) $campos[] = "Email='$Email'";
        if ($Telefono !== null) $campos[] = "Telefono='$Telefono'";
        if ($Intereses !== null) $campos[] = "Intereses='$Intereses'";

        if (!empty($campos)) {
            $query = "UPDATE clientes SET " . implode(',', $campos) . " WHERE ID='$idmod'";

            if ($con->query($query) === TRUE) {
                echo "Datos modificados correctamente. Será redirigido automáticamente en 3 segundos";
                header("Refresh:3; url=clientes.html");
            } else {
                echo "Error al modificar los datos: " . $con->error;
                echo "Será redirigido automáticamente en 3 segundos";
                header("Refresh:3; url=clientes.html");
            }
        } else {
            echo "No se seleccionó ningún campo para modificar. Será redirigido en 3 segundos";
            header("Refresh:3; url=clientes.html");
        }
    } else {
        echo "El ID proporcionado no existe. Será redirigido automáticamente en 3 segundos";
        header("Refresh:3; url=clientes.html");
    }
}

$con->close();
?>