<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLogoutController extends Controller
{

    public function __invoke(Request $request)
    {
        // $user = $request->user();でunauthorizedが返ってくる場合は、
        // $user = Auth::guard('web')->user();に変更する
        if (!$request->user()) {
            return response()->json(['message' => 'ログインしていません'], 401);
        } else {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'ログアウトしました'], 200);
        }

        $user = $request->user();


        // トークンが存在しない場合
        if ($user->tokens->isEmpty()) {
            return response()->json(['message' => 'トークンが存在しません'], 400);
        }

        // トークンを削除
        $user->tokens()->delete();

        // ユーザーをログアウト
        auth()->guard()->logout();

        // httpOnlyのトークンcookieを削除する
        $cookie = cookie('token', '', -1);

        return response()->json([
            'message' => 'ログアウトしました'
        ])->withCookie($cookie);
    }
}
