<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * API : Liste des avis approuvés (JSON)
     */
    public function index()
    {
        $reviews = Review::approved()
            ->with('user:id,name,email')
            ->latest()
            ->take(50)
            ->get()
            ->map(fn($r) => [
                'id'         => $r->id,
                'name'       => $r->user->name,
                'initials'   => $r->initials,
                'rating'     => $r->rating,
                'comment'    => $r->comment,
                'culture'    => $r->culture,
                'created_at' => $r->created_at_formatted,
            ]);

        return response()->json([
            'reviews'      => $reviews,
            'average'      => Review::averageRating(),
            'total'        => Review::totalApproved(),
            'distribution' => Review::ratingDistribution(),
        ]);
    }
    /**
 * Page publique des avis (redirige vers l'accueil section #avis)
 */
public function publicPage()
{
    return redirect()->route('accueil')->withFragment('avis');
}

    /**
     * Page "Mon avis" (formulaire pour l'utilisateur connecté)
     */
    public function myReviewPage()
    {
        $myReview = Review::where('user_id', Auth::id())->first();
        return view('reviews.my-review', compact('myReview'));
    }

    /**
     * API : Récupérer l'avis de l'utilisateur connecté
     */
    public function myReview()
    {
        if (!Auth::check()) {
            return response()->json(['review' => null]);
        }

        $review = Review::where('user_id', Auth::id())->first();

        if (!$review) {
            return response()->json(['review' => null]);
        }

        return response()->json([
            'review' => [
                'id'      => $review->id,
                'rating'  => $review->rating,
                'comment' => $review->comment,
                'culture' => $review->culture,
            ],
        ]);
    }

    /**
     * Créer un avis
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success'  => false,
                'message'  => 'Vous devez être connecté.',
                'redirect' => route('login'),
            ], 401);
        }

        $user = Auth::user();

        if (Review::where('user_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà laissé un avis.',
            ], 409);
        }

        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
            'culture' => ['nullable', 'string', 'max:50'],
        ]);

        $review = Review::create([
            'user_id' => $user->id,
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'],
            'culture' => $validated['culture'] ?? null,
        ]);

        $review->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Merci ' . $user->name . ' ! Votre avis a été publié avec succès.',
            'review'  => [
                'id'         => $review->id,
                'name'       => $review->user->name,
                'initials'   => $review->initials,
                'rating'     => $review->rating,
                'comment'    => $review->comment,
                'culture'    => $review->culture,
                'created_at' => $review->created_at_formatted,
            ],
        ]);
    }

    /**
     * Mettre à jour son avis
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé.'], 401);
        }

        $review = Review::where('user_id', Auth::id())->first();

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Aucun avis à modifier.'], 404);
        }

        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
            'culture' => ['nullable', 'string', 'max:50'],
        ]);

        $review->update([
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'],
            'culture' => $validated['culture'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre avis a été mis à jour avec succès.',
        ]);
    }

    /**
     * Supprimer son avis
     */
    public function destroy()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé.'], 401);
        }

        $review = Review::where('user_id', Auth::id())->first();

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Aucun avis à supprimer.'], 404);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Votre avis a été supprimé.',
        ]);
    }
}