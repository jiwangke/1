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


$conn->close();
?>