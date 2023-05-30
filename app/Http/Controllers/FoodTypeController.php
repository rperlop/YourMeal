<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FoodTypeController extends Controller {
    /**
     * Index all food types
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application {
        $foodTypes = FoodType::all();

        return view( 'food_types.index', [ 'foodTypes' => $foodTypes ] );
    }

    /**
     * Store a new food type
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store( Request $request ): RedirectResponse {
        $request->validate( [
            'name' => 'required|unique:food_types,name',
        ] );

        $food_type       = new FoodType();
        $food_type->name = $request->input( 'name' );
        $food_type->save();

        toastr()->success( 'Food type added successfully.' );

        return redirect()->back();
    }
}
