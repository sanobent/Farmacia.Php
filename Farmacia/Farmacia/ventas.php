<?php

 // Conexión a base de datos
 $servidor = "localhost";
 $usuario = "root";
 $contraseña = "";
 $db = "farmacia";

 $conn = new mysqli($servidor, $usuario, $contraseña, $db);

 //Verificar conexion
 if ($conn->connect_error) {
    die("Conexion fallida: " .$conn->connect_error);
 }

 if(isset($_POST["mostrarventas"])){
   header('Location: mostrar_ventas.php');
 }
 ?>

 <!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Registro de Ventas </title>
      <style>
        /*estilo del encabezado */
    @font-face {
        font-family: SANTELLO;
        src: url(SANTELLO.ttf);
    }
    *{
        margin: 0;
        padding: 0;
    }
    #stock{
        background-color: rgba(228, 202, 146, 0.945);
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
        margin: 0;
    }

    .titulo{
        text-align: center;
        color: rgba(228, 202, 146, 0.945);
        font-size: 80px; 
        font-weight: bold; 
        text-transform: uppercase; 
        letter-spacing: 2px;
        margin-bottom: 20px; 
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); 
    }

    .menu{
        margin: auto;
    }

    .menu ul{
        list-style-type: none;
        display: inline-flex;
    }

    .menu ul a{
        font-family: SANTELLO;
        font-size: 40px;
        color: rgb(255, 255, 255);
        text-decoration: none;
        text-shadow: 0 0 5px;
    }

    .menu ul li{
        margin:0px 40px;
    }

    #imgfarr{
        width: 15%;
    }

    .recuadro {
        border: 2px solid #0202022c;
        border-radius: 8px;
        padding: 7px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.527);
        padding-left: 10%;
        background-color:rgba(178, 159, 117, 0.779);
    }

    form {
        width: 1080px;
        background-color: rgba(228, 202, 146, 0.945);
        border-radius: 40px;
        box-sizing: border-box;
        text-align: center;
    }
    h1 {
        text-align: center;
        font-family: SANTELLO;
        color: rgb(255, 255, 255);
        font-size: 40px;
    }

    p{
        color: #ffffff;
    }
    label {
        display: block;
        margin: 5px 0 5px;
        color:  rgb(255, 255, 255);
    }
 input, select, textarea {
        width: 30%;
        padding: 5px;
        margin: 5px 0 10px;
        border: 1px solid #0a0a0a54;
        border-radius: 4px;
        box-sizing: border-box;
        text-align: center;    
    }

.boton {
        padding: 10px 10px;
        background-color: #ffffff;
        color:  rgba(228, 202, 146, 0.945);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        margin: 3px;
        width: 110px;
    }

    .boton:hover {
        background-color: #bdaf85;
    }
    /* Estilo del pie de página */
    footer {
        background-color: rgba(228, 202, 146, 0.945);
        padding: 20px;
        text-align: center;
    }

    footer p {
        color: #000000;
        font-size: 1em;
    }
</style>

