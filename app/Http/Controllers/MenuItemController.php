<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuItemCollection;
use Illuminate\Http\Request;

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
        throw new \Exception('I have no idea how item could be created outside menu context');
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
