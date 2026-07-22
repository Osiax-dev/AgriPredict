<?php
namespace App\Services;

use App\Models\Notification;
use App\Models\Prevision;
use App\Models\Saison;

class NotificationService
{
    public static function apresPrevision(Prevision $prevision, int $userId): void
    {
        $parcelle = $prevision->parcelle;
        $ndvi     = $prevision->ndvi;
        $rendement= $prevision->rendement_prevu;
        $culture  = $prevision->culture;

        // ✅ Prévision générée
        self::creer($userId, [
            'titre'  => 'Prévision générée avec succès',
            'message'=> "Votre prévision pour {$parcelle->nom} ({$culture}) est prête. Rendement estimé : {$rendement} t/ha.",
            'type'   => 'success',
            'icone'  => 'fa-check-circle',
            'lien'   => '/historique',
        ]);

        // 🔴 NDVI faible
        if ($ndvi < 0.2) {
            self::creer($userId, [
                'titre'  => '🔴 NDVI critique détecté',
                'message'=> "Votre parcelle {$parcelle->nom} a un NDVI de {$ndvi}. Cela indique un sol nu ou une végétation très stressée. Vérifiez l'état de votre parcelle urgemment.",
                'type'   => 'danger',
                'icone'  => 'fa-exclamation-triangle',
                'lien'   => '/historique',
            ]);
        } elseif ($ndvi < 0.4) {
            self::creer($userId, [
                'titre'  => '⚠️ Végétation modérée',
                'message'=> "NDVI de {$ndvi} sur {$parcelle->nom}. Végétation clairsemée détectée. Pensez à vérifier l'irrigation et la fertilisation.",
                'type'   => 'warning',
                'icone'  => 'fa-leaf',
                'lien'   => '/historique',
            ]);
        }

        // ⚠️ Rendement faible
        if ($culture === 'Maïs' && $rendement < 1.0) {
            self::creer($userId, [
                'titre'  => '⚠️ Rendement Maïs faible prévu',
                'message'=> "Rendement prévu de {$rendement} t/ha pour {$parcelle->nom} — en dessous de la moyenne nationale (1.2 t/ha). Consultez les recommandations IA.",
                'type'   => 'warning',
                'icone'  => 'fa-chart-line',
                'lien'   => '/historique',
            ]);
        }

        if ($culture === 'Riz' && $rendement < 2.0) {
            self::creer($userId, [
                'titre'  => '⚠️ Rendement Riz faible prévu',
                'message'=> "Rendement prévu de {$rendement} t/ha pour {$parcelle->nom} — en dessous de la moyenne (2.5 t/ha). Consultez les recommandations IA.",
                'type'   => 'warning',
                'icone'  => 'fa-chart-line',
                'lien'   => '/historique',
            ]);
        }

        // 🌧️ Pluviométrie faible
        if ($prevision->pluviometrie < 10) {
            self::creer($userId, [
                'titre'  => '🌧️ Alerte sécheresse',
                'message'=> "Pluviométrie très faible ({$prevision->pluviometrie} mm) détectée sur votre zone. Prévoyez une irrigation supplémentaire.",
                'type'   => 'danger',
                'icone'  => 'fa-tint-slash',
                'lien'   => '/historique',
            ]);
        }
    }

    public static function alerteSaison(Saison $saison, int $userId): void
    {
        $jours = $saison->joursRestants();

        if ($jours <= 7 && $jours > 0) {
            self::creer($userId, [
                'titre'  => '📅 Saison bientôt terminée',
                'message'=> "Il reste {$jours} jours avant la fin de \"{$saison->nom}\". Pensez à préparer la récolte.",
                'type'   => 'warning',
                'icone'  => 'fa-calendar-times',
                'lien'   => '/listessaisons',
            ]);
        }
    }

    private static function creer(int $userId, array $data): void
    {
        Notification::create([
            'user_id' => $userId,
            'titre'   => $data['titre'],
            'message' => $data['message'],
            'type'    => $data['type'],
            'icone'   => $data['icone'],
            'lien'    => $data['lien'] ?? null,
            'lu'      => false,
        ]);
    }
}