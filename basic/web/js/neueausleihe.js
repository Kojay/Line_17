/**
 * Javascript for page "neueausleihe.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event of create "Ausleihe"
     * @Author Alexander Weinbeck
     */
    $("#btn-create").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie die Ausleihe erstellen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'create' },
                    data:$('#createRental-formActive').serialize(),
                    success:function(){
                        //execute changes if needed ...
                    }
                });
            }
        });
    });
});