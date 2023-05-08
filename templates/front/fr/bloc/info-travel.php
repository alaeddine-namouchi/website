<div class="card " id="card-info-travel" style=" margin: -20px  auto 30px auto;min-height: 350px;">
    <div class="card-header adapte-card-header" style="    ">
        <ul class="nav nav-tabs flex inline-flex" id="myTab" role="tablist" style="">
            <li class="nav-item">
                <a class="nav-link active" id="time-tab" data-toggle="tab" href="#time" role="tab" aria-controls="time" aria-selected="false">Info Trafic</a>
            </li>
            <li class="nav-item" style="    ">
                <a class="nav-link  " id="horaire-tab" data-toggle="tab" href="#horaire" role="tab" aria-controls="horaire" aria-selected="true">Horaires</a>
            </li>
            <li class="nav-item" style="    ">
                <a class="nav-link  " id="tarif-tab" data-toggle="tab" href="#tarif" role="tab" aria-controls="tarif" aria-selected="true">Tarifs</a>
            </li>
            <li class="nav-item   d-none d-sm-block">
                <a class="nav-link " id="station-tab" data-toggle="tab" href="#station" role="tab" aria-controls="station" aria-selected="false">Stations</a>
            </li>
            <li class="nav-item  d-none d-sm-block">
                <a class="nav-link" id="section-tab" data-toggle="tab" href="#section" style="/*color: #009049;!important;font-weight: bold*/" role="tab" aria-controls="section" aria-selected="false">Sections</a>
            </li>
            <li class="nav-item   d-none d-sm-block">
                <a class="nav-link" id="listen-tab" data-toggle="tab" href="#listen" role="tab" aria-controls="listen" aria-selected="false">Ecoute clientèle</a>
            </li>
            <li class="nav-item  d-none d-sm-block">
                <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="false">Info générales</a>
            </li>
            <li class="nav-item dropdown d-block d-sm-none">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" id="titleMenu" href="#" role="button" aria-haspopup="true" aria-expanded="false">Autre Info</a>
                <div class="dropdown-menu" style="font-size: 10px; padding: 3px 5px 0px 5px;">
                    <a class="dropdown-item " data-toggle="tab" id="station-tab-m" href="#station" role="tab" aria-controls="station">Stations</a>
                    <a class="dropdown-item" data-toggle="tab" id="section-tab-m" href="#section" role="tab" aria-controls="section">Sections </a>
                    <a class="dropdown-item" data-toggle="tab" href="#listen" id="listen-tab-m" role="tab" aria-controls="listen">Ecoute clientèle</a>
                    <!--                       <div class="dropdown-divider"></div>-->
                    <a class="dropdown-item" data-toggle="tab" href="#general" id="general-tab-m" role="tab" aria-controls="general">Info générales</a>
                </div>
            </li>
        </ul>
    </div>
    <!--        <div class="card-body " style="background-color: #fff;border-top: 2px solid #f8af26;!important;"">-->
    <div class="card-body " style="background-color: #fff;">
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade content-box active show" id="time" role="tabpanel" aria-labelledby="time-tab">
                <div id="time-head"></div>
                <div id="time-detail-alert"></div>
                <div id="time-detail">
                    <div class="row justify-content ">
                        <style>
                            .btn-outline-infotrafic {
                                color: #28a745;
                                /* border-color: #28a745; */
                                border-color: rgb(27, 107, 7);
                                border: 2px solid transparent !important;

                            }
                        </style>
                        <div class="col-12 col-md-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item metro">
                                    <?php include 'bloc/fragment_bloc/infotrafic-metro.php'; ?>

                                </li>
                                <li class="list-group-item bus">
                                <?php include 'bloc/fragment_bloc/infotrafic-bus.php'; ?>

                                </li>
                                <li class="list-group-item tgm">
                                <?php include 'bloc/fragment_bloc/infotrafic-tgm.php'; ?>

                                </li>

                            </ul>
                        </div>
                        <div class="col-12 col-md-6"></div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="tab-pane fade content-box" id="horaire" role="tabpanel" aria-labelledby="horaire-tab">
            <div id="horaire-head"></div>
            <div id="horaire-detail" style="font-size: 12px">
            <?php include 'bloc/iframe-info-travel.php'; ?>     
            </div>

        </div>
        </div>
        
        <div class="tab-pane fade  content-box" id="station" role="tabpanel" aria-labelledby="station-tab">
            <div id="station-head"></div>
            <div id="station-detail" class="row" style="font-size: 12px">
            </div>
        </div>
        <!-- <div class="tab-pane fade" id="section" role="tabpanel" aria-labelledby="section-tab" style="font-size: 12px"></div>
        <div class="tab-pane fade" id="listen" role="tabpanel" aria-labelledby="listen-tab">
            <p id="msg-contsruct-page-listen"> Page en cours de construction </p>
        </div>
        <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
            <p id="msg-contsruct-page-info"> Page en cours de construction </p>
        </div> -->
    </div>
</div>
<!-- </div>
</div> -->