</head>
<body>
      <script>
         function actualizarPrecio() {
            var select = document.getElemenById('ProductoVendido');
            var selectedOption = select.options[select.selectedIndex];
            var precioUnitario = selectOption.getAtribute('data-precio');

            document.getElementById('PrecioUnitario').value = precioUnitario;

         }
         </script>
         </head>
         <for>
            <header id="stock">
               <nav class="menu">
                  <ul>
                     <li><a href="index.html" target="_blank">Inicio</a></li>
                     <li><a href="stock.html" target="_blank">Stock</a></li>
                     <li><a href="ventas.php" target="_blank">Ventas</a></li>
                     <li><a href="empleados.html" target="_blank">Empleados</a></li>
                     <li><a href="clientes.html" target="_blank">Clientes</a></li>
      </ul>
      </nav>
      <img src="ventas.webp" alt="ventas" id="imgfarr">
      </header>

      <h1 class="titulo"> Farmacia </h1>
        

            <div class="recuadro">
      <main>
         <form action="ventas.php" method="POST">
            <class="recuadro">
            <h1>Formulario de Ventas</h1>
               <label for="IDTransaccion">ID de transaccion</label>
               <input type="text" name="IDTransaccion" id="IDTransaccion" placeholder="Se genera automaticamente" disabled>
   
         <label for="fechaTransaccion">Fecha de la Transaccion</label>
         <input type="datetime-local" name="FechaTransaccion" id="FechaTransaccion">
     
         <label for="TipoFactura">Tipo de Factura o Ticket</label>
         <select name="TipoFactura" id="TipoFactura">
            <option value="">Seleccione una opcion</option>
            <option value="Factura">Factura</option>
            <option value="Ticket">Ticket</option>
      </select>
   
         <label for="NumeroFactura">Numero de Factura o Ticket</label>
         <input type="text" name="NumeroFactura" id="NumeroFactura">
     
         <label for="ProductoVendido">Producto(s) Vendido(s)</label>
         <select name="ProductoVendido" id="ProductoVendido" onchange="actualizarPrecio()"
         <option value="">Seleccione un producto</option>
         <?php
         $sql = "SELECT id, nombre, marca, precio FROM stocks";
         $result = $conn->query($sql);

         if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               echo '<option value="' . $row["id"]. '" data-precio="' . $row["precio"] . '">' . $row["nombre"] . ' ' . $row["marca"] . ' ' . $row["precio"] . '</option>';
            }
         } else {
            echo '<option value="">No hay productos disponibles</option>';
         }

         
         ?>

         </select>
      
         <label for="CantidadVendida">Cantidad Vendida</label>
         <input type="number" name="CantidadVendida" id="CantidadVendida">
      

         <label for="PrecioUnitario">Precio Unitario</label>
         <input type="number" name="PrecioUnitario" id="PrecioUnitario">
   

     
         <label for="MetodoPago">Metodo de pago</label>
         <select name="MetodoPago" id="MetodoPago">
            <option value="">Seleccione una opcion</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Tarjeta de Credito">Tarjeta de Credito</option>
            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
            <option value="Otro">Otro</option>
      </select>
      
         <label for="IDcliente">ID del cliente</label>
         <select name="IDCliente" id="IDCliente">
            <option value="">Seleccione un cliente</option>
            <?php
            $sql = "SELECT ID, NombreCompleto FROM clientes";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row["ID"] . '">' . $row["NombreCompleto"] . '</option>';
               }
            } else {
               echo '<option value="">No hay clientes disponibles</option>';
            }
            ?>
            </select>


        
            <label for="IDVendedor">ID del Vendedor</label>
            <select name="IDVendedor" id="IDVendedor">
               <option value="">Seleccione un vendedor</option>
               <?php 
               $sql = "SELECT ID, Apellidos, Nombres FROM empleados";
               $result = $conn->query($sql);

               if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                     echo '<option value="' . $row["ID"] . '">' . $row["Apellidos"] . ' ' . $row["Nombres"] . '</option>';
                  }
               } else {
                  echo '<option value="">No hay vendedor disponibles</option>';
               }
               ?>
               </select>
        

          
               <label for="CanalVenta">Canal de Venta</label>
               <select name="CanalVenta" id="CanalVenta">
                  <option value="">Seleccione una opcion</option>
                  <option value="Tienda Fisica">Tienda Fisica</option>
                  <option value="Tienda en Linea">Tienda en Linea</option>
                  <option value="Telefono">Telefono</option>
                  <option value="Otro">Otro</option>
            </select>
           

         
               <label for="Descuentos">Descuentos (%)</label>
               <input type="number" name="Descuentos" id="Descuentos" placeholder="En porcentaje">
       

               <label for="Intereses">Intereses (%)</label>
               <input type="number" name="Intereses" id="Intereses" placeholder="En porcentaje">
         <br>
             
               <input type="submit" name="cargarventas" value="Cargar" class="boton">
               <input type="submit" name="mostrarventas" value="Mostrar" class="boton" >

               </main>
            </div> 
               <footer>
               <p id="pie"> @Valentina R. y @Santiago T.
                <br>
                Diseño web dinamico 2024, 7°2
            </p>
    </footer>
            
            </form>
            
        
            <script>
        function actualizarPrecio() {
            var select = document.getElementById('ProductoVendido');
            var precio = select.options[select.selectedIndex].getAttribute('data-precio');
            document.getElementById('PrecioUnitario').value = precio;
        }
    </script>
