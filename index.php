<?php
require_once "config.php";

// --- Delete player ---
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM players WHERE Player_ID='$id'");
    header("Location: index.php?status=deleted");
    exit();
}

// --- Add player (check duplicate) ---
if (isset($_POST['add']) && !empty($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = (int)$_POST['age'];
    $position = mysqli_real_escape_string($conn, $_POST['pos']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nlt']);
    $club = mysqli_real_escape_string($conn, $_POST['clb']);
    $goals = (int)$_POST['gl'];

    // check duplicate primary key
    $check = mysqli_query($conn, "SELECT * FROM players WHERE Player_ID='$id'");
    if (mysqli_num_rows($check) > 0) {
        header("Location: index.php?status=duplicate");
        exit();
    }

    mysqli_query($conn, "INSERT INTO players (Player_ID, Name, Age, Position, Nationality, Club, Goals_scored)
                         VALUES ('$id', '$name', $age, '$position', '$nationality', '$club', $goals)");
    header("Location: index.php?status=added");
    exit();
}

// --- Fetch all players ---
$result = mysqli_query($conn, "SELECT * FROM players");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Football Players Info</title>
</head>
<body>
    <h2>Football Players List</h2>
    <?php 
        if (isset($_GET['status'])) {
            echo "<p><b>Status: " . htmlspecialchars($_GET['status']) . "</b></p>";
        }
    ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Player_ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Position</th>
            <th>Nationality</th>
            <th>Club</th>
            <th>Goals_scored</th>
            <th>Actions</th>
        </tr>
        <?php 
        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['Player_ID']; ?></td>
                <td><?php echo $row['Name']; ?></td>
                <td><?php echo $row['Age']; ?></td>
                <td><?php echo $row['Position']; ?></td>
                <td><?php echo $row['Nationality']; ?></td>
                <td><?php echo $row['Club']; ?></td>
                <td><?php echo $row['Goals_scored']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['Player_ID']; ?>">Edit</a> |
                    <a href="index.php?delete=<?php echo $row['Player_ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php }} else {
            echo "<tr><td colspan='8'>No Data Available</td></tr>";
        } ?>
    </table>

    <h2>Add New Player</h2>
    <form action="" method="POST">
        Player ID: <input type="text" name="id" required><br><br>
        Name: <input type="text" name="name" required><br><br>
        Age: <input type="number" name="age" required><br><br>
        Position: <input type="text" name="pos" required><br><br>
        Nationality: <input type="text" name="nlt" required><br><br>
        Club: <input type="text" name="clb" required><br><br>
        Goals Scored: <input type="number" name="gl" required><br><br>
        <input type="submit" name="add" value="Add Player">
    </form>
</body>
</html>
