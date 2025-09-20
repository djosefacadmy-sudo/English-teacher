<?php
require 'config.php';

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
    <title>جدول الحصص - عرض عام</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">جدول الحصص - اللغة الإنجليزية</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>جدول الحصص (عرض عام)</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اليوم</th>
                    <th>الوقت</th>
                    <th>المادة</th>
                    <th>الأستاذ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedule as $row): ?>
                <tr>
                    <td><?= $row['day'] ?></td>
                    <td><?= $row['time'] ?></td>
                    <td><?= $row['subject'] ?></td>
                    <td><?= $row['teacher'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>