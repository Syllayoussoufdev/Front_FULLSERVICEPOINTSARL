<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Article;
use App\Models\ServicePole;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Utilisateurs Administrateurs (Hachage sécurisé bcrypt)
        User::updateOrCreate(
            ['email' => 'admin@fullservicepoint.ci'],
            [
                'name' => 'M. Narcisse KRA',
                'password' => Hash::make('Admin2026@FSP'),
                'role' => 'admin',
                'title' => 'Président Directeur Général',
                'phone' => '+225 07 68 97 84 42',
                'avatar' => 'images/profil/profil1.png',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'fullservicepoint@gmail.com'],
            [
                'name' => 'Direction Générale (Alias)',
                'password' => Hash::make('Admin2026@FSP'),
                'role' => 'admin',
                'title' => 'Direction Générale FSP',
                'phone' => '+225 27 24 37 15 77',
                'avatar' => 'images/profil/profil1.png',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'berenger.koue@fullservicepoint.ci'],
            [
                'name' => 'M. Bérenger KOUE',
                'password' => Hash::make('Editeur2026@FSP'),
                'role' => 'editor',
                'title' => 'Directeur des Opérations',
                'phone' => '+225 05 45 25 60 07',
                'avatar' => 'images/profil/profil3.png',
                'is_active' => true,
            ]
        );

        // 2. Les 6 Pôles Métiers Stratégiques
        $poles = [
            [
                'code' => 'hva',
                'title' => 'Hydraulique Villageoise Améliorée (HVA)',
                'short_desc' => 'Adduction d\'eau potable, forages profonds, châteaux d\'eau et réseaux de distribution.',
                'icon' => 'droplets',
                'image' => 'images/projets/hva1.png',
                'order' => 1,
            ],
            [
                'code' => 'btp',
                'title' => 'Bâtiment & Travaux Publics (BTP)',
                'short_desc' => 'Génie civil, terrassement, voiries et construction d\'infrastructures durables.',
                'icon' => 'hard-hat',
                'image' => 'images/projets/btp1.png',
                'order' => 2,
            ],
            [
                'code' => 'securite',
                'title' => 'Sécurité Privée & Gardiennage',
                'short_desc' => 'Protection de sites industriels, surveillance physique, patrouilles et audits de sûreté.',
                'icon' => 'shield',
                'image' => 'images/projets/securite1.png',
                'order' => 3,
            ],
            [
                'code' => 'transport',
                'title' => 'Transport & Logistique de Fret',
                'short_desc' => 'Acheminement sécurisé de marchandises lourdes, gestion de flotte et fret routier.',
                'icon' => 'truck',
                'image' => 'images/projets/transport1.png',
                'order' => 4,
            ],
            [
                'code' => 'auto-ecole',
                'title' => 'Auto-École Professionnelle',
                'short_desc' => 'Formation qualifiante aux permis toutes catégories (A, B, C, D, E) et sécurité routière.',
                'icon' => 'car',
                'image' => 'images/projets/autoecole1.png',
                'order' => 5,
            ],
            [
                'code' => 'microfinance',
                'title' => 'Microfinance & Appui Économique (FUFINAP)',
                'short_desc' => 'Solutions de micro-crédits, épargne solidaire et financement inclusif de projets locaux.',
                'icon' => 'coins',
                'image' => 'images/projets/microfinance1.png',
                'order' => 6,
            ],
        ];

        foreach ($poles as $pole) {
            ServicePole::updateOrCreate(['code' => $pole['code']], $pole);
        }

        // 3. Articles Initiaux du Blog
        Article::updateOrCreate(
            ['slug' => 'extension-des-activites-reunion-eau-potable'],
            [
                'title' => 'Extension des activités : Réunion au sommet pour l\'accès à l\'eau potable',
                'category' => 'Stratégie & HVA',
                'excerpt' => 'Compte-rendu de la concertation de haut niveau tenue avec la direction pour accélérer les chantiers d\'adduction d\'eau potable en Côte d\'Ivoire.',
                'content' => 'Sous la conduite de M. Narcisse KRA (PDG) et M. Bérenger KOUE, la direction générale a posé les jalons du plan quinquennal de desserte en eau.',
                'image' => 'images/projets/hva1.png',
                'author' => 'M. Narcisse KRA',
                'status' => 'published',
                'published_at' => '2026-08-04',
            ]
        );

        Article::updateOrCreate(
            ['slug' => 'financement-hva-partenariats-public-prive'],
            [
                'title' => 'Modèle de Financement Innovant des Réseaux HVA',
                'category' => 'Ingénierie Financière',
                'excerpt' => 'Comment FSP SARL structure des mécanismes de financement mixte pour garantir la viabilité pérenne des forages et châteaux d\'eau en milieu périurbain.',
                'content' => 'L\'accès à l\'eau potable exige des modèles économiques résilients. FSP SARL allie rigueur technique et montage financier sécurisé.',
                'image' => 'images/projets/btp1.png',
                'author' => 'Mme Marie Rose KOUAO',
                'status' => 'published',
                'published_at' => '2026-07-22',
            ]
        );

        // 4. Paramètres de Référencement & Identité du Site
        $settings = [
            'site_title' => 'Full Service Point SARL | BTP, Hydraulique HVA & Sécurité Côte d\'Ivoire',
            'meta_description' => 'Entreprise ivoirienne de référence : Hydraulique Villageoise Améliorée (HVA), BTP, Sécurité Privée, Transport et Microfinance.',
            'ga_measurement_id' => 'G-FSP2026CI',
            'contact_email' => 'fullservicepoint@gmail.com',
            'contact_phone_primary' => '+225 27 24 37 15 77',
            'contact_phone_mobile' => '+225 07 68 97 84 42',
            'address' => 'Yopougon, Abidjan, Côte d\'Ivoire',
            'rccm' => 'CI-ABJ-03-2023-B12-01377',
            'capital_social' => '5 000 000 FCFA',
        ];

        foreach ($settings as $key => $val) {
            DB::table('site_settings')->updateOrInsert(['key' => $key], ['value' => $val]);
        }
    }
}
