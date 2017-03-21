/**
 * Javascript for page "artikelbearbeiten.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event of repair "Artikel"
     * @Author Alexander Weinbeck
     */
    $("#btn-repairArticle").click(function(e){
        krajeeDialog.prompt({label:'Geben Sie einen Grund für den Status "Reparatur" an:', placeholder:'Begründung...'},
        function (result) {
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'repair' },
                    data:$('#articleupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle onclick event to archive "Artikel"
     * @Author Alexander Weinbeck
     */
    $("#btn-archiveArticle").click(function(e){
        krajeeDialog.prompt({label:'Geben Sie einen Grund für die Archivierung an:', placeholder:'Begründung...'},
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'archive' },
                    data:$('#articleupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
});