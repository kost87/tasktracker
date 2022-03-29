@extends('layouts.base')

@section('title', 'Главная')

@section('main')

@if (count($tasks) > 0)
    @foreach ($tasks as $task)
        @if($task->expired)
            <div class="card text-card card-danger">
        @else
            <div class="card text-card">
        @endif
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <p>{{ $task->user->sname }} {{ $task->user->fname }}</p>
                        </div>
                        <div class="col">
                            <div class="float-end">
                                <div class="dropdown">
                                <div data-bs-toggle="dropdown" aria-expanded="false">
                                    <a><img class="menu-item" src="../resources/img/ellipsis.png" width="30px"></a>
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item menu-item" onClick="ShowEditForm('{{ $task }}')">Редактировать</a></li>
                                    <li><a class="dropdown-item menu-item" onClick="ShowDeleteForm('{{ route('task.destroy', ['task' => $task->id]) }}')">Удалить</a></li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p><b>{{ $task->title }}</b></p>
                    <p>{{ $task->content }}</p>
                

                    <div class="row">
                        <div class="col-sm">
                            Статус задачи<br>
                            <form id="form_set_satus_{{ $task->id }}" action="{{ route('task.setStatus', ['task' => $task->id]) }}" method="POST">
                                @csrf    
                                @if($task->finished == true)
                                    <select class="form-select" onChange="setSatatus({{ $task->id }})" name="status_id" id="intStatusId" disabled>
                                @else
                                    <select class="form-select" onChange="setSatatus({{ $task->id }})" name="status_id" id="intStatusId">
                                @endif
                                    @foreach ($statuses as $status)
                                        @if($task->status->id == $status->id)    
                                            <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                        @else
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endif
                                    @endforeach
                                <select>
                            </form>
                        </div>
                        <div class="col-sm">
                        Срок выполнения<br>
                        <label class="form-control">{{ $task->deadline }}</label> 
                        </div>
                        <div class="col-sm">
                        Дата выполнения<br>
                        <label class="form-control">{{ $task->date_done }}</label> 
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    @endforeach
@else
    <h3>Список пуст. Добавьте задачу.</h3>
@endif
<!-- Диалоговое окно формы добавления/редактирования задачи -->
<div class="modal" tabindex="-1" id="addTaskModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Создание задачи</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="formAddEdit" action="{{ route('task.store') }}" method="POST">
                @csrf
                <input type="hidden" name="show_add_form" value="1">
                <input type="hidden" name="id" id="idTask" value="{{ old('id') }}">
                <div class="form-group">
                    <lable for="txtTitle">Название задачи</lable>
                    <input name="title" id="txtTitle" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>
                <div class="form-group">
                    <lable for="txtContent">Описание задачи</lable>
                    <textarea name="content" id="txtContent" class="form-control @error('content') is-invalid @enderror" row="3">{{ old('content') }}</textarea>
                    @error('content') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>
                <!--<div class="form-group">-->
                    
                    <!--<input name="deadline" id="dateDeadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">-->
                    <div class="form-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-language="ru">
                        <lable for="dateDeadline">Срок выполнения</lable>
                        <input type="text" class="datepicker form-control @error('deadline') is-invalid @enderror" name="deadline" id="dateDeadline" value="{{ old('deadline') }}">
                        <div class="input-group-addon"></div>
                        @error('deadline') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>
                <div class="form-group">
                    <lable for="intUserId">Исполнитель</lable>
                    <select name="user_id" id="intUserId" class="form-control @error('user_id') is-invalid @enderror">
                        <option value="default">Выберите исполнителя</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->sname }} {{ $user->fname }}</option>
                        @endforeach
                    <select>
                    @error('user_id') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>
                <br>
                <input type="submit" class="btn btn-primary" value="Сохранить">
                &nbsp;
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- Диалоговое окно удаления задачи -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Удаление задачи</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        Вы уверены, что хотите удалить задачу?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-primary" id="btnDeleteSubmit">Ok</button>
      </div>
    </div>
  </div>
</div>



@if(old('show_add_form')==1)
    <script>   $( document ).ready(function() { $('#addTaskModal').modal('show') }); </script>
@endif
    <script>
        $( document ).ready(function()
        {
            $("#intUserId option[value={{ old('user_id', 'default') }}]").prop('selected', true);
            $("#btnAddTask").click(function(){
                resetFormAddEdit();
                $('#addTaskModal').modal('show');
            });
        });
    </script>
@endsection