// javascript for triggering the dialogs
   
$( document ).ready(function() {
    $(function(){
       $("#btn-confirm").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel bearbeiten wollen?", function (result) {
            if (result) {
                        //$("#artikelspeichern-formActive").submit();
                        e.preventDefault();
                        $.ajax({
                                url: urlAjax,
                                type:'post',
                                data:$('#artikelspeichern-formActive').serialize(),
                        success:function(){
                            alert("worked");
                        }
    });

            }
        });
        });
    });
});
