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
    $tytul = $_POST['tytul'];
    $gatunek = $_POST['gatunek'];
    $autor = $_POST['autor'];
    $sql = "INSERT INTO ksiazki (tytul, gatunek, autor) VALUES ('$tytul', '$gatunek', '$autor')";
    $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $tytul = $_POST['tytul'];
    $gatunek = $_POST['gatunek'];
    $autor = $_POST['autor'];
    $sql = "UPDATE ksiazki SET tytul='$tytul', gatunek='$gatunek', autor='$autor' WHERE id='$id'";
    $conn->query($sql);
}

$sql = "SELECT ksiazki.id, ksiazki.tytul, ksiazki.gatunek, ksiazki.autor, autorzy.imie, autorzy.nazwisko FROM ksiazki JOIN autorzy ON ksiazki.autor = autorzy.id";
$result = $conn->query($sql);

echo "<h1>Książki</h1>";
echo "Dopisz Książkę";
echo "<form method='POST'>
        <input type='text' name='tytul' placeholder='Tytuł' required>
        <input type='text' name='gatunek' placeholder='Gatunek' required>
        <input type='number' name='autor' placeholder='ID autora' required>
        <input type='submit' name='add' value='Dodaj'>
      </form>";

      echo "Edytuj Książkę</br>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>
            <form method='POST' style='display:inline-block;'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='text' name='tytul' value='" . $row['tytul'] . "' required>
                <input type='text' name='gatunek' value='" . $row['gatunek'] . "' required>
                <input type='number' name='autor' value='" . $row['autor'] . "' required>
                <input type='submit' name='edit' value='Edytuj'>
            </form></br>
          </td>";
    echo "</tr>";
}
echo "</table>";
$conn->close();
?>
