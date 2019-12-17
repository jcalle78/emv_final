import 'dart:async';
import 'package:aqueduct/aqueduct.dart';
import 'package:fave_reads/Models/usuario_rol.dart';

class UsuarioRolController extends ResourceController{



 @Operation.get()
  Future<Response> obtenerLista(@Bind.query('campo') String campo) async
  {
    final servicio = UsuarioRol();
    return Response.ok(await servicio.obtenerDatos(campo));
  }

  
  @Operation.post()
  Future<Response> crearFuncionario(@Bind.body() UsuarioRol body )async
  {
     final servicio = UsuarioRol();
     await servicio.ingresar(body);
    return Response.ok('se ha ingresado');
  }
}