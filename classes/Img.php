<?php

//namespace Route\Classes;

class Img {
    private $file;
    public $image_name; 
    private $ext = ["png", "jpg", "jpeg", "gif"];
    private $size = 1* 1024 * 1024; 
    private $uploadDir = '../uploads/';
    private $new_name;
    private $errors = [];

    public function __construct($file) {
        $this->file = $file;
        $this->image_name = $file['name'];
        $this->validateExt();
        $this->validateSize();
        $this->upload();
    }

    // Validate file type
    private function validateExt() {
        $fileExt = strtolower(pathinfo($this->image_name, PATHINFO_EXTENSION));
        if (!in_array($fileExt, $this->ext)) {
            $this->errors[] = "Image not correct";
        }
    }

    // Validate file size
    private function validateSize() {
        if ($this->file['size'] > $this->size) {
            $this->errors[] = "Image size is too large";
        }
    }


    // Upload the file if validation passes
    private function upload() {
        if (empty($this->errors)) {
            $this->new_name = uniqid() . '.' . strtolower(pathinfo($this->image_name, PATHINFO_EXTENSION));
            if (!move_uploaded_file($this->file['tmp_name'], $this->uploadDir . $this->new_name)) {
                $this->errors[] = "Failed to upload image.";
            }
        }
    }

    public function getErrorsImg() {
        return $this->errors;
    }

    public function getNewFileName() {
        return $this->new_name;
    }
}

?>
