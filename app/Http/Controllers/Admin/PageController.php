<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::simplePaginate(10);
        $total_pages = Page::all()->count();
        return view('admin.pages.index', [
            'pages' => $pages,
            'total_pages' => $total_pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['title', 'body']);

        $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'body' => ['string'],
            // $data['slug'] => ['required', 'string', 'max:100', 'unique:pages'] 
        ]);

        // Verificação se slug já existe
        $title_slug = Str::slug($data['title'], '-');

        $hasSlug = Page::where('slug', $title_slug)->get();

        if(count($hasSlug) === 0) {
            $data['slug'] = $title_slug;
        } else {
            return back()->withErrors([
                'title' => 'O título inserido pertence a outra página'
            ])->withInput();
        }
        
        Page::create($data);

        return redirect(route('pages.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);

        if($page) {
            return view('admin.pages.edit', [
                'page' => $page
            ]);
        }
        return redirect(route('pages.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        if($page) {       
            $data = $request->only(['title', 'body']);
            
            if($page['title'] !== $data['title']) {
                $data['slug'] = Str::slug($data['title'], '-');

            // Alteração do slug
            if($page->title != $data['title']) {
                $hasSlug = Page::where('slug', $data['slug'])->get();
                if(count($hasSlug) === 0) {
                    $page->slug = $data['slug'];
                } else {
                    return back()->withErrors([
                        'title' => 'O título inserido pertence a outra página'
                    ]);
                }
            }

            } else {
                $request->validate([
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string']
                ]);
            }  

            // 1. Alteração do título e body
            $page->title = $data['title'];
            $page->body = $data['body'];

            if(!empty($data['slug'])) {
                $page->slug = $data['slug'];
            }
            
            // Salvar os dados
            $page->save();
        }
        return redirect(route('pages.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::find($id)->delete();
        return redirect(route('pages.index'));
    }
}
