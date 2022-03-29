function setSatatus(id) {
    $('#form_set_satus_'+id).submit();
}
function ShowEditForm(task) {
    taskObj = JSON.parse(task);
    let date = new Date(taskObj.deadline);
    let month = ("0" + (date.getMonth()+1)).slice(-2);
    let year = date.getFullYear();
    let day = ("0" + date.getDate()).slice(-2);
    $('#addTaskModal').modal('show');
    $("#txtTitle").attr('value', taskObj.title);
    $("#txtContent").val(taskObj.content);
    $('.datepicker').datepicker({format: 'yyyy-mm-dd'});
    $('.datepicker').datepicker('setDate', date);
    $("#intUserId option[value=" + taskObj.user.id + "]").prop('selected', true);
    $("#idTask").attr('value', taskObj.id);
    $('#modalTitle').text('Редактирование задачи');
}
 function resetFormAddEdit() {
    $("#txtTitle").attr('value', '');
    $("#txtContent").val('');
    $('.datepicker').datepicker('clearDates');
    $("#intUserId option[value='default']").prop('selected', true);
    $("#idTask").attr('value', '');
    $('#modalTitle').text('Создание задачи');
 }

 function ShowDeleteForm(href) {
    $('#deleteTaskModal').modal('show');
    $('#btnDeleteSubmit').click(function () {
        location.href = href;
    });
 }