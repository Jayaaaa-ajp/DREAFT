<?php
include 'config.php';
session_start();

// Add Customer
if(isset($_POST['add_customer'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    
    $sql = "INSERT INTO customers (first_name, last_name, phone) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $first_name, $last_name, $phone);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Customer added successfully!";
    } else {
        $_SESSION['error'] = "Error adding customer: " . $conn->error;
    }
    
    header("Location: customers.php");
    exit();
}

// Add Menu Item
if(isset($_POST['add_menu'])) {
    $dish = $_POST['dish'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    
    $sql = "INSERT INTO menu_items (dish, category, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $dish, $category, $price);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Menu item added successfully!";
    } else {
        $_SESSION['error'] = "Error adding menu item: " . $conn->error;
    }
    
    header("Location: menu.php");
    exit();
}

// Place Order
if(isset($_POST['place_order'])) {
    $customer_id = $_POST['customer_id'];
    $menu_item_id = $_POST['menu_item_id'];
    $quantity = $_POST['quantity'];
    
    // Get menu item price
    $price_query = $conn->query("SELECT price FROM menu_items WHERE id = $menu_item_id");
    $menu_item = $price_query->fetch_assoc();
    $total_price = $menu_item['price'] * $quantity;
    
    $sql = "INSERT INTO orders (customer_id, menu_item_id, quantity, total_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $customer_id, $menu_item_id, $quantity, $total_price);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Order placed successfully!";
    } else {
        $_SESSION['error'] = "Error placing order: " . $conn->error;
    }
    
    header("Location: restaurant.php");
    exit();
}

// Update operations
if(isset($_POST['update_customer'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    
    $sql = "UPDATE customers SET first_name=?, last_name=?, phone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $first_name, $last_name, $phone, $id);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Customer updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating customer: " . $conn->error;
    }
    
    header("Location: customers.php");
    exit();
}

if(isset($_POST['update_menu'])) {
    $id = $_POST['id'];
    $dish = $_POST['dish'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    
    $sql = "UPDATE menu_items SET dish=?, category=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $dish, $category, $price, $id);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Menu item updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating menu item: " . $conn->error;
    }
    
    header("Location: menu.php");
    exit();
}
?>