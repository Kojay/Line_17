/**
 * Javascript for page "ausleihebearbeiten.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * TODO Autocomplete element to search Active Directory users
     * @Author Alexander Weinbeck
     */
    var availableTags = [
        'ActionScript',
        'AppleScript',
        'Java'
    ];
    $("#searchNamesAuto").autocomplete({
        source: availableTags,
    });
    /**
     * Function to handle onclick event of edit "Ausleihe"
     * @Author Alexander Weinbeck
     */
   $("#btn-updateArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass Sie die Ausleihe bearbeiten wollen?",
        function (result) {
            $("#fnc").value = 'update';
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#rentalupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle onclick event of delete "Ausleihe"
     * @Author Alexander Weinbeck
     */
    $("#btn-deleteArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass Sie die Ausleihe l�schen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#rentalupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
});