<?php
// 代码生成时间: 2025-09-05 22:08:22
class ShoppingCart {

    // Array to hold cart items
    private $items = [];

    // Constructor
    public function __construct() {
        // Initialize the cart items
        $this->items = [];
    }

    // Add item to cart
    public function addItem($itemId, $quantity) {
        if (!isset($this->items[$itemId])) {
            // Item does not exist in cart, add it
            $this->items[$itemId] = $quantity;
        } else {
            // Item exists, update the quantity
            $this->items[$itemId] += $quantity;
        }
    }

    // Remove item from cart
    public function removeItem($itemId) {
        if (isset($this->items[$itemId])) {
            // Item exists, remove it
            unset($this->items[$itemId]);
        } else {
            // Item does not exist, handle the error
            throw new Exception("Item does not exist in the cart.");
        }
    }

    // Get the cart items
    public function getCartItems() {
        return $this->items;
    }

    // Clear the cart
    public function clearCart() {
        $this->items = [];
    }

}

// Usage example
try {
    $cart = new ShoppingCart();
    $cart->addItem(1, 2); // Add 2 items with ID 1
    $cart->addItem(2, 1); // Add 1 item with ID 2

    print_r($cart->getCartItems()); // Display cart items

    $cart->removeItem(1); // Remove item with ID 1
    print_r($cart->getCartItems()); // Display cart items

    $cart->clearCart(); // Clear the cart
    print_r($cart->getCartItems()); // Display cart items

} catch (Exception $e) {
    // Handle exceptions
    echo "Error: " . $e->getMessage();
}
