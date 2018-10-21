<?php

return [
    'thumbnail_prefix' => 'thumbnail_',

    'amazon_base_link'      => env('S3_BUCKET_LINK', 'https://s3.eu-central-1.amazonaws.com/bucket_name/'),

    'user_avatar_dir'       => env('S3_USER_AVATARS_DIR','user_profile_images'),
    'default_user_avatar'   => env('S3_DEFAULT_AVATAR_NAME','default.jpg'),

    'project_thumb_dir'     => env('S3_PROJECTS_DIR','projects_images'),
    'default_project_thumb' => env('S3_PROJECT_IMAGE_DEFAULT','default.jpg'),

    'boards_images_dir'     => env('S3_BOARDS_DIR','boards_images'),
];