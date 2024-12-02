<?php
// Tombol logout berada di pojok kanan atas
if (isset($_SESSION['role'])){
    echo '
    <div class="position-fixed" style="top: 10px; right: 10px;">
        <a href="logout.php" class="btn" style="border: 2px solid red; background-color: transparent; color: red;">
            Logout
        </a>
    </div>
    ';
}
?>
