<?php
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;
?>
<div class="panel panel-info" style="margin-top: 50px">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span>&nbsp&nbspTabellenkonfiguration</h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item">
                Editiermodus
                <div class="material-switch pull-right">
                    <input id="switch_editmode" name="someSwitchOption001" type="checkbox"/>
                    <label for="switch_editmode" class="label-primary"></label>
                </div>
            </li>
            <li class="list-group-item editSwitch hidden" id="radio_columnselect" >
                <fieldset>
                    <input type="radio" id="radio_article" name="column" value="Mastercard">
                    <label for="article"> Artikel</label><br>
                    <input type="radio" id="radio_user" name="column" value="Visa">
                    <label for="user"> Benutzer</label><br>
                    <input type="radio" id="radio_loan" name="column" value="AmericanExpress">
                    <label for="loan"> Ausleihungen</label>
                </fieldset>
            </li>
        </ul>
        <div class="panel panel-primary hidden" id="columncfg_article">
            <div class="panel-heading">
                <h3 class="panel-title">Spaltenkonfiguration Artikel</h3>
            </div>
            <div class="">
                <ul class="list-group">
                    <li class="list-group-item">
                        Artikelname
                        <div class="material-switch pull-right">
                            <input id="switch_articleName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelproduzent
                        <div class="material-switch pull-right">
                            <input id="switch_articleproducerName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleproducerName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikeltyp
                        <div class="material-switch pull-right">
                            <input id="switch_articleTypeName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleTypeName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        FHNW Nummer
                        <div class="material-switch pull-right">
                            <input id="switch_fhnwNumber" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_fhnwNumber" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Seriennummer
                        <div class="material-switch pull-right">
                            <input id="switch_serialNumber" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_serialNumber" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelpreis
                        <div class="material-switch pull-right">
                            <input id="switch_articlePrice" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articlePrice" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Kaufdatum
                        <div class="material-switch pull-right">
                            <input id="switch_dateBought" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_dateBought" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Garantiedatum
                        <div class="material-switch pull-right">
                            <input id="switch_dateWarranty" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_dateWarranty" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelbeschreibung
                        <div class="material-switch pull-right">
                            <input id="switch_articleDescription" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleDescription" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihort
                        <div class="material-switch pull-right">
                            <input id="switch_loanLocation" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_loanLocation" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihdatum
                        <div class="material-switch pull-right">
                            <input id="switch_loanLendingDate" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_loanLendingDate" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Vorname
                        <div class="material-switch pull-right">
                            <input id="switch_personFirstname" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personFirstname" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Nachname
                        <div class="material-switch pull-right">
                            <input id="switch_personLastname" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personLastname" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Email
                        <div class="material-switch pull-right">
                            <input id="switch_personMail" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personMail" class="label-primary"></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel panel-primary hidden" id="columncfg_user">
            <div class="panel-heading">
                <h3 class="panel-title">Spaltenkonfiguration</h3>
            </div>
            <div class="">
                <ul class="list-group">
                    <li class="list-group-item">
                        Artikelname
                        <div class="material-switch pull-right">
                            <input id="switch_articleName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelproduzent
                        <div class="material-switch pull-right">
                            <input id="switch_articleproducerName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleproducerName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikeltyp
                        <div class="material-switch pull-right">
                            <input id="switch_articleTypeName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleTypeName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        FHNW Nummer
                        <div class="material-switch pull-right">
                            <input id="switch_fhnwNumber" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_fhnwNumber" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Seriennummer
                        <div class="material-switch pull-right">
                            <input id="switch_serialNumber" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_serialNumber" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelpreis
                        <div class="material-switch pull-right">
                            <input id="switch_articlePrice" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articlePrice" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Kaufdatum
                        <div class="material-switch pull-right">
                            <input id="switch_dateBought" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_dateBought" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Garantiedatum
                        <div class="material-switch pull-right">
                            <input id="switch_dateWarranty" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_dateWarranty" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelbeschreibung
                        <div class="material-switch pull-right">
                            <input id="switch_articleDescription" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleDescription" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihort
                        <div class="material-switch pull-right">
                            <input id="switch_loanLocation" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_loanLocation" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihdatum
                        <div class="material-switch pull-right">
                            <input id="switch_loanLendingDate" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_loanLendingDate" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Vorname
                        <div class="material-switch pull-right">
                            <input id="switch_personFirstname" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personFirstname" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Nachname
                        <div class="material-switch pull-right">
                            <input id="switch_personLastname" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personLastname" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Email
                        <div class="material-switch pull-right">
                            <input id="switch_personMail" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personMail" class="label-primary"></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel panel-primary hidden" id="columncfg_loan">
            <div class="panel-heading">
                <h3 class="panel-title">Spaltenkonfiguration</h3>
            </div>
            <div class="">
                <ul class="list-group">
                    <li class="list-group-item">
                        Artikelname
                        <div class="material-switch pull-right">
                            <input id="switch_articleName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelproduzent
                        <div class="material-switch pull-right">
                            <input id="switch_articleproducerName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleproducerName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikeltyp
                        <div class="material-switch pull-right">
                            <input id="switch_articleTypeName" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleTypeName" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        FHNW Nummer
                        <div class="material-switch pull-right">
                            <input id="switch_fhnwNumber" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_fhnwNumber" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Seriennummer
                        <div class="material-switch pull-right">
                            <input id="switch_serialNumber" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_serialNumber" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelpreis
                        <div class="material-switch pull-right">
                            <input id="switch_articlePrice" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articlePrice" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Kaufdatum
                        <div class="material-switch pull-right">
                            <input id="switch_dateBought" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_dateBought" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Garantiedatum
                        <div class="material-switch pull-right">
                            <input id="switch_dateWarranty" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_dateWarranty" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Artikelbeschreibung
                        <div class="material-switch pull-right">
                            <input id="switch_articleDescription" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_articleDescription" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihort
                        <div class="material-switch pull-right">
                            <input id="switch_loanLocation" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_loanLocation" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihdatum
                        <div class="material-switch pull-right">
                            <input id="switch_loanLendingDate" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_loanLendingDate" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Vorname
                        <div class="material-switch pull-right">
                            <input id="switch_personFirstname" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personFirstname" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Nachname
                        <div class="material-switch pull-right">
                            <input id="switch_personLastname" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personLastname" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Ausleihperson-Email
                        <div class="material-switch pull-right">
                            <input id="switch_personMail" name="someSwitchOption001" type="checkbox"/>
                            <label for="switch_personMail" class="label-primary"></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
$( document ).ready(function() { 
   $('#switch_editmode').change(function() {   
           $('#radio_columnselect').toggleClass('hidden');            
    });
    $('#radio_article').change(function() {          
            $('#columncfg_article').toggleClass('hidden');  
    });
});

JS;
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);
$this->registerCss("

");
?>