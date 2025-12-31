<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;

class LikeController extends Controller
{
    public function store(Request $request, string $type, int $id)
    {
        $likeable = $this->findLikeable($type, $id);

        $this->authorize('create', [Like::class, $likeable]);

        $likeable->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        $likeable->increment('likes_count');

        return back();
    }
    

    public function destroy(Request $request, string $type, int $id)
    {
        $likeable = $this->findLikeable($type, $id);

       $this->authorize('delete', [Like::class, $likeable]);

        $likeable->likes()->whereBelongsTo($request->user())->delete();

        $likeable->decrement('likes_count');

        return back();
    }

    private function findLikeable(string $type, int $id)
    {
        $modelClass = Relation::getMorphedModel($type);

        return $modelClass::findOrFail($id);
    }
}

