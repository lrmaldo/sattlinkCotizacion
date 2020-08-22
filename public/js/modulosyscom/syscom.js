

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
    var cambio ;
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
           
            var html="";
         
            for(var i=0;i<data.productos.length;i++){
               html= "<tr>";
               
                console.log('succes: ' + data.productos[i].titulo);
                var precio = parseFloat(data.productos[i].precios.precio_descuento);
                var conversion = cambio*precio;
                var precio_con_iva = conversion + (conversion*0.16);
                var text = "$"+ precio_con_iva.toFixed(2)+"MXN"
                    html=html.concat("<td> <img src='"+data.productos[i].img_portada+"' style='width: 200px' ></td>");
                    html=html.concat("<td>"+data.productos[i].titulo+"</td>");
                    html=html.concat("<td>"+data.productos[i].marca+"</td>");
                    html=html.concat("<td>"+data.productos[i].modelo+"</td>");
                    html=html.concat("<td>"+data.productos[i].total_existencia+"</td>");
                    html=html.concat("<td>"+text+"</td>");
                    html=html.concat("<td>"+data.productos[i].total_existencia+"</td>");
                    html=html.concat("<td><a class='btn btn-info'  onclick='add()' >  <i class='fa fa-plus' aria-hidden='true'></i></a></td>");
                 
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