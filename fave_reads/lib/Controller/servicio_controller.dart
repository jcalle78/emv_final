import 'dart:async';
import 'package:aqueduct/aqueduct.dart';
import 'package:fave_reads/Models/Recorrido.dart';
import 'package:fave_reads/Models/servicio.dart';
import 'package:fave_reads/Models/tipo_vehiculo.dart';

class ServicioController extends ResourceController{



  @Operation.get()
  Future<Response> obtenerLista(@Bind.query('opcion') int opcion,@Bind.query('id') int id) async
  {
    switch(opcion)
    {
      case 1://Opcion para recuperar el tipo de vehiculo por funcionario esto para ver si se agregan las paradas o se agrega ubicacion
         final servicio = TipoVehiculo();
         return Response.ok(await servicio.obtenertTipoVehiculo(id));
        break;
      default://Opcion para obtener un listado de servicios
            final servicio = Servicio();
            return Response.ok(await servicio.obtenerDatos(id));
        break;

    }
  }


  @Operation.post()
  Future<Response> crearRecorrido(@Bind.body() Recorrido body )async
  {
     final servicio = Recorrido();
     await servicio.ingresar(body);
    return Response.ok('se ha ingresado');
  }

 
  
}