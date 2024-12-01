<?php
// Tombol logout berada di pojok kanan atas
if (isset($_SESSION['role'])){
    echo '
    <div class="position-fixed" style="top: 10px; right: 10px;">
        <a href="logout.php" class="btn btn-danger btn-sm">
            Logout
        </a>
    </div>
    ';
}
?>