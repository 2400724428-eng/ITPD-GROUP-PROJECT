<?php
// admin/api/process-add-user.php

// Adjust path to reach includes/db_connect.php from admin/api/
require_once __DIR__ . '/../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($pdo)) {
            throw new Exception("Database connection not established.");
        }

        $email = trim($_POST['email']);
        $trainer_name = trim($_POST['trainer_name']);
        $role = $_POST['role'];
        $raw_password = $_POST['password'];
        
        // Hash password securely
        $password_hash = password_hash($raw_password, PASSWORD_DEFAULT);

        // Handle profile picture upload
        $profile_pic_path = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
            $fileName = $_FILES['profile_pic']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                
                // Store uploads in the public root or an accessible directory
                $uploadFileDir = __DIR__ . '/../../uploads/';
                
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                
                $dest_path = $uploadFileDir . $newFileName;
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $profile_pic_path = $newFileName;
                }
            }
        }

        // Insert into database matching gymnuser table schema
        $sql = "INSERT INTO gymnuser (role, email, trainer_name, profile_pic, password_hash, created_at) 
                VALUES (:role, :email, :trainer_name, :profile_pic, :password_hash, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'role' => $role,
            'email' => $email,
            'trainer_name' => $trainer_name,
            'profile_pic' => $profile_pic_path,
            'password_hash' => $password_hash
        ]);

        header("Location: ../dashboard.php?status=success");
        exit();

    } catch (Exception $e) {
        header("Location: ../dashboard.php?status=error&message=" . urlencode($e->getMessage()));
        exit();
    }
}
?>