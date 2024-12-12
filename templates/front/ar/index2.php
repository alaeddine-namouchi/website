<?php
include "bloc/head-import.php";

?>
<body>
    <?php
        include "bloc/header.php";
        // include "bloc/header-big-menu.php";
        // include "bloc/header-mega-menu.php";
    ?>
    <main role="main">
        <?php
            include "bloc/baniere.php";
        ?>
        <div class="container-fluid marketing bg-light" >
            <!-- <div class="my-3 p-3 bg-white  box-shadow">
                <div class="embed-responsive " id="zframe"  style="padding-bottom:450px!important; margin: -130px  auto 0 auto;" >
                <iframe id="myIframe" class=" rounded-sm" src="http://info.transtu.tn/info.php" title="Information vouyageurs version 1.0" frameborder="1" onmouseover="resizeIframe(this)"  onload="resizeIframe(this)" >
                </iframe>
                </div>
            </div> -->
            <!-- <div class=" container"> -->
            <div>
                <!-- START : BLOC INFO VOUYAGEURS -->
        <?php
            include "bloc/info-travel.php";
        ?>
            
        <?php
            include "bloc/communication.php";
        ?>

</div>
        <!-- <?php 
            // include "bloc/communication-2.php";
        ?> -->
        <?php
          //  include "bloc/other.php";
        ?>
    <!-- /.container -->
        <?php
            include "bloc/footer.php";    
        ?>
</div>
    </main>

    <?php
        include "bloc/import-js.php";    
    ?>




