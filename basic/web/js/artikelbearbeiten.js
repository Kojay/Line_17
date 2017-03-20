$(document).ready(function() { 
    
   $("#textinputNewProducer").hide();
   $("#dropdownProducers").show();

    var availableTags = [
        'ActionScript',
        'AppleScript',
        'Java'
    ];
    $("#searchNamesAuto").autocomplete({
        source: availableTags,
    });
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