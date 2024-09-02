<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM jabatan WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: jabatan.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: jabatan.php");
    exit();
}
