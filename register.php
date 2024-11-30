<?php
$servername = "localhost";
$username = "root";
$password = "root"; // 根据你的配置修改
$database = "user_data";

// 创建连接
$conn = new mysqli($servername, $username, $password, $database);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取表单数据
$user = $_POST['username'];
$pass = $_POST['password'];
$email = $_POST['email']; // 获取邮箱

// 检查用户名是否已存在
$sql = "SELECT * FROM aa WHERE name = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "用户名已存在！<a href='register.html'>返回重试</a>";
} else {
    // 检查邮箱是否已存在
    $email_check_sql = "SELECT * FROM aa WHERE email = '$email'";
    $email_check_result = $conn->query($email_check_sql);

    if ($email_check_result->num_rows > 0) {
        echo "该邮箱已被注册！<a href='register.html'>返回重试</a>";
    } else {
        // 插入用户信息，包括用户名、密码和邮箱
        $new_sql = "INSERT INTO aa (name, password, email) VALUES ('$user', '$pass', '$email')";
        
        if ($conn->query($new_sql) === TRUE) {
            header("Location: login.html");
            exit(); // 确保脚本停止执行
        } else {
            echo "注册失败！<a href='register.html'>返回重试</a>";
        }
    }
}

$conn->close();
?>