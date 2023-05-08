<?php
include "bloc/head-import.php";
$current_page = "Recrutement"
?>
<body>
    <?php
        include "bloc/header.php";
        // include "bloc/header-big-menu.php";
        // include "bloc/header-mega-menu.php";
    ?>
    <main role="main">

        <div class="container-fluid marketing bg-light pb-5" >
        <?php
            include "bloc/fil_arian.php";
        ?>
            
            <div class=" container">
                
        <?php
            include "bloc/recruitment-detail.php";
        ?>
            </div>
        </div>

        <?php
            include "bloc/footer.php";    
        ?>
    </main>

    <?php
        include "bloc/import-js.php";    
    ?>


