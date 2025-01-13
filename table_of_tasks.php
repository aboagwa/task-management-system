<?php include('header.php'); 
include('create-task.php');

if (isset($_POST['edit_id'])) {
    foreach($tasks as $task) {  
        
        if ($task['id'] == $_POST['edit_id']) {
        $edit_id = $task['id'];
        $title = $task['title'];
        $description = $task['description'];
        $due_date = $task['due_date'];
        $status = $task['status'];
        break;   
    }
    }
}

if (isset($_POST['update'])) {
    $task_id = $_POST['edit_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $edited_task = [
        'id' => $task_id,
        'title' => $title,
        'description' => $description,
        'due_date' => $due_date,
        'status' => $status,
    ];

    if (file_put_contents($file_path, json_encode($tasks, JSON_PRETTY_PRINT))) {
        $success = "Task updated successfully!";
        $editing_task = $task;
    } else {
        $errors['failed'] = "Failed to update the task.";
    }
}
?>


<div class="container mt-5">

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
                            <form method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($task['id']); ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <form method="POST" style="display:inline;" onsubmit=" return confirmUpdate();">
                                <input type="hidden" name="edit_id" value="<?= htmlspecialchars($task['id']); ?>">
                                
                                <button type="submit" name="edit" class="btn btn-success btn-sm">Edit</button>
                            </form>
</form>

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

<div class="container mt-5">
    <form method="POST">
    <div class="mb-3">
            <label for="edit_id" class="form-label">Task ID</label>
            <input type="text" class="form-control" id="edit_id" name="edit_id" value="<?= isset($edit_id) ? htmlspecialchars($edit_id) : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= isset($title) ? htmlspecialchars($title) : ''; ?>">
            </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
            </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" Value = "<?= isset($due_date) ? htmlspecialchars($due_date) : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
    <option value="Pending" <?= (isset($status) && $status === "Pending") ? 'selected' : ''; ?>>Pending</option>
    <option value="In Progress" <?= (isset($status) && $status === "In Progress") ? 'selected' : ''; ?>>In Progress</option>
    <option value="Completed" <?= (isset($status) && $status === "Completed") ? 'selected' : ''; ?>>Completed</option>
</select>

        </div>
        <button type="update" name="update" class="btn btn-primary">Update Task</button>
    </form>
</div>
