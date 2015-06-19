$("#modal").on("hidden.bs.modal", function() {
    $(this).removeData("bs.modal");
});
authUser={
    add:function(e){
        $('#modalContent').load($(e).attr('href'),function(){
            $('#modal').modal('show');
        });
    }
}