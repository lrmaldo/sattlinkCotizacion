<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModalProductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
    <!-- Then put toasts within -->
    <div class="toast" role="alert"  aria-live="assertive" style="align-content: flex-end" aria-atomic="true">
      <div class="toast-header">
      <img src="{{asset('img/logo.png')}}" width="100px" class="rounded mr-2" alt="...">
        <strong class="mr-auto"></strong>
        <small></small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        Producto Agregado correctamente
      </div>
    </div>
      
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          
          <div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
          <div class="outer_div" ></div><!-- Datos ajax Final -->
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                       
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Unidad</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        
                        <th>Acciones</th>

                    </tr>
                </thead>
              
                <tbody>
                    @foreach ($productos as $item)
                            <tr>

                                
                                <td class="nombre">{{ $item->nombre }}</td>
                                <td class="codigo">{{ $item->codigo }}</td>
                                <td class="unidad">{{ $item->unidad }}</td>
                                <td class="precio">${{ number_format($item->precio) }}</td>
                                <td class="cantidad"> <input style="width: 70%" class="form-control" id="cantidad-{{$item->id}}" type="text" value="1"></td>
                            <td><a class="btn btn-info" {{-- href="#" --}} onclick="add('{{$item->id}}')" >  <i class="fa fa-plus"
                                    aria-hidden="true"></i></a>  </td>
                            </tr>
                      @endforeach      
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          
        </div>
      </div>
    </div>
  </div>
</div>