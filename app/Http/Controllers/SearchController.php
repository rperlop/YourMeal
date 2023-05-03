<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Restaurant;
use App\Models\Schedule;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller {
    /**
     * Search a restaurant
     *
     * @param Request $request
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function search( Request $request ): \Illuminate\Foundation\Application|View|Factory|Application {
        $food_types   = FoodType::all();
        $price_ranges = PriceRange::all();

        // Obtener el término de búsqueda
        $search_term = $request->input('search_term');

        // Obtener todos los restaurantes que coincidan con el término de búsqueda
        $restaurants = Restaurant::where('name', 'like', '%'.$search_term.'%')
                                 ->orWhere('address', 'like', '%'.$search_term.'%')
                                 ->orWhere('description', 'like', '%'.$search_term.'%')
                                 ->get();

        // Obtener los ids de los restaurantes encontrados
        $restaurant_ids = $restaurants->pluck('id');

        // Obtener los tipos de comida, horarios y rangos de precios relacionados con los restaurantes encontrados
        $food_types = FoodType::whereIn('restaurant_id', $restaurant_ids)->get();
        $schedules = Schedule::whereIn('restaurant_id', $restaurant_ids)->get();
        $priceRanges = PriceRange::whereIn('restaurant_id', $restaurant_ids)->get();

        // Obtener los parámetros de filtrado y ordenamiento de la solicitud
        $filter_food_types = $request->input('filterFoodTypes', []);
        $filter_schedules = $request->input('filterSchedules', []);
        $filter_price_ranges = $request->input('filterPriceRanges', []);
        $order_by_price_range = $request->input('orderByPriceRange');
        $order_by_rate = $request->input('orderByRate');

        // Filtrar los resultados según los parámetros de filtrado
        if (!empty($filter_food_types)) {
            $restaurants = $restaurants->whereIn('food_type_id', $filter_food_types);
        }

        if (!empty($filter_schedules)) {
            $restaurants = $restaurants->whereIn('schedule_id', $filter_schedules);
        }

        if (!empty($filter_price_ranges)) {
            $restaurants = $restaurants->whereIn('price_range_id', $filter_price_ranges);
        }

        // Ordenar los resultados según los parámetros de ordenamiento
        if ($order_by_price_range) {
            $restaurants = $restaurants->join('price_ranges', 'restaurants.price_range_id', '=', 'price_ranges.id')
                                       ->orderBy('price_ranges.order', $order_by_price_range)
                                       ->select('restaurants.*');
        }

        if ($order_by_rate) {
            $restaurants = $restaurants->join('rates', 'restaurants.id', '=', 'rates.restaurant_id')
                                       ->orderBy('rates.average_rate', $order_by_rate)
                                       ->select('restaurants.*');
        }

        // Devolver los resultados en una vista
        return view('search.results', compact('restaurants', 'food_types', 'schedules', 'priceRanges'));
    }


    public function search_location (Request $request): JsonResponse {
        $query = $request->input('query');

        $client = new Client(['base_uri' => 'https://api.opencagedata.com/geocode/v1/']);
        $response = $client->get('json', [
            'query' => [
                'q' => $query,
                'key' => env('OPENCAGE_API_KEY')
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $predictions = [];

        foreach($data['results'] as $result) {
            $formatted = $result['formatted'];
            $predictions[] = $formatted;
        }

        return response()->json($predictions);
    }
}