</body>
</html>

<?php
// funcion para cargar datos
if (isset($_POST['cargarventas'])) {
   if (!empty($_POST['FechaTransaccion']) && !empty($_POST['TipoFactura']) && !empty($_POST['NumeroFactura']) && !empty($_POST['ProductoVendido']) &&  !empty($_POST['CantidadVendida']) &&  !empty($_POST['PrecioUnitario']) &&  
   !empty($_POST['MetodoPago']) &&  !empty($_POST['IDCliente']) && !empty($_POST['IDVendedor']) &&  !empty($_POST['CanalVenta']) &&  !empty($_POST['Descuentos']) &&  !empty($_POST['Intereses'])){

   $FechaTransaccion = $_POST['FechaTransaccion'];
   $TipoFactura = $_POST['TipoFactura'];
   $NumeroFactura = $_POST['NumeroFactura'];
   $ProductoVendido = $_POST['ProductoVendido']; // ID del producto
   $CantidadVendida = $_POST['CantidadVendida'];
   $PrecioUnitario = $_POST['PrecioUnitario'];
   $MetodoPago = $_POST['MetodoPago'];
   $IDCliente = $_POST['IDCliente']; // ID del cliente
   $IDVendedor = $_POST['IDVendedor']; // ID del vendedor
   $CanalVenta = $_POST['CanalVenta'];
   $Descuentos = $_POST['Descuentos'];
   $Intereses = $_POST['Intereses'];

   // Calcular el totalVenta, precioDescuento, precioIntereses y precioTotal
   $TotalVenta = $PrecioUnitario * $CantidadVendida;
   $PrecioDescuento = $TotalVenta* ($Descuentos / 100);
   $PrecioIntereses = $TotalVenta * ($Intereses / 100);
   $PrecioTotal = $TotalVenta - $PrecioDescuento + $PrecioIntereses;

   $sql = "INSERT INTO ventas(ID, FechaTransaccion, TipoFactura, NumeroFactura, ProductoVendido, 
   CantidadVendida, PrecioUnitario, MetodoPago, IDCliente, IDVendedor, CanalVenta, Descuentos, 
   Intereses, TotalVenta, PrecioDescuento, PrecioIntereses, PrecioTotal) 
   VALUES ('','$FechaTransaccion','$TipoFactura','$NumeroFactura','$ProductoVendido','$CantidadVendida','$PrecioUnitario',
   '$MetodoPago','$IDCliente','$IDVendedor','$CanalVenta','$Descuentos','$Intereses','$TotalVenta',
   '$PrecioDescuento','$PrecioDescuento','$PrecioTotal')";

if ($conn->query($sql) === TRUE) {
    // Actualizar el stock
    $actualizarStock = "UPDATE stocks SET disp = disp - $CantidadVendida WHERE id = $ProductoVendido";
    $query = mysqli_query($conn, $actualizarStock);

    if ($query) {
        echo "Venta realizada exitosamente y stock actualizado.";
    } else {
        echo "Error al actualizar el stock: " . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
} else {
echo "Por favor, complete todos los campos.";
}
}



// funcion para mostrar datos
if (isset($_POST['mostarventas'])){
   $sql = "SELECT * FROM ventas";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      echo "<table border='1'>";
      echo "<tr><th>ID</th><th>Fecha de Transaccion</th><th>Tipo de Factura</th><th>Numero de Factura</th><th>Producto Vendido</th><th>Cantidad Vendida</th><th>Precio Unitario</th><th>Metodo de Pago</th><th>ID de Cliente</th><th>ID de Vendedor</th><th>Canal de Venta</th><th>Descuentos</th><th>Intereses</th><th>Total de Venta</th><th>Precio de Descuento</th><th>Precio de Intereses</th><th>Precio Total</th></tr>";

      while ($row = $result->fetch_assoc()){
         echo "<tr>";
         echo "<td>" . $row["ID"] . "</td>";
         echo "<td>" . $row["FechaTransaccion"] . "</td>";
         echo "<td>" . $row["TipoFactura"] . "</td>";
         echo "<td>" . $row["NumeroFactura"] . "</td>";
         echo "<td>" . $row["ProductoVendido"] . "</td>";
         echo "<td>" . $row["CantidadVendida"] . "</td>";
         echo "<td>" . $row["PrecioUnitario"] . "</td>";
         echo "<td>" . $row["MetodoPago"] . "</td>";
         echo "<td>" . $row["IDCliente"] . "</td>";
         echo "<td>" . $row["IDVendedor"] . "</td>";
         echo "<td>" . $row["CanalVenta"] . "</td>";
         echo "<td>" . $row["Descuentos"] . "</td>";
         echo "<td>" . $row["Intereses"] . "</td>";
         echo "<td>" . $row["TotalVenta"] . "</td>";
         echo "<td>" . $row["PrecioDescuento"] . "</td>";
         echo "<td>" . $row["PrecioIntereses"] . "</td>";
         echo "<td>" . $row["PrecioTotal"] . "</td>";
         echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "No se encontraron ventas.";
    }
}

// Mostrar datos
if (isset($_POST["mostrar"])) 

{
   $cargar = "SELECT * FROM ventas";
   $consulta1 = $conn->query($cargar);

   

   if ($consulta1->num_rows > 0) {
       echo "<table border='1'>
       <tr> 
           <th>ID</th>
           <th>FechaTransaccion</th>
           <th>TipoFactura</th>
           <th>NumeroFactura</th>
           <th>ProductoVendido</th>
           <th>CantidadVendida</th>
           <th>PrecioUnitario</th>
           <th>MetodoPago</th>
           <th>IDCliente</th>
           <th>IDVendedor</th>
           <th>CanalVenta</th>
           <th>Descuentos</th>
           <th>Intereses</th>
           <th>TotalVenta</th>
           <th>PrecioDescuento</th>
           <th>PrecioIntereses</th>
       </tr>";

       while ($row = $consulta1->fetch_assoc()) {
           echo "<tr>
               <td>{$row['ID']}</td>
               <td>{$row['FechaTransaccion']}</td>
               <td>{$row['TipoFactura']}</td>
               <td>{$row['NumeroFactura']}</td>
               <td>{$row['ProductoVendido']}</td>
               <td>{$row['CantidadVendida']}</td>
               <td>{$row['PrecioUnitario']}</td>
               <td>{$row['MetodoPago']}</td>
               <td>{$row['IDCliente']}</td>
               <td>{$row['IDVendedor']}</td>
               <td>{$row['CanalVenta']}</td>
               <td>{$row['Descuentos']}</td>
               <td>{$row['Intereses']}</td>
               <td>{$row['TotalVenta']}</td>
               <td>{$row['PrecioDescuento']}</td>
               <td>{$row['PrecioIntereses']}</td>

           </tr>";
       }
       echo "</table>";
   } else {
       echo "No hay datos para mostrar. Será redirigido al inicio en 3 segundos";
       header("Refresh:3; url=ventas.php");
   }
}

$conn->close();
?>