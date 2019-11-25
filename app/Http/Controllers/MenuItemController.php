<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuItemCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        throw new \Exception('not implented because of lack of sense');
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        return new MenuItemCollection(\App\Menu::find($menu)->root->children);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        //
    }
}
