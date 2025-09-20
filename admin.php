<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

// معالجة إضافة حصة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $day = $_POST['day'];
    $time = $_POST['time'];
    $subject = 'لغة إنجليزية'; // افترضنا أن المادة ثابتة
    $teacher = $_SESSION['user']['username'];

    $stmt = $pdo->prepare('INSERT INTO schedule (day, time, subject, teacher) VALUES (?, ?, ?, ?)');
    $stmt->execute([$day, $time, $subject, $teacher]);
}

// معالجة حذف حصة
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM schedule WHERE id = ?');
    $stmt->execute([$id]);
}

// جلب الجدول
$stmt = $pdo->query('SELECT * FROM schedule ORDER BY 
    FIELD(day, "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس"), 
    time');
$schedule = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - أستاذ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">نظام إدارة الجدول</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text">مرحباً، <?= $_SESSION['user']['username'] ?></span>
                <a class="nav-link" href="logout.php">تسجيل الخروج</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>إدارة الجدول</h2>
        
        <form method="post" class="mb-3">
            <div class="row">
                <div class="col">
                    <select name="day" class="form-select" required>
                        <option value="">اختر اليوم</option>
                        <option value="الأحد">الأحد</option>
                        <option value="الإثنين">الإثنين</option>
                        <option value="الثلاثاء">الثلاثاء</option>
                        <option value="الأربعاء">الأربعاء</option>
                        <option value="الخميس">الخميس</option>
                    </select>
                </div>
                <div class="col">
                    <select name="time" class="form-select" required>
                        <option value="">اختر الوقت</option>
                        <option value="08:00 - 09:30">08:00 - 09:30</option>
                        <option value="10:00 - 11:30">10:00 - 11:30</option>
                        <option value="12:00 - 13:30">12:00 - 13:30</option>
                        <option value="14:00 - 15:30">14:00 - 15:30</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" name="add" class="btn btn-primary">إضافة حصة</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اليوم</th>
                    <th>الوقت</th>
                    <th>المادة</th>
                    <th>الأستاذ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedule as $row): ?>
                <tr>
                    <td><?= $row['day'] ?></td>
                    <td><?= $row['time'] ?></td>
                    <td><?= $row['subject'] ?></td>
                    <td><?= $row['teacher'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>