/**
 * Javascript for page "neuerbenutzer.php"
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
    $("#searchNamesAD").autocomplete({
        source: searchADNames,
    });
    /**
     * Function to handle onclick event to create "Benutzer"
     * @Author Alexander Weinbeck
     */
    $("#btn-createUser").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Benutzer erstellen wollen?", function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'create' },
                    data:$('#createuser-formActive').serialize(),
                    success:function(){
                        //execute changes if needed ...

                        $('#SuccessText').delay(500).fadeIn("normal", function() {
                            $(this).delay(2500).fadeOut("normal");
                        });

                    }
                });

            }
        });
    });
});