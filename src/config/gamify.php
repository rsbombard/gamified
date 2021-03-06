<?php

return [
    // Reputation model
    'xp_model'                  => '\Bomb\Gamify\Xp',

    // Broadcast on private channel
    'broadcast_on_private_channel' => true,

    // Channel name prefix, user id will be suffixed
    'channel_name'                 => 'user.reputation.',

    // Badge model
    'badge_model'                  => '\Bomb\Gamify\Badge',

    // Where all badges icon stored
    'badge_icon_folder'            => 'img/badges/',
    'quest_icon_folder'            => 'img/quests/',

    // Extention of badge icons
    'badge_icon_extension'         => '.png',
    'quest_icon_extension'         => '.png',

    // All the levels for badge
    'badge_levels'                 => [
        'beginner'     => 1,
        'intermediate' => 2,
        'advanced'     => 3,
    ],

    // Default level
    'badge_default_level'          => 1,

    // Badge achieved vy default if check function not exit
    'badge_is_achieved'            => false,

    // xp achieved vy default if check function not exit
    'xp_is_achieved'            => true,
];
