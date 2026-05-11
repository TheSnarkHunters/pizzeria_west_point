<?php 
include "config/db.php";

// Recupero tutti gli allergeni per mostrarli nel form dopo
$allergeni_result = $conn->query("SELECT * FROM allergeni");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Inserisco il piatto
    $stmt = $conn->prepare("INSERT INTO piatti (nome, descrizione, prezzo) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $_POST["nome"], $_POST["descrizione"], $_POST["prezzo"]);
    
    if ($stmt->execute()) {
        // Recupero l'ID del piatto appena creato
        $piatto_id = $stmt->insert_id;

        // 2. Se sono stati selezionati allergeni, li associo
        if (!empty($_POST["allergeni"])) {
            foreach($_POST["allergeni"] as $allergene_id) {
                $stmt2 = $conn->prepare("INSERT INTO piatti_allergeni (id_piatto, id_allergeni) VALUES (?, ?)");
                $stmt2->bind_param("ii", $piatto_id, $allergene_id);
                $stmt2->execute();
            }
        }
        echo "Piatto inserito con successo!";
    } else {
        echo "Errore nell'inserimento del piatto.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="css/style.css">
  <title>Pizzeria West Point</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Bangers&family=Bruno+Ace+SC&family=Cabin:ital,wght@0,400..700;1,400..700&family=Esteban&family=Raleway:ital,wght@0,100..900;1,100..900&family=Unica+One&display=swap" rel="stylesheet">
    <style>
  h1 {
	  font-family: "Unica One", sans-serif;
	  font-weight: 400;
	  font-style: normal;
	  background-color: red;
  }
  h2 {
  font-family: "Bruno Ace SC", sans-serif;
  font-weight: 400;
  font-style: normal;
}
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  </head>
<body>

 
<nav>
  <h2>Pizzeria West Point</h2>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="chi-siamo.html">Chi siamo</a></li>
    <li><a href="menu.html">Menù</a></li>
    <li><a href="crud/lista.php">Prodotti</a></li> <!-- Inserito nel li -->
    <li><a href="galleria.html">Galleria</a></li>
    <li><a href="contatti.html">Contatti</a></li>
    <li><a href="crud/inserisci.php">Inserisci</a></li> <!-- Inserito nel li -->
  </ul>
</nav>
<br>
<form method="POST">
    <label>Nome Piatto:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Descrizione:</label><br>
    <textarea name="descrizione"></textarea><br><br>

    <label>Prezzo:</label><br>
    <input type="number" step="0.01" name="prezzo" required><br><br>

    <label>Allergeni:</label><br>
    <?php while($row = $allergeni_result->fetch_assoc()): ?>
        <input type="checkbox" name="allergeni[]" value="<?php echo $row['id']; ?>">
        <?php echo htmlspecialchars($row['nome']); ?><br>
    <?php endwhile; ?>

    <br>
    <button type="submit">Salva Piatto</button>
</form>