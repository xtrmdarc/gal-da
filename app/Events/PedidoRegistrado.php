<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PedidoRegistrado  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orden;
    public $area_prod;
    public $id_sucursal;
  

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($porden,$area_prod)
    {
        //
       
        $this->orden = (object)$porden;  
        $this->id_sucursal = $porden['pedido']['id_sucursal'];
        $this->area_prod = $area_prod;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
        
        return ['pedido-registrado'.$this->id_sucursal.$this->area_prod];
    }

    
}
