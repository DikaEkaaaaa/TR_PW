<?php

if (isset($_SESSION['role'])){
    echo '
    <div class="position-fixed" style="top: 10px; right: 10px;">
        <a href="logout.php" class="btn" style="border: 2px solid red; color: red;">
            Logout
        </a>
    </div>
    ';
}
?>
