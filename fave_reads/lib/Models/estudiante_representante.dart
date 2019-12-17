import 'dart:async';
import 'package:fave_reads/Models/conexion.dart';
import 'package:fave_reads/fave_reads.dart';


class EstudianteRepresentante extends Serializable
{
  
  int estId;
  int repId;
 
  
 
  

  

  Future<void> ingresar(EstudianteRepresentante dato) async{
    print("holi2");
    final conexion = Conexion();
    final String sql = "INSERT INTO public.te_estudiante_representante(est_id, rep_id)"
    " VALUES (${dato.estId},${dato.repId})";
    print(sql);
    await conexion.operaciones(sql);
  }

   Future<void> modificar(int id,EstudianteRepresentante dato) async{
    final conexion = Conexion();
    
    final String sql = 
    //"UPDATE public.te_EstudianteRepresentante SET fun_cedula='${dato.cedula}', fun_nombre='${dato.nombre}', fun_apellido='${dato.apellido}', fun_direccion='${dato.direccion}', fun_telefono='${dato.telefono}', fun_celular='${dato.celular}', fun_correo='${dato.correo.replaceAll('@','*')}',fun_estado='${dato.estado}', ins_id=${dato.institutoId}"
	  "WHERE fun_id=$id";
    print(sql);
    await conexion.operaciones(sql);
  }

   Future<void> eliminar(int id) async{
    final conexion = Conexion();
    final String sql = "UPDATE public.te_EstudianteRepresentante SET fun_estado=1* WHERE fun_id=$id";
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