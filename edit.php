<?php
require_once "config.php";

// Get ID from URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch player data
$result = mysqli_query($conn, "SELECT * FROM players WHERE Player_ID='$id'");
$player = mysqli_fetch_assoc($result);

if (!$player) {
    echo "Player not found!";
    exit();
}

// Update player if form submitted
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = (int)$_POST['age'];
    $position = mysqli_real_escape_string($conn, $_POST['pos']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nlt']);
    $club = mysqli_real_escape_string($conn, $_POST['clb']);
    $goals = (int)$_POST['gl'];

    mysqli_query($conn, "UPDATE players 
                         SET Name='$name', Age=$age, Position='$position', 
                             Nationality='$nationality', Club='$club', Goals_scored=$goals 
                         WHERE Player_ID='$id'");

    header("Location: index.php?status=updated");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Player</title>
</head>
<body>
    <h2>Edit Player - <?php echo $player['Player_ID']; ?></h2>
    <form method="POST">
        Name: <input type="text" name="name" value="<?php echo $player['Name']; ?>" required><br><br>
        Age: <input type="number" name="age" value="<?php echo $player['Age']; ?>" required><br><br>
        Position: <input type="text" name="pos" value="<?php echo $player['Position']; ?>" required><br><br>
        Nationality: <input type="text" name="nlt" value="<?php echo $player['Nationality']; ?>" required><br><br>
        Club: <input type="text" name="clb" value="<?php echo $player['Club']; ?>" required><br><br>
        Goals Scored: <input type="number" name="gl" value="<?php echo $player['Goals_scored']; ?>" required><br><br>
        <input type="submit" name="update" value="Update Player">
    </form>
    <br>
    <a href="index.php">Back to List</a>
</body>
</html>
