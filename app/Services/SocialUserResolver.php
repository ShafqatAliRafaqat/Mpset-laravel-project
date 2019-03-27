<?php

namespace App\Services;

use Exception;
use Hivokas\LaravelPassportSocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;
// do not use
class SocialUserResolver implements SocialUserResolverInterface {

    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */

    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable {

        $providerUser = null;

        try {

            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);

        } catch (Exception $exception) {}

        if ($providerUser) {
            return (new SocialAccountsService())->findOrCreate($providerUser, $provider);
        }

        return null;
    }
}
