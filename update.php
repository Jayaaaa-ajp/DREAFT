<?php
include 'config.php';
session_start();

$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? 0;

if(!$id) {
    header("Location: restaurant.php");
    exit();
}

if($type == 'customer') {
    $result = $conn->query("SELECT * FROM customers WHERE id = $id");
    $data = $result->fetch_assoc();
    
    if(!$data) {
        $_SESSION['error'] = "Customer not found";
        header("Location: customers.php");
        exit();
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Customer</title>
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
                max-width: 600px;
                margin: 0 auto;
            }
            
            h1 {
                color: white;
                text-align: center;
                font-size: 3em;
                margin-bottom: 30px;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            }
            
            .form-container {
                background: white;
                border-radius: 10px;
                padding: 30px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            label {
                display: block;
                margin-bottom: 5px;
                color: #555;
            }
            
            input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
            }
            
            .btn {
                background: #667eea;
                color: white;
                border: none;
                padding: 12px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                width: 100%;
            }
            
            .btn:hover {
                background: #5a67d8;
            }
            
            .back-link {
                display: block;
                text-align: center;
                margin-top: 20px;
                color: white;
                text-decoration: none;
            }
            
            .back-link:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🍽️ RESTAURANT</h1>
            
            <div class="form-container">
                <h2 style="margin-bottom: 20px;">Update Customer</h2>
                
                <form action="insert.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="<?php echo $data['first_name']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="<?php echo $data['last_name']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?php echo $data['phone']; ?>" required>
                    </div>
                    
                    <button type="submit" name="update_customer" class="btn">Update Customer</button>
                </form>
                
                <a href="customers.php" class="back-link">Back to Customers</a>
            </div>
        </div>
    </body>
    </html>
    
    <?php
} elseif($type == 'menu') {
    $result = $conn->query("SELECT * FROM menu_items WHERE id = $id");
    $data = $result->fetch_assoc();
    
    if(!$data) {
        $_SESSION['error'] = "Menu item not found";
        header("Location: menu.php");
        exit();
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Menu Item</title>
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
                max-width: 600px;
                margin: 0 auto;
            }
            
            h1 {
                color: white;
                text-align: center;
                font-size: 3em;
                margin-bottom: 30px;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            }
            
            .form-container {
                background: white;
                border-radius: 10px;
                padding: 30px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            label {
                display: block;
                margin-bottom: 5px;
                color: #555;
            }
            
            input, select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
            }
            
            .btn {
                background: #667eea;
                color: white;
                border: none;
                padding: 12px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                width: 100%;
            }
            
            .btn:hover {
                background: #5a67d8;
            }
            
            .back-link {
                display: block;
                text-align: center;
                margin-top: 20px;
                color: white;
                text-decoration: none;
            }
            
            .back-link:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🍽️ RESTAURANT</h1>
            
            <div class="form-container">
                <h2 style="margin-bottom: 20px;">Update Menu Item</h2>
                
                <form action="insert.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    
                    <div class="form-group">
                        <label>Dish</label>
                        <input type="text" name="dish" value="<?php echo $data['dish']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" required>
                            <option value="">Select Category</option>
                            <option value="Appetizer" <?php echo $data['category'] == 'Appetizer' ? 'selected' : ''; ?>>Appetizer</option>
                            <option value="Main Course" <?php echo $data['category'] == 'Main Course' ? 'selected' : ''; ?>>Main Course</option>
                            <option value="Dessert" <?php echo $data['category'] == 'Dessert' ? 'selected' : ''; ?>>Dessert</option>
                            <option value="Beverage" <?php echo $data['category'] == 'Beverage' ? 'selected' : ''; ?>>Beverage</option>
                            <option value="Soup" <?php echo $data['category'] == 'Soup' ? 'selected' : ''; ?>>Soup</option>
                            <option value="Salad" <?php echo $data['category'] == 'Salad' ? 'selected' : ''; ?>>Salad</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Price (₱)</label>
                        <input type="number" name="price" step="0.01" min="0" value="<?php echo $data['price']; ?>" required>
                    </div>
                    
                    <button type="submit" name="update_menu" class="btn">Update Menu Item</button>
                </form>
                
                <a href="menu.php" class="back-link">Back to Menu</a>
            </div>
        </div>
    </body>
    </html>
    
    <?php
} else {
    header("Location: restaurant.php");
    exit();
}
?>
