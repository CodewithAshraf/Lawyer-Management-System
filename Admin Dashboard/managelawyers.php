<?php
include('../conn.php'); // DB connection

$query = "SELECT * FROM lawyer";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Lawyers</title>
    <!-- Bootstrap CDN (for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    #dash{
        position: relative;
        left: 270px;
    }
</style>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2>Manage Lawyers</h2>
        <a href="Admindash.php" id="dash" class="btn btn-primary ">Back to Dashboard</a>
        <a href="addlawyer.php" class="btn btn-primary ">Add Lawyer</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>img</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>pass</th>
                <th>Action</th>
               
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['u_id'] ?></td>
                <td><?= $row['u_name'] ?></td>
                <td><?= $row['p_img'] ?></td>
                <td><?= $row['u_email'] ?></td>
                <td><?= $row['specialization'] ?></td>
                <td><?= $row['u_pass'] ?></td>
                
                <td>
                    <!-- <a href="edit_lawyer.php?id=<?= $row['u_id'] ?>" class="btn btn-sm btn-primary">Edit</a> -->
                    <a href="deletelawyer.php?id=<?= $row['u_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this lawyer?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
