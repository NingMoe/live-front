<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {

        return view('index',[
            'user'=>session('user')
        ]);
    }

    public function face(){
        return view();
    }
}
