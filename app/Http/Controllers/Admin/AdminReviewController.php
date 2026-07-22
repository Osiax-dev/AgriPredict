<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    /**
     * Liste de tous les avis (admin)
     */
    public function index()
    {
        $reviews = Review::with('user:id,name,email')
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => Review::count(),
            'approved' => Review::where('approved', true)->count(),
            'pending' => Review::where('approved', false)->count(),
            'average' => round(Review::avg('rating'), 1),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Approuver un avis
     */
    public function approve(Review $review)
    {
        $review->update(['approved' => true]);

        return back()->with('success', 'Avis approuvé avec succès.');
    }

    /**
     * Rejeter un avis
     */
    public function reject(Review $review)
    {
        $review->update(['approved' => false]);

        return back()->with('success', 'Avis rejeté.');
    }

    /**
     * Supprimer un avis (admin)
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Avis supprimé définitivement.');
    }
}