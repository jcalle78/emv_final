import 'dart:async';
import 'package:aqueduct/aqueduct.dart';
import 'package:fave_reads/Models/recorridoServicio.dart';

class RecorridoServicioController extends ResourceController{

  @Operation.post()
  Future<Response> crearrecorridoServicio(@Bind.body() RecorridoServicio body )async
  {
     final servicio = RecorridoServicio();
     await servicio.ingresar(body);
    return Response.ok('se ha ingresado');
  }
}