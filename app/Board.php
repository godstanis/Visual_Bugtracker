<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Board extends Model
{
    protected $fillable = ['name', 'project_id', 'thumb_image', 'created_by_user_id'];

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by_user_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function paths()
    {
        return $this->hasMany(Path::class, 'board_id', 'id');
    }

    /**
     * Return messages, left on the board.
     *
     * TODO: #1 Issue, program the board message logic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(BoardMessage::class, 'board_id', 'id');
    }

    /**
     * Returns actual board image (for the editor).
     *
     * @return string Board main image for editor
     */
    public function sourceImageUrl(): string
    {
        $imagePath = config('images.boards_images_dir') . '/' . $this->thumb_image;
        return Storage::disk('s3')->url($imagePath);
    }

}
