<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $dob = htmlspecialchars($_POST['dob']);
    $position = htmlspecialchars($_POST['position']);

    $uploadDir = 'uploads/';
    $essayDir = $uploadDir . 'essays/';
    $docsDir = $uploadDir . 'documents/';

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    if (!is_dir($essayDir)) mkdir($essayDir, 0777, true);
    if (!is_dir($docsDir)) mkdir($docsDir, 0777, true);

    if (isset($_FILES['essay']) && $_FILES['essay']['error'] === UPLOAD_ERR_OK) {
        $essayTmpPath = $_FILES['essay']['tmp_name'];
        $essayFileName = basename($_FILES['essay']['name']);
        $essayDestPath = $essayDir . $essayFileName;

        if (!move_uploaded_file($essayTmpPath, $essayDestPath)) {
            echo "<p style='color: red;'>Failed to upload introduction. Try again.</p>";
            exit;
        }
    } else {
        echo "<p style='color: red;'>Error uploading introduction. Try again.</p>";
        exit;
    }

    $uploadedDocs = [];
    if (isset($_FILES['docs']) && is_array($_FILES['docs']['name'])) {
        foreach ($_FILES['docs']['name'] as $index => $fileName) {
            if ($_FILES['docs']['error'][$index] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['docs']['tmp_name'][$index];
                $fileDestPath = $docsDir . basename($fileName);

                if (move_uploaded_file($fileTmpPath, $fileDestPath)) {
                    $uploadedDocs[] = $fileDestPath;
                } else {
                    echo "<p style='color: red;'>Error uploading document: $fileName.</p>";
                    exit;
                }
            }
        }
    } else {
        echo "<p style='color: red;'>Error uploading documents. Try again.</p>";
        exit;
    }

    echo "<h2>Registration Successful!</h2>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Phone:</strong> $phone</p>";
    echo "<p><strong>Date of Birth:</strong> $dob</p>";
    echo "<p><strong>Preferred Position:</strong> $position</p>";
    echo "<p><strong>Introduction:</strong> <a href='$essayDestPath' target='_blank'>View Introduction</a></p>";

    if (!empty($uploadedDocs)) {
        echo "<p><strong>Documents:</strong></p><ul>";
        foreach ($uploadedDocs as $doc) {
            echo "<li><a href='$doc' target='_blank'>" . basename($doc) . "</a></li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p style='color: red;'>Invalid request. Submit the form correctly.</p>";
}
?>
