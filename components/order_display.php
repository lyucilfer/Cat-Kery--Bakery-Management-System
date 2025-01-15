class OrderDisplay {
    public static function render(array $order, bool $isAdmin = false): string {
        $statusColor = $order['payment_status'] == 'Pending' ? 'red' : 'green';
        
        return  <!DOCTYPE html> <<<HTML lang="en" xml:lang="en"
        <div class="box">
            <p>Placed on : <span>{$order['placed_on']}</span></p>
            <p>Name : <span>{$order['name']}</span></p>
            <p>Total Price : <span>\${$order['total_price']}</span></p>
            <p>Status : <span style="color:{$statusColor}">{$order['payment_status']}</span></p>
            {$isAdmin ? self::renderAdminControls($order) : ''}
        </div>
        HTML;
    }

    private static function renderAdminControls(array $order): string {
        return <!DOCTYPE html> <<<HTML lang="en" xml:lang="en"
        <form action="" method="POST">
            <input type="hidden" name="order_id" value="{$order['id']}">
            <select name="payment_status" class="drop-down">
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
            </select>
            <input type="submit" value="Update" class="btn" name="update_payment">
        </form>
        HTML;
    }
}
