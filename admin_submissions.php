<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dogadoption';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection FAILED: " . $conn->connect_error);
}

$count_result = $conn->query("SELECT COUNT(*) AS cnt FROM applications");
$total = 0;
if ($count_result) {
    $row = $count_result->fetch_assoc();
    $total = isset($row['cnt']) ? (int)$row['cnt'] : 0;
}

$sql = "SELECT id, fname, lname, email, phone, age, home_type, other_pets, children, hours_alone, dog_interested, message, date_submitted FROM applications ORDER BY date_submitted DESC";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin — Applications</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 20px;
      color: #222222;
    }
    .container {
      width: 100%;
      margin: 0 auto;
      background: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      box-sizing: border-box;
    }
    h1 {
      margin: 0 0 10px;
      font-size: 24px;
    }
    .count {
      margin-bottom: 20px;
      color: #444444;
    }
    .success-message {
      background: #e8f5ea;
      color: #1f5a2e;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid #b8e0c0;
      border-radius: 6px;
      font-weight: 600;
    }
    .table-wrap {
      overflow-x: auto;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
      background: #ffffff;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #ffffff;
      min-width: 1100px;
    }
    th, td {
      text-align: left;
      padding: 12px;
      border-bottom: 1px solid #e0e0e0;
    }
    th {
      background: #fafafa;
      font-weight: 600;
    }
    tr:hover {
      background: #f3f8ff;
    }
    .empty {
      padding: 12px;
      color: #777777;
      background: #fafafa;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
    }
    .message-cell {
      max-width: 300px;
      white-space: normal;
      word-wrap: break-word;
    }
    @media (max-width: 900px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      thead {
        display: none;
      }
      tr {
        margin-bottom: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        overflow: hidden;
      }
      td {
        display: flex;
        justify-content: space-between;
        padding: 10px 12px;
        border-bottom: 1px solid #f0f0f0;
      }
      td:last-child {
        border-bottom: none;
      }
      td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #555555;
        margin-right: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Adoption Applications</h1>
    
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
      <div class="success-message">
        ✓ Application submitted successfully!
      </div>
    <?php endif; ?>
    
    <div class="count">Total applications: <strong><?php echo $total; ?></strong></div>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Age</th>
              <th>Home Type</th>
              <th>Other Pets</th>
              <th>Children</th>
              <th>Hours Alone</th>
              <th>Dog Interested</th>
              <th>Message</th>
              <th>Date Submitted</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td data-label="ID"><?php echo htmlspecialchars($row['id']); ?></td>
                <td data-label="First Name"><?php echo htmlspecialchars($row['fname']); ?></td>
                <td data-label="Last Name"><?php echo htmlspecialchars($row['lname']); ?></td>
                <td data-label="Email"><?php echo htmlspecialchars($row['email']); ?></td>
                <td data-label="Phone"><?php echo htmlspecialchars($row['phone']); ?></td>
                <td data-label="Age"><?php echo htmlspecialchars($row['age']); ?></td>
                <td data-label="Home Type"><?php echo htmlspecialchars($row['home_type']); ?></td>
                <td data-label="Other Pets"><?php echo htmlspecialchars($row['other_pets']); ?></td>
                <td data-label="Children"><?php echo htmlspecialchars($row['children']); ?></td>
                <td data-label="Hours Alone"><?php echo htmlspecialchars($row['hours_alone']); ?></td>
                <td data-label="Dog Interested"><?php echo htmlspecialchars($row['dog_interested']); ?></td>
                <td data-label="Message" class="message-cell"><?php echo htmlspecialchars($row['message']); ?></td>
                <td data-label="Date Submitted"><?php echo htmlspecialchars($row['date_submitted']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="empty">No applications yet.</div>
    <?php endif; ?>

  </div>

<?php
$conn->close();
?>
</body>
</html>
