<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = AgendaItem::query();

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $items = $query->orderBy('start_date', 'asc')->get();

            foreach ($items as $item) {
                $item->image_url = $item->image_url;
                $item->makeVisible('categoryKey');
            }

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

    public function show($id)
    {
        try {
            $item = AgendaItem::findOrFail($id);
            $item->image_url = $item->image_url;
            $item->makeVisible('categoryKey');

            return response()->json([
                'success' => true,
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda item not found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|string',
            'end_date' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:concept,published,cancelled',
            'published_at' => 'nullable|string',
            'categoryKey' => 'required|string|in:lol,khll,activiteiten',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('agenda-images', $filename, 'public');
                if ($path) {
                    $data['image'] = $path;
                }
            }

            $item = AgendaItem::create($data);
            $item->image_url = $item->image_url;
            $item->makeVisible('categoryKey');

            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Agenda item successfully created'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating agenda item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create agenda item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = AgendaItem::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|string',
                'end_date' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'status' => 'nullable|in:concept,published,cancelled',
                'published_at' => 'nullable|string',
                'categoryKey' => 'nullable|string|in:lol,khll,activiteiten',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();


            // Controleer of de afbeelding expliciet verwijderd moet worden
            if ($request->has('image') && $request->input('image') === '') {
                // Verwijder de bestaande afbeelding uit de storage
                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }
                $data['image'] = null;
            }
            // Controleer of er een nieuwe afbeelding is geüpload
            elseif ($request->hasFile('image')) {
                // Verwijder de oude afbeelding als die bestaat
                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }

                // Sla de nieuwe afbeelding op
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('agenda-images', $filename, 'public');
                if ($path) {
                    $data['image'] = $path;
                }
            }
            // 3. Anders (geen image veld meegegeven) -> blijft de bestaande afbeelding ongewijzigd

            $item->update($data);
            $item->image_url = $item->image_url;
            $item->makeVisible('categoryKey');

            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Agenda item successfully updated'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating agenda item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update agenda item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $item = AgendaItem::findOrFail($id);

            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Agenda item successfully deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete agenda item'
            ], 500);
        }
    }
}
