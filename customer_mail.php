<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include 'Connect_db.php';

$message = "";

if (isset($_GET['send_id'])) {
    $id = $_GET['send_id'];
    
    
    $stmt = $conn->prepare("SELECT * FROM Customer WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $customer = $stmt->get_result()->fetch_assoc();

    if ($customer) {
        $mail = new PHPMailer(true);
        try {
            
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your_email@gmail.com'; 
            $mail->Password   = 'your_app_password';    
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->setCharset('UTF-8');

           
            $mail->setFrom('your_email@gmail.com', 'BookStore Manager');
            $mail->addAddress($customer['email'], $customer['fullname']);

        
            $mail->isHTML(true);
            $mail->Subject = 'Thông báo từ BookStore';
            $mail->Body    = "Chào <b>{$customer['fullname']}</b>,<br>Cảm ơn bạn đã ủng hộ cửa hàng của chúng tôi!";

            $mail->send();
            $message = "<p style='color:green'>Đã gửi mail thành công đến: " . $customer['email'] . "</p>";
        } catch (Exception $e) {
            $message = "<p style='color:red'>Lỗi gửi mail: {$mail->ErrorInfo}</p>";
        }
    }
}


$customers = $conn->query("SELECT * FROM Customer");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý gửi mail khách hàng</title>
</head>
<body>

    <h2>Danh sách Khách hàng</h2>
    <?php echo $message; ?>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f2f2f2;">
                <th>Tên khách hàng</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Giới tính</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $customers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['fullname']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td>
                        <a href="?send_id=<?php echo $row['id']; ?>">
                            <button type="button">Gửi Mail</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>