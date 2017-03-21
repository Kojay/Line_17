/**
 * Javascript for page "neuerartikel.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event of create "Artikel"
     * @Author Alexander Weinbeck
     */
    $("#btn-create").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel erstellen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'create' },
                    data:$('#createArticle-formActive').serialize(),
                    success:function(){
                        //execute changes if needed ...
                    }
                });
            }
        });
    });
    /**
     * Function to handle check event of "Articleproducers"
     * @Author Alexander Weinbeck
     */
    $(':checkbox').change(function() {
        if($(':checkbox').prop('checked')){
            $('#textinputNewProducer').show();
            $('#dropdownProducers').hide();
        }
        else{
            $('#textinputNewProducer').hide();
            $('#dropdownProducers').show();
        }
    });
});