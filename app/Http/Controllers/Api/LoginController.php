<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (in_array('', $request->only('email_usuario', 'password'))) {
            return response()->json([
                'message' => 'Oooops, informe todos os dados para efetuar o login!'
            ], 401);
        }

        if (!filter_var($request->email_usuario, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'Oooops, informe um e-mail válido!'
            ], 401);
        }

        $credentials = [
            'email_usuario' => $request->email_usuario,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Oooops, dados não conferem ou você não tem acesso a essa área!'
            ], 401);
        }

        $token = Auth::user()->createToken($request->header('User-Agent'));

        return response()->json([
            'message' => 'Autenticação realizada com sucesso!',
            'token' => $token->plainTextToken,
            'usuario'=> Auth::user(),
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $rules = [
            'nome' => 'required',
            'email' => 'required|email|unique:users,email',
            'cpf' => "required|min:11|max:14|unique:users,cpf",
            'cell' => 'required',
            'password' => 'required',
        ];

        $message = [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Esse e-mail já está cadastrado.',
            'cpf.unique' => 'Esse CPF já possui cadastrado.',
            'password.required' => 'A senha é obrigatória.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
            }

        try {
            DB::beginTransaction();

            $userCreate = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'cell' => $request->cell,
                'cpf' => $request->cpf,
                'rg' => $request->rg,
                'password' => $request->password,
            ]);

            DB::commit();

            $ultimoUsuario = DB::table('users')->latest()->first('id');

            $ultimoUsuarioId = $ultimoUsuario->id;

            Auth::loginUsingId($ultimoUsuarioId);
            Session::forget('pagamentoPlano');
            Session::push('pagamentoPlano', false);

            return redirect()->route('admin.pagina.index')->with([
                'color' => 'success',
                'message' => 'Cadastro efetuado com sucesso. Faça o Login!'
            ]);
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function usuario(Request $request)
    {
        $usuario = Auth::user();

        try {
            DB::beginTransaction();

            $userCreate = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'cell' => $request->cell,
                'cpf' => $request->cpf,
                'rg' => $request->rg,
                'password' => $request->password,
            ]);

            DB::commit();

            $ultimoUsuario = DB::table('users')->latest()->first('id');

            $ultimoUsuarioId = $ultimoUsuario->id;

            Auth::loginUsingId($ultimoUsuarioId);
            Session::forget('pagamentoPlano');
            Session::push('pagamentoPlano', false);

            return redirect()->route('admin.pagina.index')->with([
                'color' => 'success',
                'message' => 'Cadastro efetuado com sucesso. Faça o Login!'
            ]);
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors([
                'message' => $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
