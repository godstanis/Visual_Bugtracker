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

        define('BOARDS_THUMB_DIR', config('images.boards_images_dir'));

        $uploadedImage =  $data['thumb_image'];
        if($uploadedImage)
        {

            $newImageName = uniqid() . '.jpg';

            $board->thumb_image = $newImageName;

            Storage::disk('s3')->put(BOARDS_THUMB_DIR.'/' . $board->thumb_image, file_get_contents($uploadedImage));
        }

        $board->save();

        return $board;
    }

    public function delete(Board $board)
    {

        define('BOARDS_THUMB_DIR', config('images.boards_images_dir'));

        if( $board )
        {
            Storage::disk('s3')->delete( BOARDS_THUMB_DIR.'/'.$board->thumb_image );

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