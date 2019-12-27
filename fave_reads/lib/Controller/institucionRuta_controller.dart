import 'dart:async';
import 'package:aqueduct/aqueduct.dart';
import 'package:fave_reads/Models/institucionRuta.dart';

class InstitucionRutaController extends ResourceController{



  @Operation.get()
  Future<Response> obtenerLista(@Bind.query('est') String est ) async
  {
    final servicio = InstitucionRuta();
    return Response.ok(await servicio.obtenerDatos(est));
  }
  // @Operation.get('id')
  // Future<Response> obtenerListaId(@Bind.path('id') int id) async
  // {
  //   final servicio = Institucion();
  //   return Response.ok(await servicio.obtenerDatoId(id));
  // }

  @Operation.post()
  Future<Response> crearInstitucion(@Bind.body() InstitucionRuta body )async
  {
     final servicio = InstitucionRuta();
     await servicio.ingresar(body);
    return Response.ok('se ha ingresado');
  }

  // @Operation.put('id')
  // Future<Response> modificarInstitucion(@Bind.path('id') int id,@Bind.body() Institucion body) async
  // {
  //   final servicio = Institucion();
  //   await servicio.modificar(id, body);
  //   return Response.ok('se ha modificado');
  // }
}