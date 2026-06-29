<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        // Categories
        $cats = [
            ['name' => 'Baking Tips',    'slug' => 'baking-tips'],
            ['name' => 'Our Recipes',    'slug' => 'our-recipes'],
            ['name' => 'Sweet Stories',  'slug' => 'sweet-stories'],
            ['name' => 'Behind the Scenes', 'slug' => 'behind-the-scenes'],
        ];
        foreach ($cats as $c) {
            BlogCategory::firstOrCreate(['slug' => $c['slug']], array_merge($c, ['is_active' => true]));
        }

        $catMap = BlogCategory::pluck('id', 'slug');

        // Tags
        $tagNames = ['Pakistani Sweets', 'Baking', 'Cakes', 'Pastry', 'Tips & Tricks', 'Lahore', 'Fusion', 'Healthy', 'Seasonal', 'Kids'];
        foreach ($tagNames as $t) {
            BlogTag::firstOrCreate(['slug' => Str::slug($t)], ['name' => $t, 'slug' => Str::slug($t)]);
        }

        // Posts
        $posts = [
            [
                'title'    => 'The Secret Behind Our Perfectly Flaky Croissants',
                'slug'     => 'secret-behind-flaky-croissants',
                'cat'      => 'baking-tips',
                'excerpt'  => 'Getting a croissant right takes more than a good recipe — it takes patience, cold butter, and a technique passed down through generations.',
                'content'  => '<p>At Azmeer Bakery, our croissants are laminated through 27 layers of pure butter dough. The key is keeping everything cold and working quickly. We rest the dough for 30 minutes between each fold to maintain those beautiful, airy layers.</p><p>The butter must be the same consistency as the dough — too hard and it breaks the layers, too soft and it melts in. We use premium European-style butter with 82% fat content for the richest flavour.</p><h2>Our Process</h2><p>We start at 4 AM every morning, shaping each croissant by hand before the first proof. Two hours later, they go into the oven at 190°C for exactly 18 minutes until deep golden brown.</p>',
                'image'    => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&q=80',
                'featured' => true,
                'tags'     => ['Baking', 'Pastry'],
            ],
            [
                'title'    => 'Why Pakistani Mithai Deserves a Place on Every Table',
                'slug'     => 'pakistani-mithai-deserves-place-on-table',
                'cat'      => 'sweet-stories',
                'excerpt'  => 'From barfi to gulab jamun, traditional Pakistani sweets carry centuries of culture and love in every bite.',
                'content'  => '<p>Mithai is more than dessert in Pakistani culture — it is the language of celebration. Weddings, Eid, a new baby, a promotion — all marked with the exchange of beautifully boxed sweets.</p><p>At Azmeer Bakery, we blend traditional recipes from Lahore\'s old city bazaars with modern presentation. Our kaju katli uses only Kashmiri cashews, ground fine with pure desi ghee and hand-rolled to exactly 2mm thickness.</p>',
                'image'    => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800&q=80',
                'featured' => true,
                'tags'     => ['Pakistani Sweets', 'Fusion'],
            ],
            [
                'title'    => '5 Mistakes Home Bakers Make (and How to Fix Them)',
                'slug'     => '5-mistakes-home-bakers-make',
                'cat'      => 'baking-tips',
                'excerpt'  => 'Even experienced bakers make these common errors. Learn what they are and how our pastry chefs avoid them.',
                'content'  => '<p><strong>1. Not measuring by weight</strong> — Volume measurements vary wildly. Invest in a digital scale; your cakes will thank you.</p><p><strong>2. Opening the oven door too early</strong> — This drops the temperature and causes cakes to sink. Trust the timer.</p><p><strong>3. Using cold eggs</strong> — Always use room-temperature eggs for better emulsification.</p><p><strong>4. Overmixing the batter</strong> — Once flour is added, mix only until just combined. Overmixing develops gluten and makes cakes tough.</p><p><strong>5. Not preheating the oven</strong> — Your oven needs at least 15 minutes to reach stable temperature.</p>',
                'image'    => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=800&q=80',
                'featured' => false,
                'tags'     => ['Baking', 'Tips & Tricks'],
            ],
            [
                'title'    => 'A Day in the Life of Our Head Baker',
                'slug'     => 'day-in-life-of-head-baker',
                'cat'      => 'behind-the-scenes',
                'excerpt'  => 'Usman Khan starts his day at 3:30 AM. By the time Lahore wakes up, hundreds of fresh pastries are already out of the oven.',
                'content'  => '<p>Usman has been baking professionally for 14 years, the last six of them at Azmeer Bakery. His day starts before dawn, mixing the first batch of doughs that need a long, cold fermentation.</p><p>By 6 AM, the bakery smells of butter and cardamom. The first trays of fresh bread come out. By 8 AM, the shop opens and the first customers are already waiting at the door.</p><p>"The best part," Usman says, "is when a customer tastes something and their eyes light up. That reaction — that\'s why I do this."</p>',
                'image'    => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800&q=80',
                'featured' => true,
                'tags'     => ['Baking', 'Lahore'],
            ],
            [
                'title'    => 'How to Make the Perfect Cup of Doodh Pati at Home',
                'slug'     => 'how-to-make-perfect-doodh-pati',
                'cat'      => 'our-recipes',
                'excerpt'  => 'The real Lahori doodh pati has no water — just milk, tea leaves, and patience. Here is our foolproof method.',
                'content'  => '<p>Bring 500ml of full-fat milk to a simmer over medium heat. Add 2 teaspoons of loose-leaf Kenyan tea and stir continuously for 4 minutes as the milk threatens to boil over — keep stirring, that\'s the secret.</p><p>Add sugar to taste (we like 1.5 tsp), strain into warmed cups, and serve immediately with a Marie biscuit on the side.</p><p>The key is constant attention and full-fat milk. Skimmed milk simply does not work for doodh pati.</p>',
                'image'    => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=800&q=80',
                'featured' => false,
                'tags'     => ['Pakistani Sweets', 'Tips & Tricks'],
            ],
            [
                'title'    => 'Eid Specials: What We Bake Every Year for the Celebration',
                'slug'     => 'eid-specials-what-we-bake-every-year',
                'cat'      => 'sweet-stories',
                'excerpt'  => 'Eid is our busiest and most beloved time of year. Here is what goes into preparing thousands of special treats for Lahore.',
                'content'  => '<p>Starting two weeks before Eid, our production triples. The most popular items are our sheer khurma pastry cups — a modern take on the classic dessert, served in flaky tart shells topped with pistachios and dried roses.</p><p>We also make special Eid gift boxes featuring assorted mithai, decorated with edible gold and seasonal flowers. These sell out within hours of pre-orders opening.</p>',
                'image'    => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=800&q=80',
                'featured' => false,
                'tags'     => ['Pakistani Sweets', 'Seasonal'],
            ],
            [
                'title'    => 'The Art of Decorating Wedding Cakes',
                'slug'     => 'art-of-decorating-wedding-cakes',
                'cat'      => 'behind-the-scenes',
                'excerpt'  => 'A three-tier wedding cake takes up to 12 hours to decorate. Our sugar artist walks us through the process.',
                'content'  => '<p>Every wedding cake starts with a detailed consultation. We sketch the design, agree on flavours, and then the real work begins.</p><p>The base tier is always our classic vanilla sponge with fresh cream and lychee filling — a combination that has become a Lahori wedding staple since we introduced it in 2015.</p><p>Hand-piped sugar roses take 20 minutes each. A full cake might have 40 to 60 of them. The final tier is hand-painted with edible gold luster dust under a spotlight to get the finish exactly right.</p>',
                'image'    => 'https://images.unsplash.com/photo-1535254973040-607b474cb50d?w=800&q=80',
                'featured' => false,
                'tags'     => ['Cakes', 'Baking'],
            ],
            [
                'title'    => 'Sourdough in Lahore: Our Journey with Wild Fermentation',
                'slug'     => 'sourdough-lahore-wild-fermentation-journey',
                'cat'      => 'baking-tips',
                'excerpt'  => 'Three years ago we started our first sourdough starter. Today it bakes 200 loaves a week. Here is what we learned.',
                'content'  => '<p>Our starter — affectionately named "Dada Ji" — is three years old. We feed it daily with equal parts flour and water, maintaining it at 25°C in Lahore\'s warm climate.</p><p>The challenges of sourdough in Pakistan are real: summer temperatures can hit 42°C, making fermentation unpredictable. We developed a refrigerator-retard method where shaped loaves rest overnight at 4°C before baking.</p><p>The result is a tangy, open-crumbed loaf with a blistered crust that our customers now swear by.</p>',
                'image'    => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&q=80',
                'featured' => false,
                'tags'     => ['Baking', 'Tips & Tricks'],
            ],
            [
                'title'    => 'Gulab Jamun Cheesecake: Our Most Talked-About Fusion Dessert',
                'slug'     => 'gulab-jamun-cheesecake-fusion-dessert',
                'cat'      => 'our-recipes',
                'excerpt'  => 'It started as an experiment. Now it is the dessert every customer asks about first when they visit Azmeer Bakery.',
                'content'  => '<p>The idea was simple: take the beloved gulab jamun — soft, syrup-soaked milk dumplings — and place them inside a creamy New York-style cheesecake. The result was electric.</p><p>The base is crushed digestive biscuits with desi ghee. The filling is a classic cream cheese batter, baked low and slow. While still warm, we press three full gulab jamuns into the top and let the syrup seep into the filling as it cools overnight.</p>',
                'image'    => 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=800&q=80',
                'featured' => true,
                'tags'     => ['Pakistani Sweets', 'Fusion', 'Cakes'],
            ],
            [
                'title'    => 'Teaching Kids to Bake: Our Weekend Baking Classes',
                'slug'     => 'teaching-kids-to-bake-weekend-classes',
                'cat'      => 'behind-the-scenes',
                'excerpt'  => 'Every Saturday morning, our kitchen fills with little hands covered in flour. Our kids baking programme has been running for two years.',
                'content'  => '<p>The Weekend Bakers programme takes children aged 7 to 14 through the basics of bread, cookies, and simple cakes in a 3-hour hands-on session. Each child leaves with what they made and a recipe card to try at home.</p><p>Classes are kept small — maximum 8 children — so every student gets individual attention. Our baker Zainab leads the sessions with infinite patience and a very good sense of humour about spilled flour.</p><p>To book a spot, contact us through the contact page. Classes fill up quickly, especially during school holidays.</p>',
                'image'    => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
                'featured' => false,
                'tags'     => ['Baking', 'Kids'],
            ],
        ];

        foreach ($posts as $p) {
            $tags = $p['tags'];
            unset($p['tags'], $p['cat_slug']);

            $catSlug = $p['cat'];
            unset($p['cat']);

            $post = BlogPost::firstOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, [
                    'blog_category_id' => $catMap[$catSlug] ?? null,
                    'user_id'          => $admin?->id,
                    'status'           => 'published',
                    'is_active'        => true,
                    'published_at'     => now()->subDays(rand(1, 90)),
                    'meta_title'       => $p['title'],
                    'meta_description' => $p['excerpt'],
                ])
            );

            $tagIds = BlogTag::whereIn('slug', array_map(fn($t) => Str::slug($t), $tags))->pluck('id');
            $post->tags()->syncWithoutDetaching($tagIds);
        }
    }
}
