<?php
// echo 'Current PHP version: ' . phpversion();die;
include "bloc/head-import.php";
$current_page = "Abonnements"
?>
<body>
    <?php
        include "bloc/header.php";
        // include "bloc/header-big-menu.php";
        // include "bloc/header-mega-menu.php";
    ?>
    <main role="main">

        <div class="container marketing  pb-5" >
        <?php
            include "bloc/fil_arian.php";
        ?>
            <!-- <div class=" container"> -->
            <div>
                
        <?php
            include "bloc/detail-abonnement.php";
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




