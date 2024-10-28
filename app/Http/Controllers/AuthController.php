<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    /**
     * Creates a User and Profile Data
     * @param Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validator = validator($request->all(), [
            "name" => "required|string|min:4|alpha_dash|unique:users|max:64",
            "email" => "required|email|max:255|unique:users",
            "password" => "required|confirmed|min:8|max:64|string",
            "first_name" => "required|string|max:64",
            "last_name" => "required|string|max:64",
            "section_name" => "required|string|max:64",
            "birth_date" => "required|date|before:tomorrow",
            "gender" => "required|int|min:1|max:3"
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $validated = $validator->validated();

        $user = User::create($validator->safe()->only("name", "email", "password"));
        // User::create([
        //     "name" => $validated['name'],
        //     "email" => $validated["email"],
        //     "password" => $validated["password"],
        // ]);

        $user->profile()->create($validator->safe()->except("name", "email", "password"));
        $user->profile;
        
        return $this->Created($user, "Account has been created!");

    }


    /**
     * Attempt to authenticate username and password
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = validator($request->all(), [
            "name" => "required",
            "password" => "required"
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator, "All fields are required!");
        }

        $validated = $validator->validated();

        if(!auth()->attempt([
            filter_var($validated['name'], FILTER_VALIDATE_EMAIL) ? "email" : "name" => $validated['name'],
            "password" => $validated['password']
        ])){
            // this is the code for invalid credentials
            return $this->Unauthorized("Invalid Credentials!");
        }
        
        $user = auth()->user();
        $user->profile;

        $token = $user->createToken("api")->accessToken;

        return $this->Ok([
            "user" => $user,
            "token" => $token
        ], "Logged in success!");
    }

    // Check Token
    public function checkToken(Request $request){
        $user = $request->user();
        $user->profile;

        return $this->Ok($user, "Valid Token!");
    }
}
