<?php
session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: student_search.php");
    exit;
}

require "db_connect.php";

$studentID = $_SESSION["student_id"];

$sql = "SELECT Student.Name, Student.ID, Student.Major,
               Transcript.Course, Transcript.Grade
        FROM Student
        INNER JOIN Transcript
        ON Student.ID = Transcript.ID
        WHERE Student.ID = ?
        ORDER BY Transcript.Course";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #eeeeee;
        }
        a {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Student Information</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>ID</th>
                <th>Major</th>
                <th>Course</th>
                <th>Grade</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["Name"]) ?></td>
                    <td><?= htmlspecialchars($row["ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Major"]) ?></td>
                    <td><?= htmlspecialchars($row["Course"]) ?></td>
                    <td><?= htmlspecialchars($row["Grade"]) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No student information found.</p>
    <?php endif; ?>

    <a href="student_search.php">
        <button type="button">HOME / BACK</button>
    </a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>