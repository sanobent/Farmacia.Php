<?php

$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$db = "farmacia";
$conexion = new mysqli($host, $usuario, $contraseña, $db);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error); //die se utiliza para dar mensajes sobre errores
}

// Traemos los valores desde el formulario, no sin antes comprobar que no estén vacíos y estén definidos

    if (isset($_POST["mostrar_stock"])) {
        $cargar = "SELECT * FROM stock";

        // Ejecutamos la consulta
        $consulta1 = $conexion->query($cargar);

        if ($consulta1->num_rows > 0) { // Chequeamos que si al ejecutar la consulta, hay más de una fila

            echo "<table border='1'>";
            echo "<tr> <th>ID</th><th>Nombre</th> <th>Tipo</th> <th>Precio</th> <th>Metodo</th> <th>Iva</th><th>Stock</th><th>Ganancia</th> </tr>";

            while ($fila = $consulta1->fetch_assoc()) // Mientras haya una fila siguiente a la ejecución de la consulta...
            {
                echo "<tr>";
                echo "<td>" . $fila["id"] . "</td>";
                echo "<td>" . $fila["nombre"] . "</td>";
                echo "<td>" . $fila["tipo"] . "</td>";
                echo "<td>" . $fila["precio"] . "</td>";
                echo "<td>" . $fila["metodo"] . "</td>";
                echo "<td>" . $fila["iva"] . "</td>";
                echo "<td>" . $fila["stock"] . "</td>";
                echo "<td>" . $fila["ganancia"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "La tabla está vacía"; // Si no, que muestre que está vacía
        }
    }


if (isset($_POST["modificar"])) {

    echo "<form action='index.php' method='POST'>
            <label for='idmod'>Ingrese ID a modificar</label>
            <input type='text' name='idmod'>
            <select name='valor'>
                <option value='1'>ID</option>
                <option value='2'>Nombre</option>
                <option value='3'>Tipo de producto</option>
                <option value='4'>Precio costo</option>
                <option value='5'>Método de venta</option>
                <option value='6'>IVA 21</option>
                <option value='7'>Stock</option>
                <option value='8'>Porcentaje de ganancia</option>
            </select>
            <input type='submit' name='chequeo' value='Aceptar'>
          </form>";

    if (isset($_POST["modificar_stock"])) {
        $opcion = $_POST["valor"];
        switch ($opcion) {
            case '1':
                echo "<label for='idn'> Ingrese ID a modificar </label>";
                echo "<input type='text' name='idn'>";
                echo "<input type='submit' name='actualizar' value='Actualizar'>";
                $resultado = isset($_POST["idn"]);
                break;
            case '2':
                echo "<label for='nombren'> Ingrese nombre a modificar </label>";
                echo "<input type='text' name='nombren'>";
                echo "<input type='submit' name='actualizar' value='Actualizar'>";
                $resultado = isset($_POST["nombren"]);
                break;
            case '3':
                echo "<label for='tipon'> Ingrese tipo de producto a modificar </label>";
                echo "<input type='text' name='tipon'>";
                echo "<input type='submit' name='actualizar' value='Actualizar'>";
                $resultado = isset($_POST["tipon"]);
                break;
        }
    }
}

if (isset($_POST["actualizar_stock"])) {
    // Sanitizar los datos, es importante para prevenir inyecciones SQL
    $idmodificar = intval($_POST["idmod"]);
    $resultado = $conexion->real_escape_string($_POST["resultado"]);

}

// Cerrar la conexión
$conexion->close();

?>