import 'package:fave_reads/Models/conexion.dart';
import 'package:fave_reads/fave_reads.dart';


class InstitucionRuta extends Serializable
{
  
  int insId=0;
  int rutaId=0;
  String insNombre="";
  String rutaNombre="";
  int rutaCupo=0;  
  int estado=0;
  
 
   Future<List> obtenerDatos(String campo,String bus, String est) async {
      final conexion = Conexion();
      // final String sql = "select * from public.te_institucion where $campo::text LIKE '%$bus%' and ins_estado::text LIKE '%$est%' order by ins_id DESC";

      final String sql = "SELECT ir.ins_id, ir.rut_id, i.ins_nombre, r.rut_nombre, r.rut_cupo_maximo, ir.ier_estado" 
                          " FROM public.te_institucion_educativa_ruta ir, public.te_ruta r, public.te_institucion i" 
                          " where ir.ins_id = i.ins_id and ir.rut_id= r.rut_id and $campo::text LIKE '%$bus%' and ier_estado::text LIKE '%$est%'";
       
      final List datos=[];
      final List<dynamic> query = await conexion.obtenerTabla(sql);

      if(query != null && query.isNotEmpty)
      {
        for(int i=0; i<query.length;i++)
        {
          final reg = InstitucionRuta();        
          reg.insId=int.parse(query[i][0].toString());    
          reg.rutaId=int.parse(query[i][1].toString());         
          reg.insNombre=query[i][2].toString();
          reg.rutaNombre=query[i][3].toString();
          reg.rutaCupo=int.parse(query[i][4].toString());
          reg.estado=int.parse(query[i][5].toString());
          
          datos.add(reg.asMap()); 
        }
        return datos;
      }
      else{
        return null;
      }    
  }

 
  Future<void> ingresar(InstitucionRuta dato) async{
    final conexion = Conexion();   
    final String sql = "INSERT INTO public.te_institucion_educativa_ruta(ins_id, rut_id, ier_estado) VALUES ('${dato.insId}','${dato.rutaId}',${dato.estado})";
    print(sql);
    await conexion.operaciones(sql);
  }

  //  Future<void> modificar(int id,Institucion dato) async{
  //   final conexion = Conexion();
  //   final String sql = 
  //   "UPDATE public.te_institucion SET ins_nombre='${dato.nombre}', ins_ruc='${dato.ruc}', ins_direccion='${dato.direccion}', ins_telefono='${dato.telefono}', ins_correo='${dato.correo.replaceAll('@','*')}', ins_estado='${dato.estado}', tin_id=${dato.tipoInstitucionId} "
	//   "WHERE ins_id=$id";
  //   await conexion.operaciones(sql);
  // }

  @override
  Map<String, dynamic> asMap() => {
    'insId': insId,
    'rutaId': rutaId,  
    'insNombre': insNombre,
    'rutaNombre': rutaNombre,
    'rutaCupo':rutaCupo,
    'estado': estado,
   
  };

  @override
  void readFromMap(Map<String, dynamic> object) {
    insId= int.parse(object['insId'].toString());
    rutaId= int.parse(object['rutaId'].toString());  
    insNombre=object['insNombre'].toString();
    rutaNombre=object['rutaNombre'].toString();
    rutaCupo=int.parse(object['rutaCupo'].toString());
    estado=int.parse(object['estado'].toString());
  }
}