<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller {
    /**
     * Show the admin policy configuration view
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function show_admin_policy_config(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $config = Config::all();

        return view( 'admin.pages.admin-policy', compact( 'config' ) );
    }

    /**
     * Update the banning, notifications and admin policies
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update_admin_policy_config( Request $request ): RedirectResponse {
        $validated_data = Validator::make($request->all(), [
            'compulsive_number' => 'required|integer',
            'strikes_number' => 'required|integer',
            'reports_min_number' => 'required|integer',
        ], [
            'compulsive_number.required' => 'The compulsive number is mandatory.',
            'compulsive_number.format' => 'The compulsive number has to be an integer number.',
            'strikes_number.required' => 'The strikes number is mandatory.',
            'strikes_number.format' => 'The strikes number has to be an integer number.',
            'reports_min_number.required' => 'The reports minimum number is mandatory.',
            'reports_min_number.format' => 'The reports minimum number has to be an integer number.',
        ]);

        if ($validated_data->fails()) {
            return redirect()->route('admin-policy')
                             ->withErrors($validated_data)
                             ->withInput();
        }

        $properties = ['compulsive_number', 'strikes_number', 'reports_min_number'];

        foreach ($properties as $property) {
            DB::table('config')
              ->where('property', $property)
              ->update(['value' => $request->input($property)]);
        }

        return redirect()->route( 'admin-policy' )->with( 'success', 'Admin policy configuration updated successfully.' );
    }
}
