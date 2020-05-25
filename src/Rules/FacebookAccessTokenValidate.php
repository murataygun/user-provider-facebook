<?php
/*
 * laravel-packages - FacebookGrant.php
 * Initial version by : murataygun
 * Initial version created on : 13.5.2020 02:24
 */

namespace murataygun\UserProviderFacebook\Rules;

use Illuminate\Contracts\Validation\Rule;
use Mockery\Exception;
use murataygun\UserProviderFacebook\FacebookProvider;
use murataygun\UserProviderFacebook\Util\FacebookUtil;

/**
 * Class FacebookAccessTokenValidate
 * @author Murat AYGÜN <info@murataygun.com>
 * @package murataygun\UserProviderFacebook\Rules
 */
class FacebookAccessTokenValidate implements Rule
{
    /**
     * @var null
     */
    private $scopes = null;
    /**
     * @var mixed
     */
    private $configFacebook;
    /**
     * @var mixed
     */
    private $client_id;
    /**
     * @var mixed
     */
    private $client_secret;

    /**
     * Create a facebook access token rule instance.
     *
     * @param null $scopes
     */
    public function __construct($scopes = null)
    {

        $this->scopes = $scopes;
        $this->configFacebook = app()['config']['user-provider-facebook'];

        if (!isset($this->configFacebook['facebook'])) {
            throw new Exception('Config array not found in: user-provider-facebook.facebook', 500);
        }

        $this->client_id = $this->configFacebook['facebook']['client_id'];
        $this->client_secret = $this->configFacebook['facebook']['client_secret'];
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->validateClient($value)) {
            return false;
        }

        return $this->validate($value);
    }

    /**
     * @param $accessToken
     * @return bool
     */
    private function validate($accessToken): bool
    {
        try {
            FacebookProvider::getUserData($accessToken);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $accessToken
     * @return bool
     */
    private function validateClient($accessToken): bool
    {
        $appAccessToken = $this->getAppAccessToken();

        if (is_null($appAccessToken)) return false;

        $url = str_replace([':access_token', ':app_access_token'],
            [$accessToken, $appAccessToken],
            FacebookUtil::getInspectURL()
        );

        try {
            $response = json_decode(file_get_contents($url));

            if (!$response->data->is_valid) return false;

            if ($response->data->app_id != $this->client_id)
                return false;

            if (!is_null($this->scopes) && array_diff($this->scopes, $response->data->scopes))
                return false;

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @return string |null
     */
    private function getAppAccessToken(): ?string
    {
        $url = str_replace([':client_id', ':client_secret'],
            [$this->client_id, $this->client_secret],
            FacebookUtil::getAppAccessTokenURL()
        );

        try {
            $response = json_decode(file_get_contents($url));

            return $response->access_token;
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Access token could not be verified.';
    }
}
