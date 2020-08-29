

/* variables globales */

var datos_busqueda;///aqui se almacenara el json de los datos de la busqueda 
var cambio ;//cambio del dolar a pesos de syscom

function pulsar(e){
    if(e.keyCode === 13 && !e.shiftkey){
        e.preventDefault();
        
        busqueda()

    }
}



//funcion de busqueda 
function busqueda(){
  
    var secret = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRkZjU4M2U4YTA2NjgwMWNjNjFlZWYzZTBjZDRhM2IwNDljYWFmZjE3YzA0NGRmZWUxYWI0Njk1Mjk1MGUxMjRhNjZiMTVhNTI4YmMyZTNkIn0.eyJhdWQiOiJMYTJvUWNvMXhXWk5jTGoyeGRUZThoUVpHQWFiNkVtaCIsImp0aSI6IjRkZjU4M2U4YTA2NjgwMWNjNjFlZWYzZTBjZDRhM2IwNDljYWFmZjE3YzA0NGRmZWUxYWI0Njk1Mjk1MGUxMjRhNjZiMTVhNTI4YmMyZTNkIiwiaWF0IjoxNTk1OTcyMDY0LCJuYmYiOjE1OTU5NzIwNjQsImV4cCI6MTYyNzUwODA2NCwic3ViIjoiIiwic2NvcGVzIjpbXX0.bnN9ddV2OnhTX7ayP3nU8he3nKjoaIYn2vysbuS4tocPZU7YesRMjRulctCUsVMwuKDx27Qg1H4GOg9pi60u5vLEaQZTycrOTnNQT3MXEVRnLetoW2VWSGYjYcloZONZXLfEvXUETbCJk8egeXkApnTIe1rMheDPVG1P_LjhDVHrFZ-a6segyXCbseXLKUdiyE1gjq0-AQVydvpoeSURGaAueUTwcZ1BIx7svc9H2WUnPFk5E0Nr-nKVwLmSazosJxLPK3Mf5H_nL8dXyE3adzaobjjHW8_Dxmg04h7YpDl1YThiUfYs9qHwCyDeSvCKCNoTb-xjUSkzZDzY16UYJ1_g2XroGE-Pz9XZguhbw3vTN6r1jlUtweX14Meis8AEW3eM9BXzsyBN6-XvN20wao-ZjWW7XCQyRSHqcqOrw0UDDFw5oSl-BIr5uGojGDrO0koBaLZa-2PI0B0nf0v13SvfwTVY-XknSPABLqtk1ZTQJ40P5KKapldqXLhkdAFHM3Kw2E-ua4ZNYa2z-TV9GyXdDIi0roCTv79kNgspeNv7jceJDf5fO6wGHMkv7uDzio_1ftd-TSGAIENhxt3frK3tz2l8CPbZ9WiBjZSQPzhkTK6gVTkMxYh0tUuw-1gVgvYlZv-Fka2Gxv9FMV9I3ZlgIYJvmfSg7uBr7jRyDJE"
    var httpHeader = { 'Authorization': secret,
    'Accept': 'application/json',
   'Content-Type': 'application/json' }
    var misCabeceras = new Headers(httpHeader);
    var miInit = {
        method: 'GET',
        headers: misCabeceras,


    };

    //tipo de cambio
    function json(response) {
     return response.json()
    }
  
    fetch('https://developers.syscom.mx/api/v1/tipocambio', miInit)
        .then(status)
        .then(json)
        .then(function (response) {

           
            console.log(response.normal);
             cambio = parseFloat(response.normal);
             //console.log(parse)
        })
        

        var body = document.getElementsByTagName("body")[0];
        var busque = document.getElementById('buscador').value;
// Crea un elemento <table> y un elemento <tbody>
 //crear el elemento de la tabla 
/* eliminar la tabla de una busqueda anterior */
/* var old_tbody =  document.getElementById("outer_div");
var new_tbody = document.createElement('tbody');
//populate_with_new_rows(new_tbody);
old_tbody.parentNode.replaceChild(new_tbody, old_tbody)

 */
$("#outer_div").empty();
 $.ajax({
        url: 'https://developers.syscom.mx/api/v1/productos?busqueda='+busque,
        headers: httpHeader ,
        method: 'GET',
        dataType: 'json',
        beforeSend: function(objeto){
           // $('#loader').show();
           var url_loader = 'img/ajax-loader.gif'
           $('#cargador').show();
           
           /* "
                 <div   style='text-align: center;	top: 55px;	width: 100%; display:none'>
              <img    src='{{asset('img/ajax-loader.gif')}}' width='50px' alt=''>
              </div>" */
          console.log("cargando")
            //document.getElementById("loader").style.display = "block";
		  },
       
        success: function (data) {
           datos_busqueda = data;
           var html="";
         
            for(var i=0;i<data.productos.length;i++){
               html= "<tr>";
               
                console.log('succes: ' + data.productos[i].precios);
                var precio = parseFloat(data.productos[i].precios.precio_descuento);
                var text;
                
                var conversion = cambio*precio;
                var precio_con_iva = conversion + (conversion*0.16);
                if( Object.keys(data.productos[i].precios).length === 0 ){
                    text="Sin precio"
                }else{

                     text = "$"+ precio_con_iva.toFixed(2)+"MXN"
                     console.log(precio_con_iva.toFixed(2))
                }
                    html=html.concat("<td> <img src='"+data.productos[i].img_portada+"' style='width: 200px' ></td>");
                    html=html.concat("<td>"+data.productos[i].titulo+"</td>");
                    html=html.concat("<td>"+data.productos[i].marca+"</td>");
                    html=html.concat("<td>"+data.productos[i].modelo+"</td>");
                    html=html.concat("<td>"+data.productos[i].total_existencia+"</td>");
                    html=html.concat("<td>"+text+"</td>");
                    html=html.concat(" <td class='cantidad'> <input style='width: 100%' class='form-control' id='unidadS-"+data.productos[i].producto_id+"' type='text'  value='PZA'></td>");
                    html=html.concat(" <td class='cantidad'> <input style='width: 70%' class='form-control' id='cantidadS-"+data.productos[i].producto_id+"' type='text' value='1'></td>");
                    html=html.concat('<td><a class="btn btn-info"  onclick="add_syscom(\''+data.productos[i].producto_id+'\');" >  <i class="fa fa-plus" aria-hidden="true"></i></a></td>');
                 
                    html=html.concat("</tr>");
                    
                       

             
                        console.log(html)
                        $("#outer_div").append(html);
                //document.getElementById('resultados').innerHTML = data.productos[i].titulo;
            }
            //document.getElementById("outer_div").innerHTML = html;
            
        },
        complete:function(data){
            console.log("fin de la carga")
            $('#cargador').hide();
        }
       
    });
    
      }

    function  add_syscom(id_producto){
       var producto ;
       var token = '{{ csrf_token() }}';
       var cantidad = document.getElementById("cantidadS-"+id_producto).value; /* obtienen el valor del input de la tabla de productos de syscom */
       var unidad = document.getElementById('unidadS-'+id_producto).value;
       producto = datos_busqueda.productos.find(elemento => elemento.producto_id === id_producto) //busca el producto en el array de busqueda
       
       console.log(producto)
       console.log(producto.precios.precio_descuento)
       /* ****************** validacion de campos  */
         if(isNaN(cantidad)){
            alert("Esto no es un número");
            document.getElementById("cantidadS-"+id_producto).focus();
            return false;
        } 
        if(cantidad===""){
            alert("no hay un valor númerico")
            document.getElementById("cantidadS-"+id_producto).focus();
            return false;
        }
        if(isNaN(producto.precios.precio_descuento)){
            alert("No puedes agregar este producto porque no tiene precio");
           // document.getElementById("cantidadS-"+id_producto).focus();
            return false;
        }
        if(unidad===""){
            alert("no tiene un valor la unidad de medida")
            document.getElementById("unidadS-"+id_producto).focus();
            return false;
        }

        //convertir precio en  pesos mexicanos y ponerle el precio con iva

        var precio = parseFloat(producto.precios.precio_descuento);
        
        var conversion = cambio*precio;
        
        var precio_con_iva = conversion + (conversion*0.16);
        //fin de la conversion 



        //crear el post de add al controlador add
        var data = {
            id_producto_syscom: id_producto,
            cantidad: cantidad,
            _token: $('meta[name="_token"]').attr('content'),
            titulo_syscom: producto.titulo+" - "+producto.modelo,
            precio_syscom: precio,
            unidad_syscom:unidad
        };
        $.ajax({

            type: 'post',
            url: '/cotizador/add_syscom',
            data: data,
            success: function(datos) {
                document.getElementById('resultado').innerHTML = datos;
                producto= null;
                //$('#resultado').html(datos);
                select();
            }
        })

    }



  function  cargar_datos(){

    /* var token = '{{ csrf_token() }}'; // ó $("#token").val() si lo tienes en una etiqueta html.
    //var id_producto;
    var cantidad = $("#cantidad_producto").val();
   
    var quitarp = document.getElementById('descuentoCliente').innerHTML;
    var descuentoC = quitarp.replace('%', ''); //le quita el simbolo porcentaje
   
   
    var data = {
        _token: token,
        descuento_cliente: descuentoC
    }; */
    $.ajax({

        type: 'post',
        url: '/cotizador/cargardatos',
        data: data,
        success: function(datos) {
            document.getElementById('resultado').innerHTML = datos;
            //$('#resultado').html(datos);
        }
    })

    }




