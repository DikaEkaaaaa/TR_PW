<?php

if (isset($_SESSION['role'])){
    echo '
    <div class="position-fixed" style="bottom: 15px; right: 15px;">
        <a href="logout.php" class="btn btn-danger" style="padding: 20px;">
            <span style="font-size: 25px;">
                <i class="fa-solid fa-right-from-bracket"></i>
            </span>
        </a>
    </div>
    <script src="https://kit.fontawesome.com/eead4b3f85.js" crossorigin="anonymous"></script>
    ';
}
?>
