@extends('layouts.guest')
@section('title', 'Mon Avis - AgriPredict AI')

@push('styles')
<style>
/* ═══════════════════════════════════════════════════════
   PAGE MON AVIS - Styles
   ═══════════════════════════════════════════════════════ */
.star-rating i {
    transition: all 0.15s ease;
    user-select: none;
}
.star-rating i.active {
    color: #fbbf24 !important;
    text-shadow: 0 0 12px rgba(251, 191, 36, 0.5);
}
.star-rating i.hover {
    color: #fcd34d !important;
    transform: scale(1.15);
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25%      { transform: translateX(-8px); }
    75%      { transform: translateX(8px); }
}
.animate-shake { animation: shake 0.4s ease; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-in { animation: fadeIn 0.6s ease-out; }

.review-preview {
    transition: all 0.3s ease;
}
</style>
@endpush

@section('contenu')

<div class="min-h-screen py-16 px-4">
    <div class="max-w-5xl mx-auto">

        {{-- En-tête --}}
        <div class="text-center mb-10 fade-in">
            <a href="{{ url('/') }}#avis" class="inline-flex items-center gap-2 text-white/60 hover:text-white text-sm mb-4 transition">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-3">
                <i class="fas fa-star text-amber-400 mr-2"></i>
                Mon Avis
            </h1>
            <p class="text-white/60 max-w-2xl mx-auto">
                Partagez votre expérience avec AgriPredict AI. Votre retour nous aide à améliorer la plateforme pour tous les agriculteurs béninois.
            </p>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">

            {{-- COLONNE GAUCHE : Formulaire --}}
            <div class="lg:col-span-3 fade-in">
                <div class="glass rounded-3xl p-8">
                    <h2 class="text-2xl font-black text-slate-800 mb-1">
                        <i class="fas fa-pen-to-square text-agri-600 mr-2"></i>
                        <span id="form-title">
                            {{ $myReview ? 'Modifier votre avis' : 'Rédiger votre avis' }}
                        </span>
                    </h2>
                    <p class="text-sm text-slate-500 mb-6">
                        {{ $myReview ? 'Vous pouvez modifier votre avis à tout moment.' : 'Prenez un moment pour partager votre ressenti.' }}
                    </p>

                    <form id="review-form" class="space-y-5">
                        @csrf
                        <input type="hidden" id="form-method" value="{{ $myReview ? 'PUT' : 'POST' }}">

                        {{-- Note étoiles --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">
                                Votre note <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-4">
                                <div class="star-rating flex gap-2" id="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-3xl cursor-pointer text-slate-300"
                                           data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <span class="text-base font-semibold" id="rating-label">
                                    <span class="text-slate-500">Cliquez pour noter</span>
                                </span>
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="{{ $myReview?->rating ?? '' }}">
                            <p class="text-xs text-red-500 mt-2 hidden" id="rating-error">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Veuillez sélectionner une note
                            </p>
                        </div>

                        {{-- Culture --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-seedling text-agri-600 mr-1"></i>
                                Culture concernée
                            </label>
                            <select name="culture" id="culture-select"
                                class="w-full px-4 py-3 bg-white/60 border border-slate-200 rounded-xl focus:ring-2 focus:ring-agri-500 focus:border-transparent outline-none transition">
                                <option value="">-- Aucune / Autre --</option>
                                <option value="Maïs" {{ $myReview?->culture === 'Maïs' ? 'selected' : '' }}>Maïs</option>
                                <option value="Riz" {{ $myReview?->culture === 'Riz' ? 'selected' : '' }}>Riz</option>

                                <option value="Coton" {{ $myReview?->culture === 'Coton' ? 'selected' : '' }}>Coton</option>
                            </select>
                        </div>

                        {{-- Commentaire --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Votre commentaire <span class="text-red-500">*</span>
                            </label>
                            <textarea name="comment" id="comment-input" required minlength="10" maxlength="1000" rows="6"
                                class="w-full px-4 py-3 bg-white/60 border border-slate-200 rounded-xl focus:ring-2 focus:ring-agri-500 focus:border-transparent outline-none transition resize-none"
                                placeholder="Partagez votre expérience avec AgriPredict AI... Qu'avez-vous apprécié ? Qu'est-ce qui pourrait être amélioré ?">{{ $myReview?->comment ?? '' }}</textarea>
                            <div class="flex justify-between mt-1">
                                <p class="text-xs text-slate-400">Minimum 10 caractères</p>
                                <p class="text-xs text-slate-400">
                                    <span id="char-count">{{ strlen($myReview?->comment ?? '') }}</span>/1000
                                </p>
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="submit" id="submit-btn"
                                class="flex-1 px-6 py-3.5 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas {{ $myReview ? 'fa-save' : 'fa-paper-plane' }}"></i>
                                <span>{{ $myReview ? 'Mettre à jour' : 'Publier mon avis' }}</span>
                            </button>

                            @if($myReview)
                                <button type="button" id="delete-btn"
                                    class="px-6 py-3.5 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-trash"></i>
                                    <span>Supprimer</span>
                                </button>
                            @endif
                        </div>

                        {{-- Messages --}}
                        <div id="form-message" class="hidden rounded-xl p-4 text-sm font-medium"></div>
                    </form>
                </div>
            </div>

            {{-- COLONNE DROITE : Preview + Infos --}}
            <div class="lg:col-span-2 space-y-6 fade-in" style="animation-delay: 0.2s">

                {{-- Preview en direct --}}
                <div class="glass rounded-3xl p-6 sticky top-24">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">
                        <i class="fas fa-eye mr-1"></i> Aperçu en direct
                    </h3>

                    <div id="review-preview" class="review-preview">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-agri-400 to-cyan-500 flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-800 mb-1">{{ Auth::user()->name }}</h4>
                                <div class="flex gap-0.5 mb-2" id="preview-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-sm text-slate-300"></i>
                                    @endfor
                                </div>
                                <div id="preview-culture" class="hidden mb-2">
                                    <span class="inline-block px-2 py-0.5 bg-agri-100 text-agri-700 text-xs rounded-full">
                                        <i class="fas fa-seedling mr-1"></i>
                                        <span id="preview-culture-text"></span>
                                    </span>
                                </div>
                                <p class="text-slate-600 text-sm leading-relaxed italic" id="preview-comment">
                                    Votre commentaire apparaîtra ici...
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-5 border-t border-slate-200">
                        <p class="text-xs text-slate-500 text-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            L'aperçu se met à jour en temps réel
                        </p>
                    </div>
                </div>

                {{-- Conseils --}}
                <div class="glass rounded-3xl p-6">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">
                        <i class="fas fa-lightbulb text-amber-500 mr-1"></i> Conseils
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex gap-2">
                            <i class="fas fa-check text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Soyez honnête et constructif</span>
                        </li>
                        <li class="flex gap-2">
                            <i class="fas fa-check text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Parlez de votre expérience concrète</span>
                        </li>
                        <li class="flex gap-2">
                            <i class="fas fa-check text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Mentionnez les fonctionnalités utilisées</span>
                        </li>
                        <li class="flex gap-2">
                            <i class="fas fa-check text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Minimum 10 caractères</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const starContainer = document.getElementById('star-rating');
    const ratingInput   = document.getElementById('rating-input');
    const ratingLabel   = document.getElementById('rating-label');
    const ratingError   = document.getElementById('rating-error');
    const textarea      = document.getElementById('comment-input');
    const charCount     = document.getElementById('char-count');
    const cultureSelect = document.getElementById('culture-select');
    const form          = document.getElementById('review-form');
    const submitBtn     = document.getElementById('submit-btn');
    const deleteBtn     = document.getElementById('delete-btn');
    const messageBox    = document.getElementById('form-message');

    const stars = starContainer.querySelectorAll('i');
    const labels = ['', 'Très déçu', 'Déçu', 'Correct', 'Satisfait', 'Excellent !'];
    const labelColors = ['', 'text-red-500', 'text-orange-500', 'text-amber-500', 'text-agri-500', 'text-agri-600'];

    let currentRating = parseInt(ratingInput.value) || 0;
    let isEditMode = {{ $myReview ? 'true' : 'false' }};

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ── Rendu des étoiles ─────────────────────────────
    function renderStars(value, mode = 'active') {
        stars.forEach((star, idx) => {
            const v = idx + 1;
            star.classList.remove('active', 'hover');
            if (mode === 'hover' && v <= value) {
                star.classList.add('hover');
            } else if (mode === 'active' && v <= value) {
                star.classList.add('active');
            }
        });
    }

    // ── Mise à jour de l'aperçu ───────────────────────
    function updatePreview() {
        const previewStars = document.getElementById('preview-stars');
        previewStars.innerHTML = Array.from({length: 5}, (_, i) =>
            `<i class="fas fa-star text-sm ${i < currentRating ? 'text-amber-400' : 'text-slate-300'}"></i>`
        ).join('');

        const previewComment = document.getElementById('preview-comment');
        previewComment.textContent = textarea.value.trim() || 'Votre commentaire apparaîtra ici...';
        previewComment.classList.toggle('italic', !textarea.value.trim());

        const previewCulture = document.getElementById('preview-culture');
        const previewCultureText = document.getElementById('preview-culture-text');
        if (cultureSelect.value) {
            previewCultureText.textContent = cultureSelect.value;
            previewCulture.classList.remove('hidden');
        } else {
            previewCulture.classList.add('hidden');
        }
    }

    // ── Interactions étoiles ──────────────────────────
    stars.forEach(star => {
        const value = parseInt(star.dataset.value);

        star.addEventListener('mouseenter', () => {
            renderStars(value, 'hover');
            ratingLabel.innerHTML = `<span class="${labelColors[value]}">${labels[value]}</span>`;
        });

        star.addEventListener('mouseleave', () => {
            renderStars(currentRating, 'active');
            ratingLabel.innerHTML = currentRating
                ? `<span class="${labelColors[currentRating]}">${labels[currentRating]}</span>`
                : '<span class="text-slate-500">Cliquez pour noter</span>';
        });

        star.addEventListener('click', () => {
            currentRating = value;
            ratingInput.value = value;
            renderStars(value, 'active');
            ratingLabel.innerHTML = `<span class="${labelColors[value]}">${labels[value]}</span>`;
            ratingError.classList.add('hidden');
            updatePreview();
        });
    });

    // ── Mise à jour en temps réel ─────────────────────
    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
        charCount.classList.toggle('text-red-500', textarea.value.length > 900);
        updatePreview();
    });

    cultureSelect.addEventListener('change', updatePreview);

    // ── Initialisation ────────────────────────────────
    if (currentRating > 0) {
        renderStars(currentRating, 'active');
        ratingLabel.innerHTML = `<span class="${labelColors[currentRating]}">${labels[currentRating]}</span>`;
    }
    updatePreview();

    // ── Soumission ────────────────────────────────────
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!ratingInput.value) {
            ratingError.classList.remove('hidden');
            starContainer.classList.add('animate-shake');
            setTimeout(() => starContainer.classList.remove('animate-shake'), 500);
            return;
        }

        if (textarea.value.trim().length < 10) {
            showMessage('error', 'Le commentaire doit faire au moins 10 caractères.');
            return;
        }

        submitBtn.disabled = true;
        const originalHTML = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Envoi en cours...</span>';

        try {
            const url = '{{ route("reviews.store") }}';
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('rating', ratingInput.value);
            formData.append('comment', textarea.value);
            if (cultureSelect.value) formData.append('culture', cultureSelect.value);

            if (isEditMode) {
                formData.append('_method', 'PUT');
            }

            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const data = await response.json();

            if (data.success) {
                showMessage('success', data.message + ' Redirection vers l\'accueil...');
                setTimeout(() => {
                    window.location.href = '{{ url("/") }}#avis';
                }, 2000);
            } else {
                showMessage('error', data.message || 'Une erreur est survenue.');
            }
        } catch (err) {
            console.error('Erreur:', err);
            showMessage('error', 'Erreur réseau : ' + err.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    });

    // ── Suppression ───────────────────────────────────
    if (deleteBtn) {
        deleteBtn.addEventListener('click', async () => {
            if (!confirm('Êtes-vous sûr de vouloir supprimer votre avis ? Cette action est irréversible.')) {
                return;
            }

            deleteBtn.disabled = true;
            try {
                const response = await fetch('{{ route("reviews.destroy") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ _method: 'DELETE', _token: csrfToken }),
                });

                const data = await response.json();

                if (data.success) {
                    showMessage('success', data.message + ' Redirection...');
                    setTimeout(() => {
                        window.location.href = '{{ url("/") }}#avis';
                    }, 2000);
                } else {
                    showMessage('error', data.message || 'Erreur.');
                    deleteBtn.disabled = false;
                }
            } catch (err) {
                showMessage('error', 'Erreur réseau : ' + err.message);
                deleteBtn.disabled = false;
            }
        });
    }

    // ── Messages ──────────────────────────────────────
    function showMessage(type, text) {
        const classes = type === 'success'
            ? 'bg-agri-100 text-agri-700 border border-agri-300'
            : 'bg-red-100 text-red-700 border border-red-300';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

        messageBox.className = `rounded-xl p-4 text-sm font-medium ${classes}`;
        messageBox.innerHTML = `<i class="fas ${icon} mr-2"></i>${text}`;
        messageBox.classList.remove('hidden');
        messageBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
})();
</script>
@endpush
@endsection