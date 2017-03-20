/**
 * Javascript for page "neuerbenutzer.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
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
                    data:$('#createbenutzer-formActive').serialize(),
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