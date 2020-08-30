<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Auth0IndexController extends Controller
{
  /**
    * Redirect to the Auth0 hosted login page
    *
    * @return mixed
    * @OA\Post(
    * path="/login",
    * summary="Sign in",
    * description="Login by email, password",
    * operationId="authLogin",
    * tags={"auth"},
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"email","password"},
    *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
    *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
    *       @OA\Property(property="persistent", type="boolean", example="true"),
    *    ),
    * ),
    * @OA\Response(
    *    response=422,
    *    description="Wrong credentials response",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
    *        )
    *     )
    * )
    */
  public function login()
  {
    $authorize_params = [
      'scope' => 'openid profile email',
    ];
    return \App::make('auth0')->login(null, null, $authorize_params);
  }

  /**
    * Log out of Auth0
    *
    * @return mixed
    */
  public function logout()
  {
    \Auth::logout();
    $logoutUrl = sprintf(
      'https://%s/v2/logout?client_id=%s&returnTo=%s',
      env('AUTH0_DOMAIN'),
      env('AUTH0_CLIENT_ID'),
      env('APP_URL'));
    return  \Redirect::intended($logoutUrl);
  }
}