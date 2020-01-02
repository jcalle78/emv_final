import 'dart:async';
import 'package:fave_reads/Models/conexion.dart';
import 'package:fave_reads/fave_reads.dart';


class EstudianteRepresentante extends Serializable
{
  
  int estId;
  int repId;

  Future<void> ingresar(EstudianteRepresentante dato) async{
    final conexion = Conexion();
    final String sql = "INSERT INTO public.te_estudiante_representante(est_id, rep_id)"
    " VALUES (${dato.estId},${dato.repId})";
    await conexion.operaciones(sql);
  }

   Future<void> modificar(int id) async{
    final conexion = Conexion();
    final String sql = "UPDATE public.te_estudiante SET est_estado=1 WHERE est_cedula=$id";
    await conexion.operaciones(sql);
  }

   Future<void> eliminar(int id) async{
    final conexion = Conexion();
    final String sql = "UPDATE public.te_estudiante SET est_estado=0 WHERE ins_id=$id";
    print(sql);
    await conexion.operaciones(sql);
  }

  @override
  Map<String, dynamic> asMap() => {
    'repId': repId,
    'estId': estId 
  };

  @override
  void readFromMap(Map<String, dynamic> object) {
    
    repId=int.parse( object['repId'].toString());
   
    estId=int.parse(object['estId'].toString());
  }


}