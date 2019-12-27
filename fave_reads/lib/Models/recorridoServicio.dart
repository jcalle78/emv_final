import 'dart:async';
import 'package:fave_reads/Models/conexion.dart';
import 'package:fave_reads/fave_reads.dart';


class RecorridoServicio extends Serializable
{
  
  int servicio;
  int recorrido;
  int parada;

 
  Future<void> ingresar(RecorridoServicio dato) async{
    final conexion = Conexion();
    final String sql = "INSERT INTO public.te_recorrido_servicio(rec_id, ser_id, par_id) VALUES (${dato.servicio}, ${dato.recorrido},${dato.parada})";
    await conexion.operaciones(sql);
  }


  @override
  Map<String, dynamic> asMap() => {
    'servicio': servicio,
    'recorrido':recorrido,
    'parada': parada 
  };

  @override
  void readFromMap(Map<String, dynamic> object) {
    
    servicio=int.parse( object['servicio'].toString());
    recorrido=int.parse(object['recorrido'].toString());
    parada=int.parse(object['parada'].toString());
  }


}