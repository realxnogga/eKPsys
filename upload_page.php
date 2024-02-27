<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
</head>
<body>

<a href="user_complaints.php" class="btn btn-outline-dark m-1">Back to Complaints</a>

<h1>Uploaded Files</h1>

<ul>
    <?php foreach ($uploadedList as $fileInfo): ?>
        <li>
            <span><?= $fileInfo['file_name'] ?></span>
            <a href="download.php?file=<?= $fileInfo['file_path'] ?>" target="_blank" download>
                <button>Download</button>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>
