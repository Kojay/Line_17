/**
 * Javascript for page "artikelbearbeiten.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event of edit "Artikel"
     * @Author Alexander Weinbeck
     */
    $("#btn-updateArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel bearbeiten wollen?",
        function (result) {
            $("#fnc").value = 'update';
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#articleupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle onclick event to delete "Artikel"
     * @Author Alexander Weinbeck
     */
    $("#btn-deleteArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel l�schen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#articleupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle check event of "Artikelproducers"
     * @Author Alexander Weinbeck
     */
    $("#textinputNewProducer").hide();
    $("#dropdownProducers").show();
    $(":checkbox").change(function() {
        if($(":checkbox").prop('checked')){
           $("#textinputNewProducer").show();
           $("#dropdownProducers").hide();
        }
        else{
           $("#textinputNewProducer").hide();
           $("#dropdownProducers").show();
        }               
    });
});