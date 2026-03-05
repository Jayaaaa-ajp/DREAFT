<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
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
            max-width: 1400px;
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
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
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
        </div>
        
        <div class="main-content">
            <?php
            if(isset($_SESSION['message'])) {
                echo "<div class='success-message'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
            }
            if(isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            ?>
            
            <h2 class="section-title">Place New Order</h2>
            
            <?php
            $customers = $conn->query("SELECT * FROM customers ORDER BY first_name");
            $menu_items = $conn->query("SELECT * FROM menu_items ORDER BY dish");
            ?>
            
            <form action="insert.php" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px;">
                <div>
                    <label style="display: block; margin-bottom: 5px;">Select Customer:</label>
                    <select name="customer_id" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Select Customer</option>
                        <?php while($customer = $customers->fetch_assoc()): ?>
                        <option value="<?php echo $customer['id']; ?>">
                            <?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 5px;">Select Dish:</label>
                    <select name="menu_item_id" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Select Dish</option>
                        <?php while($item = $menu_items->fetch_assoc()): ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['dish'] . ' - ₱' . number_format($item['price'], 2); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 5px;">Quantity:</label>
                    <input type="number" name="quantity" min="1" value="1" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" name="place_order" style="background: #667eea; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;">
                        Place Order
                    </button>
                </div>
            </form>
            
            <h2 class="section-title">Recent Orders</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f2f2f2;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">ID</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Customer</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Phone</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Dish</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Category</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Qty</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Total</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Date</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Action</th>
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
                        LIMIT 10
                    ");
                    
                    if($orders->num_rows > 0) {
                        while($order = $orders->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . $order['id'] . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . $order['first_name'] . " " . $order['last_name'] . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . $order['phone'] . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . $order['dish'] . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . $order['category'] . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . $order['quantity'] . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>₱" . number_format($order['total_price'], 2) . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . date('Y-m-d H:i', strtotime($order['order_date'])) . "</td>";
                            echo "<td style='padding: 12px; border-bottom: 1px solid #ddd;'>
                                    <a href='delete.php?type=order&id=" . $order['id'] . "' onclick='return confirm(\"Are you sure?\")' style='color: #dc3545; text-decoration: none;'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='padding: 12px; text-align: center;'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>