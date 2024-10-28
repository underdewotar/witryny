<link rel="stylesheet" href="styl.css">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wypozyczalnia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $adres = $_POST['adres'];
    $data_zalozenia = $_POST['data_zalozenia'];

    $sql = "INSERT INTO klienci (imie, nazwisko, adres, data_zalozenia) VALUES ('$imie', '$nazwisko', '$adres', '$data_zalozenia')";
    $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $adres = $_POST['adres'];
    $data_zalozenia = $_POST['data_zalozenia'];

    $sql = "UPDATE klienci SET imie='$imie', nazwisko='$nazwisko', adres='$adres', data_zalozenia='$data_zalozenia' WHERE id='$id'";
    $conn->query($sql);
}

$sql = "SELECT * FROM klienci";
$result = $conn->query($sql);

echo "<h1>Klienci</h1>";
echo "Dodaj Klienta";
echo "<form method='POST'>
        <input type='text' name='imie' placeholder='Imię' required>
        <input type='text' name='nazwisko' placeholder='Nazwisko' required>
        <input type='text' name='adres' placeholder='Adres' required>
        <input type='date' name='data_zalozenia' placeholder='Data założenia' required>
        <input type='submit' name='add' value='Dodaj'>
      </form>";

      echo "Klienci</br>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>
            <form method='POST' style='display:inline-block;'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='text' name='imie' value='" . $row['imie'] . "' required>
                <input type='text' name='nazwisko' value='" . $row['nazwisko'] . "' required>
                <input type='text' name='adres' value='" . $row['adres'] . "' required>
                <input type='date' name='data_zalozenia' value='" . $row['data_zalozenia'] . "' required>
                <input type='submit' name='edit' value='Edytuj'>
            </form>
          </td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
