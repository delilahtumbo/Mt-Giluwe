<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
   exit;
}

$bookings = mysqli_query($conn, "SELECT * FROM bookings ORDER BY created_at DESC");
$messages = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard - Mt Giluwe</title>
   <link rel="stylesheet" href="css/style.css">
   <style>
      body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
      .admin-header { background: #1f2833; color: #fff; padding: 20px 30px; border-radius: 8px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
      .admin-header h1 span { color: rgb(255,145,0); }
      .btn { display: inline-block; padding: 8px 18px; background: rgb(255,145,0); color: #fff; border-radius: 5px; text-decoration: none; margin-left: 8px; font-size: 14px; }
      .btn.logout { background: #c0392b; }
      table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; margin-bottom: 40px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
      th { background: #1f2833; color: #fff; padding: 12px 15px; text-align: left; }
      td { padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; }
      tr:last-child td { border-bottom: none; }
      tr:hover td { background: #f9f9f9; }
      h2 { color: #1f2833; margin-bottom: 10px; }
      .empty { color: #888; font-style: italic; padding: 15px; }
   </style>
</head>
<body>

<div class="admin-header">
   <h1>Welcome, <span><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span> &mdash; Admin Dashboard</h1>
   <div>
      <a href="register_form.php" class="btn">Add User</a>
      <a href="logout.php" class="btn logout">Logout</a>
   </div>
</div>

<h2>Bookings</h2>
<table>
   <thead>
      <tr>
         <th>#</th><th>Name</th><th>Email</th><th>Destination</th><th>Guests</th><th>Arrival</th><th>Leaving</th><th>Submitted</th>
      </tr>
   </thead>
   <tbody>
   <?php if(mysqli_num_rows($bookings) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($bookings)): ?>
      <tr>
         <td><?php echo $row['id']; ?></td>
         <td><?php echo htmlspecialchars($row['name']); ?></td>
         <td><?php echo htmlspecialchars($row['email']); ?></td>
         <td><?php echo htmlspecialchars($row['where_to']); ?></td>
         <td><?php echo (int)$row['guests']; ?></td>
         <td><?php echo htmlspecialchars($row['arrival_date']); ?></td>
         <td><?php echo htmlspecialchars($row['leaving_date']); ?></td>
         <td><?php echo htmlspecialchars($row['created_at']); ?></td>
      </tr>
      <?php endwhile; ?>
   <?php else: ?>
      <tr><td colspan="8" class="empty">No bookings yet.</td></tr>
   <?php endif; ?>
   </tbody>
</table>

<h2>Contact Messages</h2>
<table>
   <thead>
      <tr>
         <th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Country</th><th>Message</th><th>Submitted</th>
      </tr>
   </thead>
   <tbody>
   <?php if(mysqli_num_rows($messages) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($messages)): ?>
      <tr>
         <td><?php echo $row['id']; ?></td>
         <td><?php echo htmlspecialchars($row['name']); ?></td>
         <td><?php echo htmlspecialchars($row['email']); ?></td>
         <td><?php echo htmlspecialchars($row['phone']); ?></td>
         <td><?php echo htmlspecialchars($row['country']); ?></td>
         <td><?php echo htmlspecialchars($row['message']); ?></td>
         <td><?php echo htmlspecialchars($row['created_at']); ?></td>
      </tr>
      <?php endwhile; ?>
   <?php else: ?>
      <tr><td colspan="7" class="empty">No messages yet.</td></tr>
   <?php endif; ?>
   </tbody>
</table>

</body>
</html>
