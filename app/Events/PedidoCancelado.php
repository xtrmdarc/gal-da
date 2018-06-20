<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PedidoCancelado implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $id_det_ped;
    public $id_sucursal;
    public $id_areap;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pid_det_ped,$id_sucursal,$id_areap)
    {
        //
        
        $this->id_det_ped = $pid_det_ped;
        $this->id_sucursal = $id_sucursal;
        $this->id_areap = $id_areap;
    }

    /**
     * Get the channels the event should broadcast on.
     *  
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['pedido-cancelado'.$this->id_sucursal.$this->id_areap];
    }
}
