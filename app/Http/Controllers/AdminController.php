<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parcelle;
use App\Models\Prevision;
use App\Models\Saison;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_parcelles'  => Parcelle::count(),
            'total_previsions' => Prevision::count(),
            'total_saisons'    => Saison::count(),
            'avg_rendement'    => round(Prevision::avg('rendement_prevu') ?? 0, 2),
            'admins'           => User::where('is_admin', true)->count(),
        ];

        $users = User::withCount(['parcelles', 'previsions'])
            ->latest()
            ->get();

        $previsions_recentes = Prevision::with(['parcelle', 'saison', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.index', compact('stats', 'users', 'previsions_recentes'));
    }

    public function showUser(User $user)
    {
        $user->load(['parcelles', 'previsions.parcelle', 'previsions.saison']);
        $previsions = Prevision::where('user_id', $user->id)
            ->with(['parcelle', 'saison'])
            ->latest()
            ->get();

        return view('admin.show_user', compact('user', 'previsions'));
    }

    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.index')->with('success', "Utilisateur {$user->name} modifié.");
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        return back()->with('success', $user->is_admin
            ? "{$user->name} est maintenant administrateur."
            : "{$user->name} n'est plus administrateur."
        );
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $nom = $user->name;
        $user->delete();
        return back()->with('success', "Utilisateur {$nom} supprimé.");
    }

    public function destroyPrevision(Prevision $prevision)
    {
        $prevision->delete();
        return back()->with('success', 'Prévision supprimée.');
    }
    public function dashboard()
{
    $stats = [
        'total_users'      => \App\Models\User::count(),
        'total_parcelles'  => \App\Models\Parcelle::count(),
        'total_previsions' => \App\Models\Prevision::count(),
        'total_saisons'    => \App\Models\Saison::count(),
        'avg_rendement'    => round(\App\Models\Prevision::avg('rendement_prevu') ?? 0, 2),
        'admins'           => \App\Models\User::where('is_admin', true)->count(),
    ];

    $previsions_recentes = Prevision::with(['parcelle', 'saison', 'user'])
        ->latest()
        ->limit(10)
        ->get();

    return view('admin.dashboard', compact('stats', 'previsions_recentes'));
}
}