<?php

namespace App\Events;

use App\Models\BaiDang;
use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Session\Store;

class ViewPostHandler
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public function __construct(BaiDang $post)
    {
        $this->post = $post;
    }

    public function handle()
	{
       return $this->post;
	}
}
