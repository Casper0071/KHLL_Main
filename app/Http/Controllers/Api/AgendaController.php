<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{

    public function index(Request $request)
    {
        try {
            $query = AgendaItem::query();

            // Filter op status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // Filter op zoekterm
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Filter op datum range
            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('start_date', '>=', $request->start_date);
            }

            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('start_date', '<=', $request->end_date);
            }

            $items = $query->orderBy('start_date', 'asc')->get();

            return response()->json([
                'success' => true,
                'data' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch agenda items: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:concept,published,cancelled',
            'published_at' => 'nullable|date',  // Nieuwe validatie
            'color' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $item = AgendaItem::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Agenda item successfully created'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating agenda item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create agenda item'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $item = AgendaItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'status' => 'sometimes|required|in:concept,published,cancelled',
            'published_at' => 'nullable|date',  // Nieuwe validatie
            'color' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $item->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Agenda item successfully updated'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating agenda item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update agenda item'
            ], 500);
        }
    }


    public function show($id)
    {
        $item = AgendaItem::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }



    public function destroy($id)
    {
        $item = AgendaItem::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agenda item deleted'
        ]);
    }
}
