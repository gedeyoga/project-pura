<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageQueueListRequest;
use App\Http\Resources\MessageLogResource;
use App\Models\MessageLog;
use Illuminate\Http\Request;

class MessageLogController extends Controller
{
    public function index(MessageQueueListRequest $request)
    {
        $start = $request->get('start' , 0) - 1 < 0 ? 0 : $request->get('start' , 0) - 1;
        $jumlah = $request->get('take', 10) < 0 ? 10 : $request->get('jumlah', 10);
        $order_by = $request->get('order' , 'asc');


        $message_logs = MessageLog::offset($start)->take($jumlah)->orderBy('id' , $order_by)->get();
        return MessageLogResource::collection($message_logs);
    }
}
