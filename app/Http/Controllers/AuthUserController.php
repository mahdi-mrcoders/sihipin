<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataUser = AuthUser::all();
        return response()->json($dataUser);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataForm = $request->all();
        $dataForm['password'] = md5($request->password);
        $dataDosen = AuthUser::create($dataForm);
        return response()->json([
            'message' => 'Data berhasil di simpan',
            'data' => $dataForm
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function show(AuthUser $pengguna)
    {
        return response()->json($pengguna);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthUser $authUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pengguna)
    {
        if ($request->password) {
            $dataForm = [
                'level' => $request->level,
                'password' => md5($request->password)
            ];
        } else {
            $dataForm = [
                'level' => $request->level,
            ];
        }
        $dataUser = AuthUser::where('id_pengguna', $pengguna)->update($dataForm);
        return response()->json([
            'message' => 'Data berhasil di simpan',
            'data' => $dataForm
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthUser $pengguna)
    {
        $pengguna->delete();
        return response()->json([
            'message' => 'data dosen Deleted Successfully!!'
        ]);
    }

    function userauth(Request $request)
    {
        $AuthUser = [
            'email' => $request->email,
            'password' => md5($request->password)
        ];

        $chekingUser = AuthUser::where('email_dosen', $AuthUser['email'])->where('password', $AuthUser['password'])->first();
        if ($chekingUser) {
            $response = [
                'login' => true,
                'uuid' => $chekingUser->id_pengguna,
                'level' => $chekingUser->level
            ];
        } else {
            $response = [
                'login' => false,
                'uuid' => null,
                'level' => null
            ];
        }

        return response()->json($response);
    }

    function userexist()
    {
        $dataUser = DB::table('v_pengguna')->get();

        return response()->json($dataUser);
    }

    function userbylevel()
    {
        $idUser = request()->get('ids');
        if($idUser){
            $dataUser = DB::table('v_pengguna')->where('level',2)->Where('id','!=',$idUser)->get();
        }else{
            $dataUser = DB::table('v_pengguna')->where('level',2)->get();
        }
        
        return response()->json($dataUser);
    }
}
