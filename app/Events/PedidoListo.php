<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PedidoListo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $id_pedido;
    public $id_det_ped;
    public $id_sucursal;

    public function __construct($id_pedido, $id_det_ped, $id_sucursal)
    {
        //
        $this->id_pedido = $id_pedido;
        $this->id_det_ped = $id_det_ped;
        $this->id_sucursal = $id_sucursal;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['pedido-listo'.$this->id_sucursal];
    }
}
