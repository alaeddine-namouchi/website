<?php 


if(isset($current_page)){
    $current = $current_page;
}
else{
    $current = "";
}

?>
<div class="container">
    <div class="row mt-5" style="padding-left: 0px;padding-right:0px">
        <div class="col">
            <nav aria-label="breadcrumb" style="    margin-top: 25px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#"><?php echo $current; ?></a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>