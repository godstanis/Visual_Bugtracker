<?php

namespace App\Repositories;

use App\BoardMessage;

class BoardMessageRepository
{
    public function create($data)
    {
        BoardMessage::create($data);
    }

    public function delete(BoardMessage $message)
    {
        $message->delete();
    }
}