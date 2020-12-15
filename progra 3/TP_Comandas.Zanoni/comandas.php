<?php
use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';

include_once './archivos.php';
//date_default_timezone_set ( "América / Argentina / Buenos_Aires" );
class Comanda
{

    public $cliente;
    public $tragos;
    public $cerveza;
    public $plato;
    public $mozo;
    


public function __construct($cliente,$mozo,$tragos="",$cerveza="",$plato="")
{
    $this->cliente=$cliente;
    $this->mozo=$mozo;
    $this->tragos=$tragos;
    $this->cerveza=$cerveza;
    $this->plato=$plato;
}


public static function cargarComanda($cliente,$mozo,$tragos,$cerveza,$plato,$codigoMesa)
{   
    $comanda=new comanda($cliente,$mozo,$tragos,$cerveza,$plato);
    
    $fecha=date( "d - m - Y");
    $hora=date("h:i:s A");
    if($comanda !=null)
    {
        $res=new stdClass();
        $res->fecha=$fecha;
        $res->hora=$hora;
        $res->pedido=$comanda;
        $res->codigoMesa=$codigoMesa;
        $res->estado_pedido="Pendiente";
        json_encode($res);
        File::guardarJSON("comandas.json",$res);
    }
    
}

public static function mostrarPedidoCliente($codigo)
{   
    $pedido = File::TraerJSON("comandas.json");
    
    if($pedido != null)
    {
        foreach ($pedido as $pedidoActual) 
        {
            if($pedidoActual->Mesa == $codigo)
            {
                return $pedidoActual;
           
            }
        }
    }
     
}

public static function prepararPedido()
{//el empleado q toma el pedido se carga automaticamente a "en preparacion" y se carga un timpo estimado de preparacion

}

public static function pedidoTerminado()
{
    //una vez terminado el pedido el estado es "listo para servir"
}


public static function EstadoPedidoEmpleados($codigoMesa,$estado)//terminar
{
    $pedido = File::TraerJSON("comandas.json");
    if($pedido != null)
    {
        foreach ($pedido as $estadoPedido) 
        {
            if($estado=="" || $estado=="")
            {
                Comanda::mostrarPedidoCliente($codigoMesa);
                $estadoPedido->estado_pedido= $estado;
                File::guardarJSON("comandas.json",$estadoPedido);
            }
        }
    }
}

public static function mostrarPedidosPendientes()
{
    $pendientes = File::TraerJSON("comandas.json");
    if($pendientes != null)
    {
        foreach ($pendientes as $estadoPedido) 
        {
            if($estadoPedido->estado_pedido == "Pendiente")
            {
                var_dump($estadoPedido) ;
                File::guardarJSON("pendientes.json",$estadoPedido);
            }else{

                echo "No hay pedidos pendientes";
            }
   
        }
    }
}




}





















?>