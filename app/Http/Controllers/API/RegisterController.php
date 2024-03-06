<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\UploadDocumentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'dLNumber' => 'required',
            'carrierName' => 'required',
            'stateName' => 'required',
            'usDotNumber' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.' . $validator->errors()->first(), '');
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success = new \stdClass();
            $success = $user;
            $success['doc'] = UploadDocumentModel::where('user_id','=',$user->id)->get();
            $success->token = $user->createToken('auth_token')->plainTextToken;
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();
        return response()->json('Successfully logged out');
    }

    public function profile_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.' . $validator->errors()->first(), '');
        }
        $user = User::where('id', $request->user_id)->firstorfail();
        $user->save();
        return response()->json(array('status' => 'Profile updated!'), 200);
    }


    public function profile_update_img(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'profile_img' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.' . $validator->errors()->first(), '');
        }
        $user = User::where('id', $request->user_id)->firstorfail();

        if($request->doc_type == 1){
            // image
            if ($request->hasFile('profile_img')) {
                $user->profile_img = $request->file('profile_img')->store('adminpanel/images/profile');
            } else {
                return response()->json(array('status' => 'Profile not updated!'), 400);
            }
            $user->save();
            return response()->json(array('status' => 'Profile updated!'), 200);
        }elseif($request->doc_type == 2){
            // doc type
            $path = $request->file('profile_img')->store('assets/doc');
            $modelObject = new UploadDocumentModel();
            $modelObject->user_id = (int)$request->input('user_id');
            $modelObject->path = 'storage/app/' . $path;
            $modelObject->save();
            return response()->json(array('status' => 'User Document uploaded.'), 200);
        }
    }
}
