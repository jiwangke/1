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
// 查询用户
$sql = "SELECT * FROM aa WHERE name = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sql = "SELECT * FROM aa WHERE name= '$user' AND password = '$pass'";
    $result=$conn->query($sql);
    if ($result->num_rows > 0) {
        header("Location:forum.php");
        exit(); // 确保脚本停止执行
    } else {
        echo "密码错误！<a href='login.html'>返回重试</a>";
    }
} else {
    echo "用户不存在！<a href='login.html'>返回重试</a>";
}
$conn->close();
?>