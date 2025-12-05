<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTopTenRequest;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class TopTenController extends Controller
{
    public function index()
    {
        $customTopTen = Movie::whereNotNull('top_ten_position')
            ->orderBy('top_ten_position', 'asc')
            ->get();
        
        if ($customTopTen->count() > 0) {
            return response()->json($customTopTen);
        }
        
        $defaultTopTen = Movie::orderBy('vote_count', 'desc')
            ->take(10)
            ->get();
        
        return response()->json($defaultTopTen);
    }

    public function update(UpdateTopTenRequest $request)
    {
        $data = $request->validated();
        $movieIds = $data['movieIds'];

        DB::beginTransaction();
        try {
            Movie::whereNotNull('top_ten_position')
                ->update(['top_ten_position' => null]);
            
            foreach ($movieIds as $position => $movieId) {
                Movie::where('id', $movieId)
                    ->update(['top_ten_position' => $position + 1]);
            }
            
            DB::commit();
            
            $topTen = Movie::whereNotNull('top_ten_position')
                ->orderBy('top_ten_position', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Top 10 updated successfully',
                'data' => $topTen,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update top 10: ' . $e->getMessage(),
            ], 500);
        }
    }

    
    public function reset()
    {
        Movie::whereNotNull('top_ten_position')
            ->update(['top_ten_position' => null]);
        
        $defaultTopTen = Movie::orderBy('vote_count', 'desc')
            ->take(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Top 10 reset to default',
            'data' => $defaultTopTen,
        ]);
    }
}
