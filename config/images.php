<?php

return [
    'thumbnail_prefix' => 'thumbnail_',

    'user_avatar_dir'       => env('S3_USER_AVATARS_DIR'),
    'default_user_avatar'   => env('S3_DEFAULT_AVATAR_NAME'),

    'project_thumb_dir'     => env('S3_PROJECTS_DIR'),
    'default_project_thumb' => env('S3_PROJECT_IMAGE_DEFAULT'),

    'boards_images_dir'     => env('S3_BOARDS_DIR'),
];