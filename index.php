
<?php
include 'db.php';

// Save visitor information
if (isset($_POST['save'])) {

    $name = $_POST['name'];
    $department = $_POST['department'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare(
        "INSERT INTO visitors (name, department, purpose)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sss", $name, $department, $purpose);

    if ($stmt->execute()) {
        header("Location: index.php?saved=1");
        exit();
    } else {
        echo "Error saving record.";
    }
}

// Display visitor records
$result = $conn->query(
    "SELECT * FROM visitors ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Visitor Logbook</title>
    <link rel="stylesheet" href="style.css">
    <style>

/* Center the whole page */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 30px;
    
}

/* Main container */
.container {
    max-width: 1000px;
    width: 100%;
    margin: 0 auto;
    text-align: center;
}

/* Main title */
h1 {
    text-align: center;
    color: #17365D;
}

/* Subtitle */
.subtitle {
    text-align: center;
    color: gray;
}

/* Form and table boxes */
.form-box, .table-box {
    background: white;
    padding: 25px;
    margin: 25px auto;
    border-radius: 10px;
    box-shadow: 0 2px 8px #ddd;
    text-align: center;
}

/* Section headings */
h2 {
    color: #17365D;
    text-align: center;
}

/* Center the form */
form {
    max-width: 500px;
    margin: 0 auto;
    text-align: left;
}

/* Input labels */
label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
}

/* Input fields */
input {
    width: 100%;
    padding: 12px;
    margin-top: 7px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

/* Save button */
button {
    width: 100%;
    background: #17365D;
    color: white;
    border: none;
    padding: 13px;
    margin-top: 20px;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #24558a;
}

/* Visitor table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}

th {
    background: #17365D;
    color: white;
}

/* Success message */
.success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 5px;
    text-align: center;
}

    </style>
</head>

<body>

<div class="container">

    <h1>VISITOR LOGBOOK</h1>

    <p class="subtitle">Visitor Registration System</p>

    <?php if (isset($_GET['saved'])): ?>
        <p class="success">Record successfully saved!</p>
    <?php endif; ?>

    <div class="form-box">

        <h2>Visitor Information</h2>

        <form method="POST">

            <label>Full Name</label>
            <input type="text" name="name"
                   placeholder="Enter your full name" required>

            <label>Department / Office</label>
            <input type="text" name="department"
                   placeholder="Enter department" required>

            <label>Purpose of Visit</label>
            <input type="text" name="purpose"
                   placeholder="Enter purpose of visit" required>

            <button type="submit" name="save">
                SAVE LOGBOOK
            </button>

        </form>

    </div>

    <div class="table-box">

        <h2>Recorded Visitors</h2>

        <table>

            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Department</th>
                <th>Purpose</th>
                <th>Time In</th>
            </tr>

            <?php
            $number = 1;

            while ($row = $result->fetch_assoc()):
            ?>

            <tr>
                <td><?php echo $number++; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['department']); ?></td>
                <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                <td><?php echo htmlspecialchars($row['time_in']); ?></td>
            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>
