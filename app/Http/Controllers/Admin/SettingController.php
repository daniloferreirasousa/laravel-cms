<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index() {
        $settings = [];

        $dbSettings = Setting::all();

        
        foreach($dbSettings as $dbSetting) {
            $settings[$dbSetting['name']] = $dbSetting['content'];
        }

        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function save(Request $request) {
        $request->validate([
            'title' => ['string', 'max:100'],
            'subtitle' => ['string', 'max:100'],
            'email' => ['string', 'email'],
            'bgcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i'],
            'fontcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i']
        ]);

        $data = $request->only([
            'title', 'subtitle', 'email', 'bgcolor', 'fontcolor'
        ]);

        foreach($data as $item => $value) {
            Setting::where('name', $item)->update([
                'content' => $value
            ]);
        }

        return redirect(route('panel.settings'))->with('warning', 'Informações alteradas com sucesso.');
    }

}
