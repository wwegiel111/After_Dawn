
<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: register.html');
    exit;
}

// Dane do połączenia z bazą danych After
$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'After';

// Nawiązanie połączenia z bazą danych
$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Dodawanie nowej lokacji do bazy danych
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = $_POST['nazwa'];
    $opis = $_POST['opis'];
    $obrazek = $_FILES['obrazek']['name'];
    $dzwiek = $_FILES['dzwiek']['name'];


    // Dodanie danych do tabeli lokacje
    $sql = "INSERT INTO lokacje (nazwa, opis, obrazek, dzwiek) VALUES ('$nazwa', '$opis', '$obrazek', '$dzwiek')";
    if ($conn->query($sql) === TRUE) {
        echo "Lokacja została dodana.";
    } else {
        echo "Błąd podczas dodawania lokacji: " . $conn->error;
    }
}

$conn->close();
?>
