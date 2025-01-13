<?php
$file_path = 'tasks.json';
$tasks = [];
$errors = [];
$success = null;

if (file_exists($file_path)) 
{
    $json_content = file_get_contents($file_path);
    $tasks = json_decode($json_content, true);
    if (!is_array($tasks)) 
    {
        $tasks = [];     
    }
}

if (isset($_POST['submit'])):
    $task_id = uniqid();
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    if (empty($title) || empty($description) || empty($due_date) || empty($status)) {
        $errors['required'] = "Please fill in all fields.";
    } 
    if(strtotime($due_date) < strtotime('now')) {
        $errors['date'] = "Kindly enter a valid date.";
    } 
    if (!preg_match("/^[a-zA-Z\s]+$/", $title))
        $errors['title'] = "Full name should not contain numbers or special characters<br>";

    else {
        $new_task = [
            'id' => $task_id,
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'status' => $status,
        ];

        $tasks[] = $new_task;

        if (file_put_contents($file_path, json_encode($tasks, JSON_PRETTY_PRINT))) {
            $success = "Task added successfully!";
        } else {
            $errors['faild'] = "Failed to save the task.";
        }
    }
endif;

if (isset($_POST['delete_id'])):
    $delete_id = $_POST['delete_id'];

    if (is_array($tasks)) {
        $tasks = array_filter($tasks, function ($task) use ($delete_id) {
            return isset($task['id']) && $task['id'] !== $delete_id;
        });

        if (file_put_contents($file_path, json_encode($tasks, JSON_PRETTY_PRINT))) {
            $success = "Task deleted successfully!";
        } else {
            $errors[] = "Failed to delete the task.";
        }
    }
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Task Management System</h1>

    <?php if (!empty($errors)){ ?>
        <div class="alert alert-danger">
            <?= implode('<br>', $errors); ?>
        </div>
    <?php }; ?>

    <?php if ($success){ ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
        </div>
    <?php } ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter task title">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" id="due_date" name="due_date" class="form-control">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="">Select a Status</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Task</button>
    </form>

    <h2 class="mt-5">Task List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tasks)): ?>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['id'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($task['title'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($task['description'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($task['due_date'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($task['status'] ?? 'N/A'); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($task['id']); ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No tasks found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>