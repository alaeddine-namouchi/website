<?php
include "bloc/head-import.php";

$current_page = "accèes à l'information"
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
            <div class=" container  px-2">
            <!-- <div> -->
                <!-- START : BLOC INFO VOUYAGEURS -->
        <?php
            include "bloc/detail-access-to-info.php";
        ?>
            </div>
        </div>
    <!-- /.container -->
        <?php
            include "bloc/footer.php";    
        ?>
    </main>

    <?php
        include "bloc/import-js.php";    
    ?>




