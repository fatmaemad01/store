<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $news = [
        1=>'News Title 1',
        2=>'News Title 2',
        3=>'News Title 3',
        4=>'News Title 4',
    ];

    // Actions 
    public function index()
    {
        // return 'Welcome';    here we write what we need  to show 
        return view('Welcome');     // here we call view file 
    }

    public function news($id = 0)
    {
        if ($id){
            echo '<h1>'.$this->news[$id].'</h1>';
        } else{
        echo '<ul>';
        foreach ($this->news as $news)
        {
            echo '<li>'.$news.'</li>';
        }
        echo '</li>';
        // return view('news');
    }
}
}
