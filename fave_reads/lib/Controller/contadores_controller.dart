import 'dart:async';
import 'package:aqueduct/aqueduct.dart';
import 'package:fave_reads/Models/contadores.dart';

class ContadoresController extends ResourceController{

  @Operation.get()
  Future<Response> obtenerElementos(@Bind.query('opcion') int opcion, @Bind.query('id') int id) async
  {
    final servicio = Contadores();
    return Response.ok(await servicio.numeroElementos(opcion,id));
  }
}