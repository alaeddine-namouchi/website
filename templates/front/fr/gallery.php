<?php
include "bloc/head-import.php";
$current_page = "Galleri des photo"
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
            include "bloc/gallery-detail.php";
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
