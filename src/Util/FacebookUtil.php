<?php
/*
 * laravel-packages - FacebookUtil.php
 * Initial version by : murataygun
 * Initial version created on : 14.5.2020 00:27
 */

namespace murataygun\UserProviderFacebook\Util;

/**
 * Class FacebookUtil
 * @package murataygun\UserProviderFacebook\Util
 */
class FacebookUtil
{
    /**
     * @return string
     */
    public static function getEndpointURL(): string
    {
        return config('user-provider-facebook.url.endpoint');
    }

    /**
     * @return string
     */
    public static function getInspectURL(): string
    {
        return config('user-provider-facebook.url.inspect');
    }

    /**
     * @return string
     */
    public static function getAppAccessTokenURL(): string
    {
        return config('user-provider-facebook.url.app_access_token');
    }
}
