<div class="modal fade bs-example-modal-lg" id="myModalSyscom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" style="   max-width: 90% !important;" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Buscar productos en Syscom</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          
        
          <div class="input-group">
            <input type="text" class="form-control col-md-6" id="buscador" name="buscador" onkeypress="pulsar(event)" placeholder="Busca por modelo,marca">
            <div class="input-group-btn ">
              <button class="btn btn-default" type="submit" onclick="busqueda()">
                <i class=" fas fa-search"></i>
              </button>
            </div>
            
          </div>
        
          <br>

          <div class="outer_div" >
           
          </div><!-- Datos ajax Final -->
          
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                       
                        <th>Imagen</th>
                        <th>Titulo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Existencias</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Agregar</th>

                    </tr>
                </thead>
              
                <tbody id="outer_div" >
                 
                  

                  {{--   @foreach ($productos as $item)
                            <tr>

                                
                                <td class="nombre">{{ $item->nombre }}</td>
                                <td class="codigo">{{ $item->codigo }}</td>
                                <td class="unidad">{{ $item->unidad }}</td>
                                <td class="precio">${{ number_format($item->precio) }}</td>
                                <td class="cantidad"> <input style="width: 70%" class="form-control" id="cantidad-{{$item->id}}" type="text" value="1"></td>
                            <td><a class="btn btn-info" onclick="add('{{$item->id}}')" >  <i class="fa fa-plus"
                                    aria-hidden="true"></i></a>  </td>
                            </tr>
                      @endforeach      --}} 
                </tbody>
            </table>
            <!-- Carga gif animado -->  
              <div id="cargador" style="display: none">
                <div   style="text-align: center;	top: 55px;	width: 100%;">
                  <img    src="{{asset('img/ajax-loader.gif')}}" width="50px" alt="">
                  </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          
        </div>
      </div>
    </div>
  </div>
</div>