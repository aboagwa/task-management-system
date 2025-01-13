<h1>Task Management System</h1>

<?php if (!empty($errors)){ ?>
    <div class="alert alert-danger">
        <?= implode('<br>', $errors); ?>
    </div>
<?php }; ?>