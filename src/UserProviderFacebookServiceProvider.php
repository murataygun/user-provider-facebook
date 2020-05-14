<?php
/*
 * laravel-packages - UserProviderFacebookServiceProvider.php
 * Initial version by : murataygun
 * Initial version created on : 13.5.2020 01:26
 */

namespace murataygun\UserProviderFacebook;

use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Passport;
use murataygun\UserProvider\AbstractUserProviderServiceProvider;
use murataygun\UserProviderFacebook\Util\FacebookUtil;

/**
 * Class UserProviderFacebookServiceProvider
 * @package murataygun\UserProviderFacebook
 */
class UserProviderFacebookServiceProvider extends AbstractUserProviderServiceProvider
{
    public function register()
    {
        parent::register();
        $this->app->singleton(FacebookProvider::class, function () {
            return new FacebookProvider();
        });
    }

    /**
     * @return \League\OAuth2\Server\Grant\AbstractGrant|FacebookGrant
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function makeGrant()
    {
        $grant = new FacebookGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}
