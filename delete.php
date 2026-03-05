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
    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Customer deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting customer: " . $conn->error;
    }
    
    header("Location: customers.php");
    
} elseif($type == 'menu') {
    $sql = "DELETE FROM menu_items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Menu item deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting menu item: " . $conn->error;
    }
    
    header("Location: menu.php");
    
} elseif($type == 'order') {
    $sql = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Order deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting order: " . $conn->error;
    }
    
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'restaurant.php'));
    
} else {
    header("Location: restaurant.php");
}

exit();
?>