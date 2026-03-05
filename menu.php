<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items - Restaurant Management</title>
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
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        
        .btn:hover {
            background: #5a67d8;
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
            margin-right: 10px;
        }
        
        .action-link:hover {
            text-decoration: underline;
        }
        
        .edit-link {
            color: #28a745;
            text-decoration: none;
        }
        
        .edit-link:hover {
            text-decoration: underline;
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
            <h2 class="section-title">Add Menu Items</h2>
            
            <form action="insert.php" method="POST" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 15px; align-items: end;">
                <div class="form-group">
                    <label>Dish</label>
                    <input type="text" name="dish" required>
                </div>
                
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Appetizer">Appetizer</option>
                        <option value="Main Course">Main Course</option>
                        <option value="Dessert">Dessert</option>
                        <option value="Beverage">Beverage</option>
                        <option value="Soup">Soup</option>
                        <option value="Salad">Salad</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Price (₱)</label>
                    <input type="number" name="price" step="0.01" min="0" required>
                </div>
                
                <button type="submit" name="add_menu" class="btn">Add Item</button>
            </form>
            
            <h2 class="section-title">Menu Items</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Dish</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM menu_items ORDER BY created_at DESC");
                    
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['dish'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>₱" . number_format($row['price'], 2) . "</td>";
                            echo "<td>
                                    <a href='update.php?type=menu&id=" . $row['id'] . "' class='edit-link'>Edit</a>
                                    <a href='delete.php?type=menu&id=" . $row['id'] . "' class='action-link' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center;'>No menu items found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>