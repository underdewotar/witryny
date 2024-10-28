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
    $id_ksiazki = $_POST['id_ksiazki'];
    $id_klienta = $_POST['id_klienta'];
    $data_od = $_POST['data_od'];
    $data_do = $_POST['data_do'];
    $zwrocono = isset($_POST['zwrocono']) ? 1 : 0;
    $sql = "INSERT INTO wypozyczenia (id_ksiazki, id_klienta, data_od, data_do, zwrocono) VALUES ('$id_ksiazki', '$id_klienta', '$data_od', '$data_do', '$zwrocono')";
    $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $id_ksiazki = $_POST['id_ksiazki'];
    $id_klienta = $_POST['id_klienta'];
    $data_od = $_POST['data_od'];
    $data_do = $_POST['data_do'];
    $zwrocono = isset($_POST['zwrocono']) ? 1 : 0;
    $sql = "UPDATE wypozyczenia SET id_ksiazki='$id_ksiazki', id_klienta='$id_klienta', data_od='$data_od', data_do='$data_do', zwrocono='$zwrocono' WHERE id='$id'";
    $conn->query($sql);
}

$sql = "SELECT wypozyczenia.id, wypozyczenia.id_ksiazki, wypozyczenia.id_klienta, ksiazki.tytul, klienci.imie, klienci.nazwisko, wypozyczenia.data_od, wypozyczenia.data_do, wypozyczenia.zwrocono FROM wypozyczenia JOIN ksiazki ON wypozyczenia.id_ksiazki = ksiazki.id JOIN klienci ON wypozyczenia.id_klienta = klienci.id";
$result = $conn->query($sql);

echo "<h1>Wypożyczenia</h1>";
echo "Dodaj Wypożyczenie";
echo "<form method='POST'>
        <input type='number' name='id_ksiazki' placeholder='ID książki' required>
        <input type='number' name='id_klienta' placeholder='ID klienta' required>
        <input type='date' name='data_od' placeholder='Data wypożyczenia' required>
        <input type='date' name='data_do' placeholder='Data zwrotu' required>
        <label for='zwrocono'>Zwrocono</label>
        <input type='checkbox' name='zwrocono'>
        <input type='submit' name='add' value='Dodaj'>
      </form>";

      echo "Edytuj Wypożyczane</br>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>
            <form method='POST' style='display:inline-block;'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='number' name='id_ksiazki' value='" . $row['id_ksiazki'] . "' required>
                <input type='number' name='id_klienta' value='" . $row['id_klienta'] . "' required>
                <input type='date' name='data_od' value='" . $row['data_od'] . "' required>
                <input type='date' name='data_do' value='" . $row['data_do'] . "' required>
                <label for='zwrocono'>Zwrocono</label>
                <input type='checkbox' name='zwrocono' " . ($row['zwrocono'] ? 'checked' : '') . ">
                <input type='submit' name='edit' value='Edytuj'>
            </form></br>
          </td>";
    echo "</tr>";
}
echo "</table>";
$conn->close();
?>
