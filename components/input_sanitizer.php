class InputSanitizer {
    public static function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizeInput'], $data);
        }
        return filter_var($data, FILTER_SANITIZE_STRING);
    }

    public static function sanitizeProductInput($post) {
        return [
            'name' => self::sanitizeInput($post['name']),
            'price' => self::sanitizeInput($post['price']),
            'category' => self::sanitizeInput($post['category'])
        ];
    }
}