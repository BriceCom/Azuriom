<?php

use Azuriom\Models\User;
use Azuriom\Plugin\Achievement\Models\UserTrophyPoints;

if (! function_exists('achievement_trophy_name')) {
    /**
     * Get the custom name for the Trophy system.
     *
     * @return string
     */
    function achievement_trophy_name()
    {
        return setting('achievement.trophy_name', 'Trophy');
    }
}

if (! function_exists('achievement_trophy_icon')) {
    /**
     * Get the custom icon for the Trophy system.
     *
     * @return string
     */
    function achievement_trophy_icon()
    {
        return setting('achievement.trophy_icon', 'bi bi-trophy');
    }
}

if (! function_exists('achievement_trophy_image')) {
    /**
     * Get the custom image for the Trophy system.
     *
     * @return string|null
     */
    function achievement_trophy_image()
    {
        return setting('achievement.trophy_image');
    }
}

if (! function_exists('achievement_trophy_image_url')) {
    /**
     * Get the URL to the custom image for the Trophy system.
     *
     * @return string|null
     */
    function achievement_trophy_image_url()
    {
        $image = achievement_trophy_image();

        if (empty($image)) {
            return null;
        }

        return image_url($image);
    }
}

if (! function_exists('achievement_user_trophy_points')) {
    /**
     * Get the trophy points for a user.
     *
     * @param  \Azuriom\Models\User|int  $user
     * @return int
     */
    function achievement_user_trophy_points($user)
    {
        $userId = $user instanceof User ? $user->id : $user;

        return UserTrophyPoints::getTrophyPoints($userId);
    }
}

if (! function_exists('achievement_add_trophy_points')) {
    /**
     * Add trophy points to a user.
     *
     * @param  \Azuriom\Models\User|int  $user
     * @param  int  $points
     * @return void
     */
    function achievement_add_trophy_points($user, int $points)
    {
        $userId = $user instanceof User ? $user->id : $user;

        UserTrophyPoints::addTrophyPoints($userId, $points);
    }
}
