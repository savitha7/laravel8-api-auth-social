<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAccountsService;

class AuthController extends ApiBaseController
{  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToProvider($provider)
    {
        $success['provider_redirect'] = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
   
        return $this->sendResponse($success, "Provider '".$provider."' redirect url.");
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleProviderCallback($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();

            if ($providerUser) {
                $user = (new SocialAccountsService())->findOrCreate($providerUser, $provider);

                $success['token'] = $user->createToken(env('API_AUTH_TOKEN_SOCIAL'))->accessToken; 
                $success['name'] = $user->name;
       
                return $this->sendResponse($success, 'User login successfully.');
            }

        } catch (Exception $exception) {
            return $this->sendError('Unauthorised.', ['error'=>$e->getMessage()], 401);
        }        
    }
}