$('.btn-dark').on('click', function(){
    $('#eventModal .input-date').val($(this).data('date'));
    $('#eventModal').modal();
});

$('.btn-event').on('click',function(){
    var idEvent = $(this).data('id');
    $.ajax({
        url: 'ajax.php',
        data: {id : idEvent},
        type: 'GET',
        dataType: 'json'
    }).done(function(data){
        $('#editModal .input-date').val(data.date);
        $('#editModal .input-time').val(data.time);
        $('#editModal .select-categories').val(data.cat);
        $('#editModal .input-name').val(data.name);
        $('#editModal .input-id').val(data.id);
        $('#editModal .btn-remove').attr('data-event', data.id);
        $('#editModal').modal();
    });

    $('.btn-remove').on('click', function(){
        $('.btn-delete').attr('href', 'delete.php?id=' + $(this).attr('data-event')); 

        $('#removeModal').modal();
    });
});