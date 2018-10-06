<?php

namespace App\Repositories;

use App\Board;

use Illuminate\Support\Facades\Storage;

class BoardRepository
{
    public function create($data)
    {
        $board = new Board();

        $board->project_id = $data['project_id'];
        $board->name =  $data['name'];
        $board->created_by_user_id =  $data['created_by_user_id'];

        $boardImageDirectory = config('images.boards_images_dir');

        $uploadedImage =  $data['thumb_image'];

        if($uploadedImage)
        {

            $newImageName = uniqid("",false) . '.jpg';

            $board->thumb_image = $newImageName;

            Storage::put($boardImageDirectory.'/' . $board->thumb_image, file_get_contents($uploadedImage));
        }

        $board->save();

        return $board;
    }

    public function delete(Board $board)
    {

        $boardImageDirectory = config('images.boards_images_dir');

        if( $board )
        {
            Storage::delete( $boardImageDirectory.'/'.$board->thumb_image );

            if( $board->delete() )
            {
                //event(new \App\Events\BoardDeleted($board->id));
                //$response['status'] = true;
                return true;
            }

        }
    }

    public function update()
    {
        //... TODO
    }
}