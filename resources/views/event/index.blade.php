@extends('layouts.app')

@section('content')

    <div class="container">

        <div id="calendar">
            
            
            
        </div>
       
        <!-- Modal -->
        <div class="modal fade" id="event" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Datos del evento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formularioEventos">
                            
                            @csrf

                            <div class="form-group d-none">
                              <label for="id">ID</label>
                              <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="">
                              <small id="helpId" class="form-text text-muted">Help text</small>
                            </div>

                            <div class="form-group">
                              <label for="title">Titulo</label>
                              <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="Escribe el titulo del evento">
                              
                            </div>

                            <div class="form-group">
                              <label for="description">Descripción</label>
                              <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>

                            <div class="form-group d-none">
                              <label for="start">Start</label>
                              <input type="date" class="form-control" name="start" id="start" aria-describedby="helpId" placeholder="">
                              <small id="helpId" class="form-text text-muted">Help text</small>
                            </div>


                            <div class="form-group">
                              <label for="end">End</label>
                              <input type="date" class="form-control" name="end" id="end" aria-describedby="helpId" placeholder="">
                              
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                        <button type="button" class="btn btn-warning" id="btnModificar">Modificar</button>
                        <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection