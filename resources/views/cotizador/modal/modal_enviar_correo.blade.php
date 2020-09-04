
    {{-- modal --}}
<div class="modal fade" id="ModalCorreo{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviar Correo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  role="form" method="post" action="{{ route('cotizador.email_pdf', $item->id) }}">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" id="email{{$item->id}}" name="email{{$item->id}}" value="{{$item->cliente->email}}">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Asunto:</label>
                        <input type="text" class="form-control" id="asunto{{$item->id}}" name="asunto{{$item->id}}">
                        </div>
                       
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Mensaje:</label>
                        <textarea id="comentario{{$item->id}}" rows="4" name="comentario{{$item->id}}"  class="form-control"> </textarea>
                    </div>
                    <small><i class="fa fa-paperclip" style="font-size:24px"></i> Archivo adjunto</small>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    