<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/wp-includes/class-wpdb.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

global $wpdb;
$name = "%quan%";
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->wp_users} WHERE user_login like %s", $name
    
);
$results = $wpdb->get_results($sql);

echo $results;

     ?>
</body>
</html>