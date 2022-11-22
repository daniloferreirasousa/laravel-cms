<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\User;
use App\Models\Page;

class AdminController extends Controller
{
    public function index(Request $request) {
        $data = [];
        
        $interval = intval($request->input('interval'));
        $data = [
            'visitsCount' => 0,
            'onlineCount' => 0,
            'pageCount' => 0,
            'userCount' => 0,
            'interval' => $interval
         ];
         
         if($interval > 120) {
            $data['interval'] = 120;
         }
         $dateInterval = date('Y-m-d H:i:s', strtotime('-'.$data['interval'].' days'));

        // Contagem do total de visitantes
        $data['visitsCount'] = Visitor::where('date_access', '>=', $data['interval'])->count();
        
        // Contagem de usuários online
        $timeLimit = date('Y-m-d H:i:s', strtotime('-3 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access', '>=', $timeLimit)->groupBy('ip')->get();
        $data['onlineCount'] = count($onlineList);

        // Contagem do total de páginas
        $data['pageCount'] = Page::count();
        
        // Contagem do total de usuários
        $data['userCount'] = User::count();

        // Contagem para o page Pie
        $pagePie = [];
        $visits = Visitor::selectRaw('page, count(page) as c')
            ->where('date_access', '>=', $data['interval'])
            ->groupBy('page')
            ->get();

        foreach($visits as $visit) {
            $pagePie[ $visit['page'] ] = intval($visit['c']);
        }

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));

        $data['pageLabels'] = $pageLabels;
        $data['pageValues'] = $pageValues;

        return view('admin.home', [
            'data' => $data
        ]);
    }
}
