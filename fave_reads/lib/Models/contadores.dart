import 'dart:async';
import 'package:fave_reads/Models/recorrido.dart';
import 'package:fave_reads/Models/ruta.dart';
import 'package:fave_reads/Models/servicio.dart';
import 'package:fave_reads/fave_reads.dart';
import 'funcionario.dart';

class Contadores extends Serializable {
  int numero;

  Future<Contadores> numeroElementos(int codigo,int id) async {
    final reg = Contadores();
    switch (codigo) {
      case 1:
        final ruta = Ruta();
        reg.numero = await ruta.obtenerNumeroElementos();
        break;

      case 2:
        final recorrido = Recorrido();
        reg.numero = await recorrido.obtenerNumeroElementos();
        break;

      case 3:
        final funcionario = Funcionario();
        reg.numero = await funcionario.obtenerNumeroElementos();
        break;

      case 4:  //numero de servicios por funcionario
        final servicio = Servicio();
        reg.numero = await servicio.obtenerNumeroElementosPorFuncionario(id);
        break;

      default:
        break;
    }
    return reg;
  }

  @override
  Map<String, dynamic> asMap() => {'numero': numero};

  @override
  void readFromMap(Map<String, dynamic> object) {
    numero = int.parse(object['numero'].toString());
  }
}
