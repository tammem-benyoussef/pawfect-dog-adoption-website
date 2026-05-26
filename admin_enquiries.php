<?php
$conn = new mysqli('localhost', 'root', '', 'dogadoption');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$sql = 'SELECT id, name, email, dog_name, date_submitted FROM enquiries ORDER BY date_submitted DESC';
$result = $conn->query($sql);

$enquiries = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $enquiries[] = $row;
    }
}

$totalCount = count($enquiries);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Enquiries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        h1 {
            margin: 0 0 10px;
            font-size: 24px;
        }
        .count {
            margin-bottom: 20px;
            color: #444444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
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
        @media (max-width: 700px) {
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
        <h1>Enquiries</h1>
        <div class="count">Total enquiries: <?php echo $totalCount; ?></div>

        <?php if ($totalCount === 0): ?>
            <div class="empty">No enquiries found.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Dog Name</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enquiries as $enquiry): ?>
                        <tr>
                            <td data-label="ID"><?php echo htmlspecialchars($enquiry['id']); ?></td>
                            <td data-label="Name"><?php echo htmlspecialchars($enquiry['name']); ?></td>
                            <td data-label="Email"><?php echo htmlspecialchars($enquiry['email']); ?></td>
                            <td data-label="Dog Name"><?php echo htmlspecialchars($enquiry['dog_name']); ?></td>
                            <td data-label="Date Submitted"><?php echo htmlspecialchars($enquiry['date_submitted']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
