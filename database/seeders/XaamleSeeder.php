<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\AuthorFollow;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class XaamleSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Utilisateurs
        |--------------------------------------------------------------------------
        */

        $users = [
            User::create([
                'name' => 'Abdoulaye Diop',
                'email' => 'abdoulaye@xaamle.test',
                'password' => Hash::make('password'),
                'bio' => 'Développeur web passionné par Laravel, les nouvelles technologies et le partage de connaissances.',
                'email_verified_at' => now(),
            ]),

            User::create([
                'name' => 'Aminata Fall',
                'email' => 'aminata@xaamle.test',
                'password' => Hash::make('password'),
                'bio' => 'Passionnée par l’éducation, la culture et les initiatives qui rapprochent les communautés.',
                'email_verified_at' => now(),
            ]),

            User::create([
                'name' => 'Moussa Ndiaye',
                'email' => 'moussa@xaamle.test',
                'password' => Hash::make('password'),
                'bio' => 'Entrepreneuriat, innovation et transformation digitale.',
                'email_verified_at' => now(),
            ]),

            User::create([
                'name' => 'Fatou Sarr',
                'email' => 'fatou@xaamle.test',
                'password' => Hash::make('password'),
                'bio' => 'J’aime écrire, apprendre et partager des expériences utiles.',
                'email_verified_at' => now(),
            ]),
        ];

        $abdoulaye = $users[0];
        $aminata = $users[1];
        $moussa = $users[2];
        $fatou = $users[3];


        /*
        |--------------------------------------------------------------------------
        | Publications
        |--------------------------------------------------------------------------
        */

        $posts = [];

        $posts[] = Post::create([
            'user_id' => $abdoulaye->id,
            'title' => 'Pourquoi le partage de connaissances est essentiel',
            'slug' => 'pourquoi-le-partage-de-connaissances-est-essentiel',
            'excerpt' => 'Partager ce que nous savons permet de faire grandir toute une communauté.',
            'content' => <<<TEXT
Le savoir prend toute sa valeur lorsqu’il est partagé.

Dans le monde numérique, nous avons accès à une quantité incroyable d’informations. Pourtant, trouver une information claire, utile et adaptée à notre contexte reste parfois difficile.

C’est justement pour cela que le partage de connaissances est important.

Chaque expérience peut aider quelqu’un d’autre à éviter une erreur, à apprendre plus rapidement ou simplement à découvrir une nouvelle façon de faire.

Avec Xaamlé, l’objectif est simple : créer un espace où chacun peut apprendre, partager et échanger.

Parce que faire savoir, c’est aussi faire grandir.
TEXT,
            'status' => 'published',
            'published_at' => now()->subDays(5),
        ]);

        $posts[] = Post::create([
            'user_id' => $aminata->id,
            'title' => 'L’importance de la lecture à l’ère du numérique',
            'slug' => 'importance-de-la-lecture-a-lere-du-numerique',
            'excerpt' => 'Malgré les écrans et les réseaux sociaux, la lecture reste un formidable outil d’apprentissage.',
            'content' => <<<TEXT
Nous vivons dans un monde où l’information est disponible en quelques secondes.

Pourtant, prendre le temps de lire reste une habitude précieuse.

La lecture permet de développer notre capacité de réflexion, d’enrichir notre vocabulaire et surtout de prendre du recul face aux informations que nous recevons chaque jour.

Lire quelques pages chaque jour peut déjà faire une grande différence.

Le numérique ne doit pas remplacer la lecture. Il peut au contraire devenir un moyen supplémentaire de découvrir des livres, des articles et de nouvelles connaissances.
TEXT,
            'status' => 'published',
            'published_at' => now()->subDays(4),
        ]);

        $posts[] = Post::create([
            'user_id' => $moussa->id,
            'title' => 'Créer un projet numérique : par où commencer ?',
            'slug' => 'creer-un-projet-numerique-par-ou-commencer',
            'excerpt' => 'Quelques étapes simples pour passer d’une idée à un véritable projet.',
            'content' => <<<TEXT
Avoir une idée est le début de toute aventure.

Mais transformer cette idée en projet demande de la méthode.

La première étape consiste à définir clairement le problème que l’on souhaite résoudre.

Ensuite, il faut identifier les utilisateurs concernés, définir les fonctionnalités essentielles et construire une première version simple.

Il n’est pas nécessaire de tout développer dès le départ.

Commencer petit, tester et améliorer progressivement permet souvent de construire un produit beaucoup plus pertinent.
TEXT,
            'status' => 'published',
            'published_at' => now()->subDays(3),
        ]);

        $posts[] = Post::create([
            'user_id' => $fatou->id,
            'title' => 'Apprendre une nouvelle compétence chaque jour',
            'slug' => 'apprendre-une-nouvelle-competence-chaque-jour',
            'excerpt' => 'La progression ne vient pas toujours des grands changements, mais surtout de petites habitudes régulières.',
            'content' => <<<TEXT
Apprendre quelque chose de nouveau chaque jour peut sembler insignifiant.

Mais sur plusieurs mois, ces petits apprentissages deviennent une véritable progression.

Cela peut être quelques lignes de code, quelques pages d’un livre, une nouvelle notion ou simplement une conversation avec quelqu’un qui possède une expérience différente.

La régularité est souvent plus importante que la vitesse.

Il vaut mieux apprendre un peu chaque jour que vouloir tout maîtriser en une seule fois.
TEXT,
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);

        $posts[] = Post::create([
            'user_id' => $abdoulaye->id,
            'title' => 'Construire une communauté autour du savoir',
            'slug' => 'construire-une-communaute-autour-du-savoir',
            'excerpt' => 'Une communauté devient plus forte lorsque ses membres partagent leurs expériences.',
            'content' => <<<TEXT
Une communauté ne se construit pas uniquement autour d’un outil.

Elle se construit autour des personnes, des échanges et des expériences partagées.

Chacun possède quelque chose à transmettre.

Un développeur peut partager une solution technique. Un étudiant peut raconter son expérience. Un entrepreneur peut expliquer une difficulté rencontrée.

C’est cette diversité qui rend une communauté intéressante.

Xaamlé veut justement encourager cette dynamique.
TEXT,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $post = $posts[0];


        /*
        |--------------------------------------------------------------------------
        | Commentaires
        |--------------------------------------------------------------------------
        */

        $comment1 = Comment::create([
            'user_id' => $aminata->id,
            'post_id' => $post->id,
            'content' => 'Très intéressant. Le partage d’expérience est effectivement essentiel.',
        ]);

        $comment2 = Comment::create([
            'user_id' => $moussa->id,
            'post_id' => $post->id,
            'content' => 'Je suis totalement d’accord. Une bonne communauté peut vraiment accélérer l’apprentissage.',
        ]);

        Comment::create([
            'user_id' => $fatou->id,
            'post_id' => $post->id,
            'parent_id' => $comment1->id,
            'content' => 'Exactement ! Et chacun peut apporter quelque chose, même avec une petite expérience.',
        ]);

        Comment::create([
            'user_id' => $abdoulaye->id,
            'post_id' => $post->id,
            'parent_id' => $comment2->id,
            'content' => 'Merci pour ton retour. C’est exactement l’esprit que nous voulons développer avec Xaamlé.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Likes
        |--------------------------------------------------------------------------
        */

        Like::create([
            'user_id' => $aminata->id,
            'post_id' => $post->id,
        ]);

        Like::create([
            'user_id' => $moussa->id,
            'post_id' => $post->id,
        ]);

        Like::create([
            'user_id' => $fatou->id,
            'post_id' => $post->id,
        ]);

        Like::create([
            'user_id' => $abdoulaye->id,
            'post_id' => $posts[1]->id,
        ]);

        Like::create([
            'user_id' => $moussa->id,
            'post_id' => $posts[1]->id,
        ]);

        Like::create([
            'user_id' => $aminata->id,
            'post_id' => $posts[2]->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Abonnements
        |--------------------------------------------------------------------------
        */

        AuthorFollow::create([
            'follower_id' => $aminata->id,
            'author_id' => $abdoulaye->id,
        ]);

        AuthorFollow::create([
            'follower_id' => $moussa->id,
            'author_id' => $abdoulaye->id,
        ]);

        AuthorFollow::create([
            'follower_id' => $fatou->id,
            'author_id' => $abdoulaye->id,
        ]);

        AuthorFollow::create([
            'follower_id' => $abdoulaye->id,
            'author_id' => $aminata->id,
        ]);

        AuthorFollow::create([
            'follower_id' => $moussa->id,
            'author_id' => $aminata->id,
        ]);
    }
}