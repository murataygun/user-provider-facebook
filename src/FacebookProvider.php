<?php
/*
 * laravel-packages - FacebookProvider.php
 * Initial version by : murataygun
 * Initial version created on : 14.5.2020 00:25
 */

namespace murataygun\UserProviderFacebook;


use murataygun\UserProviderFacebook\Util\FacebookUtil;

/**
 * Class FacebookProvider
 * @package murataygun\UserProviderFacebook
 */
class FacebookProvider
{
    /**
     * @param $accessToken
     * @return mixed
     * @throws \Exception
     */
    public static function getUserData($accessToken)
    {
        $url = str_replace(':access_token', $accessToken, FacebookUtil::getEndpointURL());
        try {
            return json_decode(file_get_contents($url));;
        } catch (\Exception $exception) {
            throw new \Exception("Not found facebook user data");
        }
    }
}
