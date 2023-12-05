
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "tienda";

[5:21 p. m., 5/12/2023] WICHO🤘🏻☠️: $conn = new mysqli($servername, $username, $password, $dbname);

// Comprueba la conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Función para crear un nuevo producto
function createProduct($name, $price, $description) {
    global $conn;
    
    $sql = "INSERT INTO productos (nombre, precio, descripcion) VALUES ('$name', '$price', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto creado con éxito.";
    } else {
        echo "Error al crear el producto: " . $conn->error;
    }
}

// Función para leer todos los productos
function readProducts() {
    global $conn;
    
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . ", Nombre: " . $row["nombre"] . ", Precio: $" . $row["precio"] . ", Descripción: " . $row["descripcion"] . "<br>";
        }
    } else {
        echo "No hay productos registrados.";
    }
}

// Función para actualizar un producto
function updateProduct($id, $name, $price, $description) {
    global $conn;
    
    $sql = "UPDATE productos SET nombre='$name', precio='$price', descripcion='$description' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado con éxito.";
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
}

// Función para eliminar un producto
function deleteProduct($id) {
    global $conn;
    
    $sql = "DELETE FROM productos WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado con éxito.";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}
?>
[5:25 p. m., 5/12/2023] WICHO🤘🏻☠️: $conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Product
if (isset($_POST['create'])) {
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("INSERT INTO productos (producto, precio, descripcion) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $producto, $precio, $descripcion);
    $stmt->execute();
    $stmt->close();
}

// Read Products
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Abarrotes</title>
</head>
<body>

    <h2>Productos en la Tienda</h2>

    <!-- Create Product Form -->
    <form method="post" action="">
        <label for="producto">Producto:</label>
        <input type="text" name="producto" required>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" step="0.01" required>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea>
        <button type="submit" name="create">Agregar Producto</button>
    </form>

    <!-- Display Products -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Descripción</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['producto']}</td>";
            echo "<td>{$row['precio']}</td>";
            echo "<td>{$row['descripcion']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>