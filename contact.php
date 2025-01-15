<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location: login.php'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'Already sent message!';
    } else {
        $insert_message = $conn->prepare("INSERT INTO `messages` (user_id, name, email, number, message) VALUES (?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        $message[] = 'Sent message successfully!';
    }
}

// Fetch only user's messages with replies
$select_messages = $conn->prepare("SELECT messages.*, replies.reply_message FROM `messages` LEFT JOIN replies ON messages.id = replies.message_id WHERE messages.user_id = ?");
$select_messages->execute([$user_id]);
$messages = $select_messages->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>Contact Us</h3>
        <p><a href="home.php">Home</a> <span>/ Contact</span></p>
    </div>

    <!-- contact section starts  -->
    <section class="contact">
        <div class="row">
            <div class="image">
                <img src="images/contact-img.svg" alt="">
            </div>

            <form action="" method="post">
                <h3>Tell us something!</h3>
                <input type="text" name="name" maxlength="50" class="box" placeholder="Enter your name" required>
                <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required maxlength="10">
                <input type="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>
                <textarea name="msg" class="box" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>
                <input type="submit" value="Send Message" name="send" class="btn">
            </form>
        </div>
    </section>
    <!-- contact section ends -->
    
    <!-- Display user's messages with replies -->
    <div class="messages-container">
        <?php
            foreach ($messages as $message) {
                echo '<div class="message">';
                echo '<p>Name: ' . $message['name'] . '</p>';
                echo '<p>Number: ' . $message['number'] . '</p>';
                echo '<p>Email: ' . $message['email'] . '</p>';
                echo '<p>Message: ' . $message['message'] . '</p>';

                // Display reply if available
                if (!empty($message['reply_message'])) {
                    echo '<p>Admin Reply: ' . $message['reply_message'] . '</p>';
                }

                echo '</div>';
            }
        ?>
    </div>

    <?php include 'components/footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
