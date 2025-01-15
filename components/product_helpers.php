<?php
function displayProductForm($product) {
    echo '<form action="" method="post" class="box">';
    echo '<input type="hidden" name="pid" value="' . htmlspecialchars($product['id']) . '">';
    echo '<input type="hidden" name="name" value="' . htmlspecialchars($product['name']) . '">';
    echo '<input type="hidden" name="price" value="' . htmlspecialchars($product['price']) . '">';
    echo '<input type="hidden" name="image" value="' . htmlspecialchars($product['image']) . '">';
    echo '</form>';
}

function displayProductImage($image) {
    echo '<img src="uploaded_img/' . htmlspecialchars($image) . '" alt="">';
}
?> 