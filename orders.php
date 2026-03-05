<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Restaurant Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        h1 {
            color: white;
            text-align: center;
            font-size: 3em;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .nav-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .main-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .section-title {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.5em;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background: #f2f2f2;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .action-link {
            color: #dc3545;
            text-decoration: none;
        }
        
        .action-link:hover {
            text-decoration: underline;
        }
        
        .summary-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: inline-block;
            margin-right: 20px;
        }
        
        .summary-label {
            color: #666;
            font-size: 0.9em;
        }
        
        .summary-value {
            color: #333;
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍽️ RESTAURANT</h1>
        
        <div class="nav-links">
            <a href="customers.php">Customers</a>
            <a href="menu.php">Menu Items</a>
            <a href="orders.php">Orders</a>
            <a href="restaurant.php">Dashboard</a>
        </div>
        
        <div class="main-content">
            <h2 class="section-title">Order Summary</h2>
            
            <?php
            $total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc();
            $total_revenue = $conn->query("SELECT SUM(total_price) as total FROM orders")->fetch_assoc();
            $today_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE DATE(order_date) = CURDATE()")->fetch_assoc();
            ?>
            
            <div class="summary-card">
                <div class="summary-label">Total Orders</div>
                <div class="summary-value"><?php echo $total_orders['count']; ?></div>
            </div>
            
            <div class="summary-card">
                <div class="summary-label">Total Revenue</div>
                <div class="summary-value">₱<?php echo number_format($total_revenue['total'] ?? 0, 2); ?></div>
            </div>
            
            <div class="summary-card">
                <div class="summary-label">Today's Orders</div>
                <div class="summary-value"><?php echo $today_orders['count']; ?></div>
            </div>
            
            <h2 class="section-title">All Orders</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Dish</th>
                        <th>Category</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders = $conn->query("
                        SELECT o.*, c.first_name, c.last_name, c.phone, m.dish, m.category, m.price 
                        FROM orders o 
                        JOIN customers c ON o.customer_id = c.id 
                        JOIN menu_items m ON o.menu_item_id = m.id 
                        ORDER BY o.order_date DESC
                    ");
                    
                    if($orders->num_rows > 0) {
                        while($order = $orders->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $order['id'] . "</td>";
                            echo "<td>" . $order['first_name'] . " " . $order['last_name'] . "</td>";
                            echo "<td>" . $order['phone'] . "</td>";
                            echo "<td>" . $order['dish'] . "</td>";
                            echo "<td>" . $order['category'] . "</td>";
                            echo "<td>" . $order['quantity'] . "</td>";
                            echo "<td>₱" . number_format($order['total_price'], 2) . "</td>";
                            echo "<td>" . date('Y-m-d H:i', strtotime($order['order_date'])) . "</td>";
                            echo "<td>
                                    <a href='delete.php?type=order&id=" . $order['id'] . "' class='action-link' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align: center;'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
