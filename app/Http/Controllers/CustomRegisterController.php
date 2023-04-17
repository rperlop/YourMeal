<?php

namespace App\Http\Controllers;

use App\Models\Auth\RegisterController;
use Illuminate\Http\Request;
use App\Models\User;

class CustomRegisterController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index( RegisterController $registerController ) {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( RegisterController $registerController ) {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request, RegisterController $registerController ) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( RegisterController $registerController ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( RegisterController $registerController, User $user ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, RegisterController $registerController, User $user ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( RegisterController $registerController, User $user ) {
        //
    }
}
