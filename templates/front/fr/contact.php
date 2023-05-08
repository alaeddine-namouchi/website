<?php
include "bloc/head-import.php";
$current_page = "Contact"
?>

<body>
    <?php
    include "bloc/header.php";
    // include "bloc/header-big-menu.php";
    // include "bloc/header-mega-menu.php";
    ?>
    <main role="main">
        <div class="container- marketing bg-light">
        <?php
            include "bloc/fil_arian.php";
        ?>
            <div class=" container">
            <!-- <div> -->
                <!-- START : BLOC INFO VOUYAGEURS -->
                <?php
                include "bloc/form-contact.php";
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