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
    $sql = "INSERT INTO autorzy (imie, nazwisko) VALUES ('$imie', '$nazwisko')";
    $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $sql = "UPDATE autorzy SET imie='$imie', nazwisko='$nazwisko' WHERE id='$id'";
    $conn->query($sql);
}

$sql = "SELECT * FROM autorzy";
$result = $conn->query($sql);

echo "<h1>Autorzy</h1>";
echo "Dodaj Autora";
echo "<form method='POST'>
        <input type='text' name='imie' placeholder='Imię' required>
        <input type='text' name='nazwisko' placeholder='Nazwisko' required>
        <input type='submit' name='add' value='Dodaj'>
      </form>";


      echo "Eytuj Autora</br>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>
            <form method='POST' style='display:inline-block;'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='text' name='imie' value='" . $row['imie'] . "' required>
                <input type='text' name='nazwisko' value='" . $row['nazwisko'] . "' required>
                <input type='submit' name='edit' value='Edytuj'>
            </form></br>
          </td>";
    echo "</tr>";
}
echo "</table>";
$conn->close();
?>
