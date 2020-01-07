import 'dart:async';
import 'package:aqueduct/aqueduct.dart';
import 'package:fave_reads/Models/institucionRuta.dart';

class InstitucionRutaController extends ResourceController{



  @Operation.get()
  Future<Response> obtenerLista(@Bind.query('campo') String campo,@Bind.query('bus') String bus,@Bind.query('est') String est ) async
  {
    final servicio = InstitucionRuta();
    return Response.ok(await servicio.obtenerDatos(campo,bus,est));
  }

  // @Operation.get('id')
  // Future<Response> obtenerListaId(@Bind.path('id') String id) async
  // {
  //   final servicio = InstitucionRuta();
  //   return Response.ok(await servicio.obtenerDatoId(id));
  // }

  @Operation.post()
  Future<Response> crearInstitucionRuta(@Bind.body() InstitucionRuta body )async
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