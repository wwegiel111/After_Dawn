<?php
session_start();

if (isset($_POST['login'])) {
    // Pobranie wprowadzonej nazwy użytkownika i hasła
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Połączenie z bazą danych MySQL
    $conn = mysqli_connect('localhost', 'username', 'password', 'database');

    // Zabezpieczenie przed atakami SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Pobranie hasła z bazy danych dla wprowadzonej nazwy użytkownika
    $query = "SELECT password FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Sprawdzenie czy hasło wprowadzone przez użytkownika jest poprawne
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header('Location: game.php');
            exit();
        }
    }

    // Wyświetlenie błędu logowania
    $error = "Niepoprawna nazwa użytkownika lub hasło.";
}
?>

<div class="login-container">
  <form class="login-form" method="post" action="login.php">
    <h2>Logowanie</h2>
    <?php if (isset($error)): ?>
    <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <div class="form-group">
      <label for="username">Nazwa użytkownika:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Hasło:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn-login" name="login">Zaloguj się</button>
  </form>
</div>
