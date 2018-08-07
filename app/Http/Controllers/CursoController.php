<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Curso;
use App\Cursos_has_user;
use App\Video_curso;
use App\User;
use DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class CursoController extends Controller
{


    //para acessar as funções desse controlador, será necessário realizar o login
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Retorna a view de cadastrar cursos
    public function adminAddCurso()
    {
        return view('inserir_curso');
    }

    //Controller que coloca os dados do curso no banco, como os videos de PDF  
    public function salvar(Request $request)
    {
        $cursos = new Curso();
        

        $cursos->nome = $request->nome;
        $cursos->descricao = $request->descricao;

        $path = Storage::disk('public')->putFile('cursos',$request->img);
        $cursos->img = ( URL::to('/storage') . "/" . $path);

        $path = Storage::disk('public')->putFile('cursos',$request->pdf);
        $cursos->pdf = ( URL::to('/storage') . "/" . $path);

        $cursos->save();
        

        return view('salvarVideo', compact('cursos'));


    }

    //Salvar vídeo
    public function salvarVideo(Curso $cursos)
    {
        $videos = new Video_curso();
        $cursos = Curso::all();

        return redirect('/persisteVideo');

    }

    public function persisteVideo(Request $request)
    {
        $videos = new Video_curso();

        $videos->cursos_id = $request->cursos_id;
        $videos->video = str_replace("watch?v=","embed/",$request->video);


        $videos->save();

        return redirect('/cursos');
    }



    //Pagina de lista de cursos
    public function cursos()
    {   

        $dados = Curso::All();
        $loggedUser = \Auth::user();
        return view('cursos', compact('dados','loggedUser'));

    }

    //Controller que gerencia os usuarios que acessam o curso
  
    //Retorna a view do curso já com os videos e o PDF
    public function cursosView(Curso $dados)
    {
        $cursando = new Cursos_has_user();

        $videos = DB::table('video_cursos')
                ->where('cursos_id', '=' , $dados->id)
                ->get();

        $loggedUser = \Auth::user();
        
        $cursando->users_id = $loggedUser->id;
        $cursando->cursos_id = $dados->id;
        
        $cursando->save();

        return view('cursosView', compact('dados','videos'));
    }

    //Pega a lista de usuarios cadastrados
    public function users()
    {
        $loggedUser = \Auth::user();
        $dados =  User::All();
        return view('users', compact('dados','loggedUser'));
        
    }

    //Lista de acesso do usuario especifico
    public function adminUsersCurso(User $dados)
    {
        $users = DB::table('cursos_has_users')
        ->join('cursos', 'cursos.id', '=', 'cursos_has_users.cursos_id')
        ->join('users', 'users.id', '=', 'cursos_has_users.users_id')
        ->where('users.id', '=', $dados->id)
        ->select('users.name as nome', 'cursos.nome as curso', 'cursos_has_users.created_at as acesso')
        ->get();

        // dd($dados); 
        
        return view('listaUsers', compact('users'));

    }

    //rota que exclui historico de acesso dos usuarios
    public function deleteUsers()
    {
        
        Cursos_has_user::getQuery()->delete();

        return redirect('/adminUsers');
    }

    public function deleteColaborador(User $user)
    {
        $user->delete();

        return redirect('/adminUsers');
    }

    public function adminEditarCurso()
    {
        $dados = Curso::all();

        return view('adminEditarCurso', compact('dados'));

    }

    public function editarCurso(Curso $dados)
    {
        return view('editarCurso', compact('dados'));
    }

    public function editar(Request $request)
    {
        $cursos = Curso::find($request->id);

        

        $cursos->nome = $request->nome;
        $cursos->descricao = $request->descricao;
        
        $path = Storage::disk('public')->putFile('cursos',$request->img);
        $cursos->img = ( URL::to('/storage') . "/" . $path);

        $cursos->video = str_replace("watch?v=","embed/",$request->video);
        
        $path = Storage::disk('public')->putFile('cursos',$request->pdf);
        $cursos->pdf = ( URL::to('/storage') . "/" . $path);

        return redirect('/adminEditarCurso');
    }

    public function deleteCurso(Curso $curso)
    {

        $curso->delete();


        // $curso->delete();
        return redirect('/adminEditarCurso');
        
    }
}

