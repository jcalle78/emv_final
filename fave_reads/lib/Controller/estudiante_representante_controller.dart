import 'dart:async';
import 'package:aqueduct/aqueduct.dart';

import 'package:fave_reads/Models/estudiante_representante.dart';

class EstudianteRepresentanteController extends ResourceController{


 
  @Operation.post()
  Future<Response> crearEstudiante(@Bind.body() EstudianteRepresentante body )async
  {
     final servicio = EstudianteRepresentante();
     await servicio.ingresar(body);
    return Response.ok('se ha ingresado');
  }

  @Operation.put('id')
  Future<Response> modificarEstudiante(@Bind.path('id') int id) async
  {
    final servicio = EstudianteRepresentante();
    await servicio.modificar(id);
    return Response.ok('se ha modificado');
  }

  @Operation.delete('id')
  Future<Response> eliminarInstitucion(@Bind.path('id') int id) async
  {
    final servicio = EstudianteRepresentante();
    await servicio.eliminar(id);
    return Response.ok('se ha eliminado');
  }
  
  
}