/**
 * Javascript for page "benutzerbearbeiten.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event to edit "Benutzer"
     * @Author Alexander Weinbeck
     */
    $("#btn-saveUser").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Benutzer bearbeiten wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#userupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle onclick event to delete "Benutzer"
     * @Author Alexander Weinbeck
     */
    $("#btn-deleteUser").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Benutzer löschen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#userupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
});