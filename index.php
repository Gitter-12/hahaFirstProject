<?php include("db.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <br>

    <form action="add.php" method="post">


        <label>Task title: </label>
        <input type="text" name="task_title">
        <input type="submit" value="Create task">

    </form>

    <br>
        <form action="delete.php" method="post">

    <table class="table table-bordered">
        <thead>
            <th> Id </th>
            <th> Title </th>
            <th> Status </th>
            <th> Date of Creation </th>
        </thead>
        <tbody>

            <?php
            $sql = 'SELECT * FROM tasks';
            $all_tasks = mysqli_query($conn, $sql);

            if (mysqli_num_rows($all_tasks) > 0) {
                foreach ($all_tasks as $row) {
            ?>

                    <tr>
                        <td><input type = "checkbox" name = "delete_ids[]" value="<?php echo $row['id']; ?>">    <?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>

                    </tr>

            <?php
                }
            } else {
                echo '<tr><td colspan="4">No tasks yet</td></tr>';
                                
            }
            ?>

        </tbody>

    </table>



        <label>Enter ID: </label>
        <input type="text" name="delete_id">
        <input type="submit" value="Delete">

    </form>


</body>


</html>