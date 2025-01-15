class ImageHandler {
    private $uploadPath;
    private $maxSize = 2000000;

    public function __construct($uploadPath) {
        $this->uploadPath = $uploadPath;
    }

    public function handleImageUpload($file, $oldImage = null) {
        if ($file['size'] > $this->maxSize) {
            throw new Exception('Image size is too large!');
        }

        $image = filter_var($file['name'], FILTER_SANITIZE_STRING);
        $imagePath = $this->uploadPath . $image;
        
        if (move_uploaded_file($file['tmp_name'], $imagePath)) {
            if ($oldImage && file_exists($this->uploadPath . $oldImage)) {
                unlink($this->uploadPath . $oldImage);
            }
            return $image;
        }
        
        throw new Exception('Failed to upload image');
    }
}
