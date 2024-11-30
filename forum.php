<?php
// 数据库配置
$servername = "localhost";
$username = "root";
$password = "root";
$database = "forum";

// 创建连接
$conn = new mysqli($servername, $username, $password, $database);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 如果收到提交表单的数据
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['comment'])) {
    $user = $conn->real_escape_string($_POST['username']);
    $com = $conn->real_escape_string($_POST['comment']);

    // 插入数据到数据库
    $sql = "INSERT INTO bb (username, comment) VALUES ('$user', '$com')";
    if (!$conn->query($sql)) {
        echo "错误: " . $sql . "<br>" . $conn->error;
    }
}

// 查询数据库获取所有评论
$sql = "SELECT username, comment FROM bb ORDER BY id DESC";
$result = $conn->query($sql);
$comments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>论坛</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('1234.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #ffffff;
        }
        header {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 auto;
            width: 90%;
            max-width: 1200px;
        }
        nav .links {
            display: flex;
            gap: 15px;
        }
        nav a {
            text-decoration: none;
            color: #ffffff;
            padding: 10px 20px;
            margin: 0;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        nav a:hover {
            background-color: #4caf50;
            color: #ffffff;
        }
        .logout-btn {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #d32f2f;
        }
        h1 {
            margin-top: 20px;
            font-size: 2.5rem;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8);
            text-align: center;
        }
        .form-container {
            margin-top: 20px;
            width: 90%;
            max-width: 700px;
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin: 0 auto;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }
        input:focus, textarea:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.8);
        }
        button {
            padding: 15px;
            font-size: 1rem;
            color: #ffffff;
            background-color: #4caf50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .comments-container {
            margin-top: 30px;
            width: 90%;
            max-width: 700px;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            margin: 0 auto;
        }
        .comment {
            margin-bottom: 20px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .comment p {
            margin: 5px 0;
        }
        .comment .username {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="links">
                <a href="forum.php">主页</a>
                <a href="#post">发帖</a>
                <a href="#discussion">讨论区</a>
                <a href="#messages">消息中心</a>
                <a href="#profile">个人中心</a>
            </div>
            <button class="logout-btn" onclick="window.location.href='login.html'">退出登录</button>
        </nav>
    </header>
    <h1>论坛</h1>
    <div class="form-container">
        <form action="" method="POST">
            <input type="text" name="username" placeholder="用户名" required>
            <textarea name="comment" placeholder="在这里发表评论..." rows="5" required></textarea>
            <button type="submit" name="submit">提交评论</button>
        </form>
    </div>
    <div class="comments-container">
        <h2>论坛评论区</h2>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p class="username">用户: <?= htmlspecialchars($comment['username']) ?></p>
                <p>评论: <?= htmlspecialchars($comment['comment']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>