import 'dart:async';
import 'package:fave_reads/Models/conexion.dart';
import 'package:fave_reads/fave_reads.dart';


class UsuarioRol extends Serializable
{
  
  int usuId;
  int rolId;
  String nombreRol;

   Future<List> obtenerDatos(String campo) async {
    
    final conexion = Conexion();
    String sql; 
      sql = "Select rol_nombre,rol_id From te_rol Where rol_id NOT IN(select rol_id from te_usuario_rol Where usu_id=$campo)";
    final List datos=[];
    final List<dynamic> query = await conexion.obtenerTabla(sql);
    if(query != null && query.isNotEmpty)
    {
      for(int i=0; i<query.length;i++)
      {
        final reg = UsuarioRol();
        
        reg.nombreRol=query[i][0].toString();
        reg.rolId= int.parse(query[i][1].toString());

        datos.add(reg.asMap()); 
      }
      return datos;
    }
    else
    {
      return null;
    }
    
  } 

  Future<void> ingresar(UsuarioRol dato) async{
    final conexion = Conexion();
    final String sql = "INSERT INTO public.te_usuario_rol(usu_id, rol_id)"
    " VALUES (${dato.usuId},${dato.rolId})";
    await conexion.operaciones(sql);
  }

   Future<void> modificar(int id,UsuarioRol dato) async{
    final conexion = Conexion();
    
    final String sql = 
    //"UPDATE public.te_UsuarioRol SET fun_cedula='${dato.cedula}', fun_nombre='${dato.nombre}', fun_apellido='${dato.apellido}', fun_direccion='${dato.direccion}', fun_telefono='${dato.telefono}', fun_celular='${dato.celular}', fun_correo='${dato.correo.replaceAll('@','*')}',fun_estado='${dato.estado}', ins_id=${dato.institutoId}"
	  "WHERE fun_id=$id";
    print(sql);
    await conexion.operaciones(sql);
  }

   Future<void> eliminar(int id) async{
    final conexion = Conexion();
    final String sql = "UPDATE public.te_UsuarioRol SET fun_estado=1* WHERE fun_id=$id";
    await conexion.operaciones(sql);
  }

  @override
  Map<String, dynamic> asMap() => {
    'usuId': usuId,
    'nombreRol':nombreRol,
    'rolId': rolId 
  };

  @override
  void readFromMap(Map<String, dynamic> object) {
    
    usuId=int.parse( object['usuId'].toString());
   
    rolId=int.parse(object['rolId'].toString());
    nombreRol=object['nombreId'].toString();
  }


}