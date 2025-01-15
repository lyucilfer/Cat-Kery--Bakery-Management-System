<?php

function displayMessages($messages) {
    if (isset($messages)) {
        foreach ($messages as $message) {
            echo '
            <div class="message">
                <span>' . htmlspecialchars($message) . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
}

function fetchMessages($conn, $user_id = null) {
    if ($user_id) {
        $query = "SELECT messages.*, replies.reply_message FROM `messages` LEFT JOIN replies ON messages.id = replies.message_id WHERE messages.user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id]);
    } else {
        $query = "SELECT * FROM `messages`";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function renderMessage($message, $isAdmin = false) {
    echo '<div class="message">';
    echo '<p>Name: ' . htmlspecialchars($message['name']) . '</p>';
    echo '<p>Number: ' . htmlspecialchars($message['number']) . '</p>';
    echo '<p>Email: ' . htmlspecialchars($message['email']) . '</p>';
    echo '<p>Message: ' . htmlspecialchars($message['message']) . '</p>';

    if (!empty($message['reply_message'])) {
        echo '<p>Admin Reply: ' . htmlspecialchars($message['reply_message']) . '</p>';
    }

    if ($isAdmin) {
        echo '<a href="messages.php?delete=' . $message['id'] . '" class="delete-btn" onclick="return confirm(\'Delete this message?\');">Delete</a>';
        echo '<a href="reply.php?id=' . $message['id'] . '" class="reply-btn">Reply</a>';
    }

    echo '</div>';
}

?> 