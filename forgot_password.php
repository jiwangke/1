<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // 数据库连接
    $servername = "localhost";
    $username = "root"; // 数据库用户名
    $password = "root"; // 数据库密码
    $dbname = "user_data"; // 替换为你的数据库名

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    // 检查邮箱是否存在
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // 如果邮箱存在，生成重置链接（模拟链接）
        $resetToken = bin2hex(random_bytes(16)); // 生成随机重置令牌
        $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $resetToken;

        // 保存重置令牌到数据库
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
        $expiry = date("Y-m-d H:i:s", time() + 3600); // 令牌有效期1小时
        $stmt->bind_param("sss", $resetToken, $expiry, $email);
        $stmt->execute();

        // 模拟发送邮件
        echo "重置密码的链接已发送到您的邮箱: " . htmlspecialchars($resetLink);
    } else {
        echo "邮箱未注册!";
    }

    $stmt->close();
    $conn->close();
}
?>