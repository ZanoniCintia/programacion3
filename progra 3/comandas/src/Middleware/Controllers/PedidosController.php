<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Comanda;
use App\Models\Empleado;
use App\Models\Usuario;
use App\Models\DetalleCom;
use App\Models\Encuesta;
use App\Models\Pendiente;
use App\Models\Producto;

use DateTime;
//date_default_timezone_set('America/Argentina/Buenos_Aires');
use stdClass;

class PedidoController {


    public function addOneComanda(Request $request, Response $response, $args)//uso
    {   
        $comanda = new Comanda;
      
        $idComanda= Comanda::max('idcomanda');
        $hora=date('H:m:s');
        $letra="PED";
        $total= 0;
        
        $comanda->idComanda=$idComanda + 1 ;
        $comanda->codigoMesa = $letra.($idComanda + 1);
        $comanda->cliente = $request->getParsedBody()['cliente'];
        $comanda->hora = $hora;
        $comanda->codigo=$request->getParsedBody()['mozo'];;
        $comanda->estado = "pendiente";
        $comanda->tiempo = 0;
        $comanda->importe=0;
        

        echo "Se dio de alta la comanda : ".$comanda->idComanda;
        $rta=$comanda->save();
        $response->getBody()->write(json_encode($rta));
    
        return $response;
        
    }

    public function addDetalleComanda(Request $request, Response $response, $args){

        
        $idComanda=$request->getParsedBody()['idComanda'];
        $ExisteComanda= Comanda::select(['Comanda.*'])->where('idComanda','=',$idComanda)->count();//->get();
        $Error = 0;
        if($ExisteComanda>0)
        {
                $ProdID=$request->getParsedBody()['ProdID'];
                $ExisteProducto= Producto::select(['Producto.*'])->where('ProdID','=',$ProdID)->count();//->get();
                if($ExisteProducto>0)
                {
                    if($request->getParsedBody()['cantidad']>0){ 
                        $detalleCom = new DetalleCom();
                        $pendientes = new Pendiente();
                        $secuencia= DetalleCom::max('secuencia');
                        $detalleCom->idComanda=$idComanda;
                        $detalleCom->secuencia=$secuencia + 1 ;
                        $detalleCom->ProdID=$ProdID;
                        $detalleCom->cantidad=$request->getParsedBody()['cantidad'];
                        $detalleCom->tiempoEstimado=$request->getParsedBody()['tiempo'];
                        $pendientes->idComanda=$idComanda;
                        $pendientes->Secuencia=$secuencia + 1 ;
                        $pendientes->ProdID= $ProdID;
                        $pendientes->codigo= $request->getParsedBody()['codigo_empleado'];
                        $pendientes->estado="pendiente";

                        $pendientes->save();
                        $detalleCom->save();

                        $importe = DetalleCom::join('productos','productos.ProdID','=','detallecomanda.ProdID')->where('idComanda','=',$idComanda)->sum('ProdPrecio');
                        $tiempo = DetalleCom::join('productos','productos.ProdID','=','detallecomanda.ProdID')->where('idComanda','=',$idComanda)->sum('tiempoEstimado');
                        
 
                        
                        $comanda = Comanda::find($idComanda);
                        $comanda->tiempo = $tiempo;
                        $comanda->importe = $importe * $detalleCom->cantidad;
                        $comanda->save();


                        echo 'importe:'.$importe. "  ";
                        echo "pedido cargado";
                    }else{
                        echo "debe ingresar una cantidad";
                        $Error = 1;
                    }
                }else{
                    echo "Producto Inexistente";
                    $Error=1;
                }
        }else{
            echo "Comanda inexistente";
            $Error=1;
        }
        $response->getBody()->write(json_encode($Error));
    
        return $response;
    }

   

 

    public function updateEstadoPedido(Request $request, Response $response, $args)
    {
        $user = Comanda::find($args['idComanda']);

        $user->estado = $request->getParsedBody()['estado'];

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function updateProductoPedido(Request $request, Response $response, $args)
    {
        $user = Comanda::find($args['ProdID']);

        $user->estado = $request->getParsedBody()['producto'];

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function deleteOnePedido(Request $request, Response $response, $args)
    {
        $user = DetalleCom::find($args['ProdID']);

        $rta = $user->delete();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getPendientes(Request $request, Response $response, $args)
    {
        $codigo=$args['codigo'];
        
        $pendiente= Pendiente::select('idComanda','ProdID')->where('codigo','=',$codigo)->get();
         
        $producto=Producto::select('ProdDes')->where('ProdID','=',$pendiente[0]->ProdID)->get(); 
        $response->getBody()->write(json_encode($pendiente).json_encode($producto));
        return $response;
    }


    public function cierreDeMesa(Request $request, Response $response, $args)
    {
        $user = Comanda::find($args['idComanda']);
        

        $user->cierreMesa = $request->getParsedBody()['estado'];

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getAllComandas(Request $request, Response $response, $args)
    {
        $rta = Comanda::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function appCliente(Request $request, Response $response, $args)
    {
        $codigo=$args['codigoMesa'];
        $pedido= Comanda::select('cliente','estado')->where('codigoMesa','=',$codigo)->get();
        $response->getBody()->write(json_encode($pedido));
        return $response;
    }

}