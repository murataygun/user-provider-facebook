<?php
/*
 * laravel-packages - FacebookGrant.php
 * Initial version by : murataygun
 * Initial version created on : 13.5.2020 01:24
 */

namespace murataygun\UserProviderFacebook;


use murataygun\UserProvider\AbstractUserProviderGrant;

/**
 * Class FacebookGrant
 * @package murataygun\UserProviderFacebook
 */
class FacebookGrant extends AbstractUserProviderGrant
{
    /**
     * @return string
     */
    public function getIdentifier()
    {
        return 'facebook';
    }
}
