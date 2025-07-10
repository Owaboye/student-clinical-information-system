<?php 
// $name = sanitizeName($_POST['name']);
// $email = sanitizeEmail($_POST['email']);
// $password = $_POST['password'];

// $errors = [];

// // Validate Name
// if (!validateName($name)) $errors[] = "Invalid name format.";

// // Validate Email
// if (!validateEmail($email)) $errors[] = "Invalid email address.";

// // Validate Password
// $passwordErrors = validatePassword($password);
// $errors = array_merge($errors, $passwordErrors);

// // Handle Image Upload
// list($uploadedImagePath, $imageErrors) = handleImageUpload($_FILES['profile_image']);
// $errors = array_merge($errors, $imageErrors);

// if (empty($errors)) {
//     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//     echo "All inputs are valid and image uploaded to: $uploadedImagePath";
//     // Proceed to save to DB
// } else {
//     foreach ($errors as $e) {
//         echo "<p style='color:red;'>$e</p>";
//     }
// }

echo password_hash('admin123', PASSWORD_DEFAULT);


 ?>