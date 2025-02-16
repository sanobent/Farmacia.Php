<?php
// Conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$db = "farmacia";
$con = new mysqli($host, $usuario, $contraseña, $db);

if ($con->connect_error) {
    die("La conexión falló: " . $con->connect_error);
}

// Cargar datos
if (isset($_POST["cargar"])) {
    $formacion = isset($_POST["formacion"]) ? implode(", ", $_POST["formacion"]) : '';

    $apellidos = $_POST["apellidos"];
    $nombres = $_POST["nombres"];
    $dni = $_POST["dni"];
    $puesto = $_POST["puesto"];
    $departamento = $_POST["departamento"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $genero = $_POST["genero"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $estado_civil = $_POST["estado_civil"];
    $nacionalidad = $_POST["nacionalidad"];
    $experiencia_laboral = $_POST["experiencia_laboral"];
    $habilidades = $_POST["habilidades"];
    $salario = $_POST["salario"];
    $horario_trabajo = $_POST["horario_trabajo"];
    $estado_empleo = $_POST["estado_empleo"];

    $consulta = "INSERT INTO empleados (apellidos, nombres, dni, puesto, departamento, fecha_ingreso, fecha_nacimiento, genero, direccion, telefono, email, estado_civil, nacionalidad, formacion, experiencia_laboral, habilidades, salario, horario_trabajo, estado_empleo) 
                VALUES ('$apellidos', '$nombres', '$dni', '$puesto', '$departamento', '$fecha_ingreso', '$fecha_nacimiento', '$genero', '$direccion', '$telefono', '$email', '$estado_civil', '$nacionalidad', '$formacion', '$experiencia_laboral', '$habilidades', '$salario', '$horario_trabajo', '$estado_empleo')";

    if ($con->query($consulta) === TRUE) {
        echo "Datos cargados correctamente. Será redirigido automáticamente en 3 segundos";
        header("Refresh:3; url=empleados.html");
    } else {
        echo "Error al cargar los datos: " . $con->error;
        header("Refresh:3; url=empleados.html");
    }
}

// Mostrar datos
if (isset($_POST["mostrar"])) {
    $cargar = "SELECT * FROM empleados";
    $consulta1 = $con->query($cargar);

    if ($consulta1->num_rows > 0) {
        echo "<table border='1'>
        <tr> 
            <th>id</th>
            <th>apellidos</th>
            <th>nombres</th>
            <th>dni</th>
            <th>puesto</th>
            <th>departamento</th>
            <th>fecha_ingreso</th>
            <th>fecha_nacimiento</th>
            <th>genero</th>
            <th>direccion</th>
            <th>telefono</th>
            <th>email</th>
            <th>estado_civil</th>
            <th>nacionalidad</th>
            <th>formacion</th>
            <th>experiencia_laboral</th>
            <th>habilidades</th>
            <th>salario</th>
            <th>horario_trabajo</th>
            <th>estado_empleo</th>
        </tr>";

        while ($row = $consulta1->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['apellidos']}</td>
                <td>{$row['nombres']}</td>
                <td>{$row['dni']}</td>
                <td>{$row['puesto']}</td>
                <td>{$row['departamento']}</td>
                <td>{$row['fecha_ingreso']}</td>
                <td>{$row['fecha_nacimiento']}</td>
                <td>{$row['genero']}</td>
                <td>{$row['direccion']}</td>
                <td>{$row['telefono']}</td>
                <td>{$row['email']}</td>
                <td>{$row['estado_civil']}</td>
                <td>{$row['nacionalidad']}</td>
                <td>{$row['formacion']}</td>
                <td>{$row['experiencia_laboral']}</td>
                <td>{$row['habilidades']}</td>
                <td>{$row['salario']}</td>
                <td>{$row['horario_trabajo']}</td>
                <td>{$row['estado_empleo']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No hay datos para mostrar. Será redirigido al inicio en 3 segundos";
        header("Refresh:3; url=empleados.html");
    }
}

// Modificar datos 
if (isset($_POST["modificar"])) {
    echo "<form action='empleados.php' method='POST'>
        <label for='idmod'>Ingrese ID a modificar:</label>
        <input type='number' name='idmod' required>
        <label for='valor'>Seleccione el campo a modificar:</label>
        <select name='valor' id='valor' required>
            <option value='apellidos'>Apellidos</option>
            <option value='nombres'>Nombres</option>
            <option value='dni'>DNI</option>
            <option value='puesto'>Puesto</option>
            <option value='departamento'>Departamento</option>
            <option value='fecha_ingreso'>Fecha de Ingreso</option>
            <option value='fecha_nacimiento'>Fecha de Nacimiento</option>
            <option value='genero'>Género</option>
            <option value='direccion'>Dirección</option>
            <option value='telefono'>Teléfono</option>
            <option value='email'>Email</option>
            <option value='estado_civil'>Estado Civil</option>
            <option value='nacionalidad'>Nacionalidad</option>
            <option value='formacion'>Formación</option>
            <option value='experiencia_laboral'>Experiencia Laboral</option>
            <option value='habilidades'>Habilidades</option>
            <option value='salario'>Salario</option>
            <option value='horario_trabajo'>Horario de Trabajo</option>
            <option value='estado_empleo'>Estado de Empleo</option>
        </select>
        <input type='submit' name='chequeo' value='Aceptar'>
    </form>";
}

// Mostrar formulario para actualizar el campo seleccionado
if (isset($_POST["chequeo"])) {
    $opcion = $_POST["valor"];
    $idmod = $_POST["idmod"];

    // Verificar si el ID existe
    $consulta = "SELECT * FROM empleados WHERE id='$idmod'";
    $resultado = $con->query($consulta);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        echo "<form action='empleados.php' method='POST'>";
        echo "<input type='hidden' name='idmod' value='$idmod'>";
        echo "<input type='hidden' name='valor' value='$opcion'>";  // Aquí se guarda el campo a modificar

        switch ($opcion) {
            case "apellidos":
                echo "<label for='apellidos'>Nuevo Apellido:</label>";
                echo "<input type='text' name='apellidos' value='{$fila['apellidos']}' required>";
                break;
            case "nombres":
                echo "<label for='nombres'>Nuevo Nombre:</label>";
                echo "<input type='text' name='nombres' value='{$fila['nombres']}' required>";
                break;
            case "dni":
                echo "<label for='dni'>Nuevo DNI:</label>";
                echo "<input type='text' name='dni' value='{$fila['dni']}' required>";
                break;
            case "puesto":
                echo "<label for='puesto'>Nuevo Puesto:</label>";
                echo "<input type='text' name='puesto' value='{$fila['puesto']}' required>";
                break;
            case "departamento":
                echo "<label for='departamento'>Nuevo Departamento:</label>";
                echo "<input type='text' name='departamento' value='{$fila['departamento']}' required>";
                break;
            case "fecha_ingreso":
                echo "<label for='fecha_ingreso'>Nueva Fecha de Ingreso:</label>";
                echo "<input type='date' name='fecha_ingreso' value='{$fila['fecha_ingreso']}' required>";
                break;
            case "fecha_nacimiento":
                echo "<label for='fecha_nacimiento'>Nueva Fecha de Nacimiento:</label>";
                echo "<input type='date' name='fecha_nacimiento' value='{$fila['fecha_nacimiento']}' required>";
                break;
            case "genero":
                echo "<label for='genero'>Nuevo Género:</label>";
                echo "<input type='text' name='genero' value='{$fila['genero']}' required>";
                break;
            case "direccion":
                echo "<label for='direccion'>Nueva Dirección:</label>";
                echo "<input type='text' name='direccion' value='{$fila['direccion']}' required>";
                break;
            case "telefono":
                echo "<label for='telefono'>Nuevo Teléfono:</label>";
                echo "<input type='text' name='telefono' value='{$fila['telefono']}' required>";
                break;
            case "email":
                echo "<label for='email'>Nuevo Email:</label>";
                echo "<input type='email' name='email' value='{$fila['email']}' required>";
                break;
            case "estado_civil":
                echo "<label for='estado_civil'>Nuevo Estado Civil:</label>";
                echo "<input type='text' name='estado_civil' value='{$fila['estado_civil']}' required>";
                break;
            case "nacionalidad":
                echo "<label for='nacionalidad'>Nueva Nacionalidad:</label>";
                echo "<input type='text' name='nacionalidad' value='{$fila['nacionalidad']}' required>";
                break;
            case "formacion":
                echo "<label for='formacion'>Nueva Formación:</label>";
                echo "<input type='text' name='formacion' value='{$fila['formacion']}' required>";
                break;
            case "experiencia_laboral":
                echo "<label for='experiencia_laboral'>Nueva Experiencia Laboral:</label>";
                echo "<input type='text' name='experiencia_laboral' value='{$fila['experiencia_laboral']}' required>";
                break;
            case "habilidades":
                echo "<label for='habilidades'>Nuevas Habilidades:</label>";
                echo "<input type='text' name='habilidades' value='{$fila['habilidades']}' required>";
                break;
            case "salario":
                echo "<label for='salario'>Nuevo Salario:</label>";
                echo "<input type='number' name='salario' value='{$fila['salario']}' required>";
                break;
            case "horario_trabajo":
                echo "<label for='horario_trabajo'>Nuevo Horario de Trabajo:</label>";
                echo "<input type='text' name='horario_trabajo' value='{$fila['horario_trabajo']}' required>";
                break;
            case "estado_empleo":
                echo "<label for='estado_empleo'>Nuevo Estado de Empleo:</label>";
                echo "<input type='text' name='estado_empleo' value='{$fila['estado_empleo']}' required>";
                break;
            default:
                echo "Opción no válida.";
        }

        echo "<input type='submit' name='actualizar' value='Actualizar'>";
        echo "</form>";
    } else {
        echo "No se encontró ningún empleado con el ID proporcionado.";
    }
}

// Actualizar el campo seleccionado
if (isset($_POST["actualizar"])) {
    $idmod = $_POST["idmod"];
    $opcion = $_POST["valor"];
    $nuevo_valor = $_POST[$opcion];

    $consulta = "UPDATE empleados SET $opcion='$nuevo_valor' WHERE id='$idmod'";

    if ($con->query($consulta) === TRUE) {
        echo "El registro se actualizó correctamente.";
        header("Refresh:3; url=empleados.html");
    } else {
        echo "Error al actualizar el registro: " . $con->error;
    }
}


?>