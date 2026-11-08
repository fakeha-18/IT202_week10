<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentID = filter_input(INPUT_POST, "student_id", FILTER_VALIDATE_INT);

    if ($studentID === false || $studentID === null) {
        $error = "Please enter a valid student ID.";
    } else {
        // Reuse your Week 9 database connection here
        require "db_connect.php";

        $stmt = $conn->prepare("SELECT ID FROM Student WHERE ID = ?");
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION["student_id"] = $studentID;
            header("Location: student_info.php");
            exit;
        } else {
            $error = "Student ID not found.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Search</title>
</head>
<body>
    <h1>Student Search</h1>

    <form method="POST">
        <label for="student_id">Enter Student ID:</label>
        <input type="number" id="student_id" name="student_id" required>
        <button type="submit">Search</button>
    </form>

    <?php if (isset($error)): ?>
        <script>
            alert(<?php echo json_encode($error); ?>);
        </script>
    <?php endif; ?>
</body>
</html>