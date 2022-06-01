<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comedian;
use Illuminate\Http\Request;

class ComediansController extends Controller
{

    /**
     * List Comedians
     *
     * @return mixed
     */
    public function index()
    {
        return Comedian::get()->all();
    }

    /**
     * Create Comedian
     *
    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'code' => 'required|string|max:255',
            'status' => 'required|string|max:255|in:active,inactive',
        ]);

        return Comedian::create($validated);
    }

    /**
     * Update Comedian
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'code' => 'required|string|max:255',
            'status' => 'required|string|max:255|in:active,inactive',
        ]);

        Comedian::find($id)->update($validated);
    }

    /**
     * Delete Comedian
     *
     * @param $id
     */
    public function destroy($id)
    {
        Comedian::find($id)->delete();
    }
}
