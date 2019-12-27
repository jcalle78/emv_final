import 'package:fave_reads/Models/conexion.dart';
import 'package:fave_reads/fave_reads.dart';


class InstitucionRuta extends Serializable
{
  
  int ins;
  int ruta;
  int estado;
 
   Future<List> obtenerDatos(String est) async {
    final conexion = Conexion();
    // final String sql = "select * from public.te_institucion where $campo::text LIKE '%$bus%' and ins_estado::text LIKE '%$est%' order by ins_id DESC";
    const String sql = "select * from public.te_institucion_educativa_ruta ";
    print(sql);   
   final List datos=[];
    final List<dynamic> query = await conexion.obtenerTabla(sql);



    if(query != null && query.isNotEmpty)
    {
      for(int i=0; i<query.length;i++)
      {
        final reg = InstitucionRuta();        
        reg.ins=int.parse(query[i][0].toString());    
        reg.ruta=int.parse(query[i][1].toString());       
        reg.estado=int.parse(query[i][2].toString());
        
        datos.add(reg.asMap()); 
      }
      return datos;
    }
    else{
      return null;
    }    
  }

  // Future<Institucion> obtenerDatoId(int id) async {
  //   final conexion = Conexion();
  //   final String sql = "select * from public.te_institucion where ins_id=$id";

  //   final List<dynamic> query = await conexion.obtenerTabla(sql);
  //   if(query != null && query.isNotEmpty)
  //   { 
  //       final reg = Institucion();
  //       reg.id=int.parse(query[0][0].toString());
  //       reg.nombre=query[0][1].toString();
  //       reg.ruc=query[0][2].toString();
  //       reg.direccion=query[0][3].toString();
  //       reg.telefono=query[0][4].toString();
  //       reg.correo=query[0][5].toString().replaceAll('*','@');
  //       reg.estado=int.parse(query[0][6].toString());
  //       reg.tipoInstitucionId=int.parse(query[0][7].toString());
  //       return reg;
  //   }
  //   else
  //   {
  //     return null;
  //   }
    
  // }

  // Future<void> ingresar(Institucion dato) async{
  //   final conexion = Conexion();
  //   final String sql = "INSERT INTO public.te_institucion(ins_nombre, ins_ruc, ins_direccion, ins_telefono, ins_correo, ins_estado, tin_id)"
  //  " VALUES ('${dato.nombre}', '${dato.ruc}','${dato.direccion}','${dato.telefono}','${dato.correo.replaceAll('@','*')}', ${dato.estado}, ${dato.tipoInstitucionId})";
  //   print(sql);
  //   await conexion.operaciones(sql);
  // }

  //  Future<void> modificar(int id,Institucion dato) async{
  //   final conexion = Conexion();
  //   final String sql = 
  //   "UPDATE public.te_institucion SET ins_nombre='${dato.nombre}', ins_ruc='${dato.ruc}', ins_direccion='${dato.direccion}', ins_telefono='${dato.telefono}', ins_correo='${dato.correo.replaceAll('@','*')}', ins_estado='${dato.estado}', tin_id=${dato.tipoInstitucionId} "
	//   "WHERE ins_id=$id";
  //   await conexion.operaciones(sql);
  // }

  //  Future<void> eliminar(int id) async{
  //   final conexion = Conexion();
  //   final String sql = "UPDATE public.te_institucion SET ins_estado=1 WHERE tin_id=$id";
  //   await conexion.operaciones(sql.toString());
  // }

  @override
  Map<String, dynamic> asMap() => {
    'ins': ins,
    'ruta': ruta,
    'estado': estado,
   
  };

  @override
  void readFromMap(Map<String, dynamic> object) {
    ins= int.parse(object['ins'].toString());
    ruta= int.parse(object['ruta'].toString());
    estado=int.parse(object['estado'].toString());
    
  }


}