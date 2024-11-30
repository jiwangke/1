
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
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['username']) && isset($_POST['comment'])) {
      $user = $conn->real_escape_string($_POST['username']);
      $com = $conn->real_escape_string($_POST['comment']);

    // 插入数据到数据库
    $sql = "INSERT INTO bb (username, comment) VALUES ('$user', '$com')";
    if (!$conn->query($sql)) {
        echo "错误: " . $sql . "<br>" . $conn->error;
    }
   
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