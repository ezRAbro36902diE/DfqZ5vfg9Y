<?php
// 代码生成时间: 2025-08-14 04:23:29
class ShoppingCart {

    // An associative array to store cart items and their quantities
    private $items = [];

    /**
     * Add an item to the cart.
     *
     * @param string $itemId The ID of the item to add.
     * @param int $quantity The quantity of the item to add.
     * @return void
     */
    public function addItem($itemId, $quantity) {
        if (!isset($this->items[$itemId])) {
            $this->items[$itemId] = 0;
        }

        $this->items[$itemId] += $quantity;
    }

    /**
     * Remove an item from the cart.
     *
     * @param string $itemId The ID of the item to remove.
     * @return void
     */
    public function removeItem($itemId) {
        if (isset($this->items[$itemId])) {
            unset($this->items[$itemId]);
        } else {
            // Handle the error if item not found in cart
            throw new Exception("Item with ID {$itemId} not found in the cart.");
        }
    }

    /**
     * Update the quantity of an item in the cart.
     *
     * @param string $itemId The ID of the item to update.
     * @param int $quantity The new quantity of the item.
     * @return void
     */
    public function updateQuantity($itemId, $quantity) {
        if (isset($this->items[$itemId])) {
            $this->items[$itemId] = $quantity;
        } else {
            // Handle the error if item not found in cart
            throw new Exception("Item with ID {$itemId} not found in the cart.");
        }
    }

    /**
     * Get the contents of the cart.
     *
     * @return array The contents of the cart.
     */
    public function getContents() {
        return $this->items;
    }
}

/**
 * Usage Example
 */
\$cart = new ShoppingCart();
\$cart->addItem('item1', 2);
\$cart->addItem('item2', 3);
\$cart->updateQuantity('item1', 5);
\$cart->removeItem('item2');

try {
    print_r(\$cart->getContents());
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage();
}
