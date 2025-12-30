<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 

require_once __DIR__ . '/wp-load.php';
function wcec_send_email() {
    $to      = get_option( 'admin_email' );
    $subject = 'Báo cáo định kỳ từ website';
    $message = 'Đây là email được gửi tự động bằng WP-Cron.';
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );

    wp_mail( $to, $subject, $message, $headers );
}
     wcec_send_email();
     ?>
</body>
</html>