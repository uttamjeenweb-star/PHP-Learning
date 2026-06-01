<?php
// Functionality
require_once __DIR__ . '/../../db.php';

$name = '';
$email = '';
$course = '';
$success = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $course = mysqli_real_escape_string($conn, $_POST['course'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($course)) {
        $sql = "INSERT INTO students (name, email, course) VALUES ('$name', '$email', '$course')";
        
        if (mysqli_query($conn, $sql)) {
            $success = true;
            $name = ''; // Clear fields
            $email = '';
            $course = '';
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Fetch data for the table
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
$students = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
}
?>

<div class="form-component">
    <?php if ($success): ?>
        <div class="success-message">
            Student added successfully!
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message" style="color: red; margin-bottom: 1rem; padding: 1rem; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($course); ?>" required>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>

<div class="table-container">
    <h2>Student Records</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['id']); ?></td>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td><?php echo htmlspecialchars($student['course']); ?></td>
                        <td><?php echo htmlspecialchars($student['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No students found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
