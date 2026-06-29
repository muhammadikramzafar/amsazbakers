<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\RecipeCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $cats = [
            ['name' => 'Breads & Doughs',  'slug' => 'breads-doughs'],
            ['name' => 'Cakes & Pastries', 'slug' => 'cakes-pastries'],
            ['name' => 'Pakistani Sweets', 'slug' => 'pakistani-sweets'],
            ['name' => 'Beverages',        'slug' => 'beverages'],
            ['name' => 'Savoury Bakes',    'slug' => 'savoury-bakes'],
        ];
        foreach ($cats as $c) {
            RecipeCategory::firstOrCreate(['slug' => $c['slug']], array_merge($c, ['is_active' => true]));
        }

        $catMap = RecipeCategory::pluck('id', 'slug');

        $recipes = [
            [
                'title'             => 'Classic Azmeer Croissant',
                'slug'              => 'classic-azmeer-croissant',
                'cat'               => 'breads-doughs',
                'short_description' => 'Buttery, flaky, 27-layer laminated croissants just like the ones in our display case.',
                'featured_image'    => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&q=80',
                'prep_time'         => '2 hours',
                'cook_time'         => '20 mins',
                'total_time'        => '2 hrs 20 mins',
                'servings'          => 12,
                'difficulty'        => 'hard',
                'is_featured'       => true,
                'ingredients'       => "500g bread flour\n10g salt\n80g sugar\n7g instant yeast\n300ml cold milk\n280g European-style butter (82% fat)\n1 egg (for egg wash)",
                'instructions'      => "1. Combine flour, salt, sugar, yeast and cold milk. Mix to a shaggy dough, do not over-knead. Wrap and refrigerate overnight.\n2. Pound butter between parchment into a 20x20cm square. Refrigerate 30 mins.\n3. Roll dough to 40x20cm. Place butter in the centre and fold dough over it. Seal edges.\n4. Roll to 60x20cm. Fold in thirds (letter fold). Refrigerate 30 mins. Repeat 3 times.\n5. Roll to 4mm thickness. Cut triangles. Roll from base to tip to form croissants.\n6. Proof 2 hours at room temperature until puffy.\n7. Brush with egg wash. Bake at 190°C for 18-20 minutes until deep golden.",
                'chef_notes'        => 'The key is keeping everything cold. If butter starts to melt at any stage, put the whole thing back in the fridge for 20 minutes before continuing.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Gulab Jamun',
                'slug'              => 'gulab-jamun-classic',
                'cat'               => 'pakistani-sweets',
                'short_description' => 'Melt-in-the-mouth milk solid dumplings soaked in cardamom and rose-water syrup.',
                'featured_image'    => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800&q=80',
                'prep_time'         => '30 mins',
                'cook_time'         => '30 mins',
                'total_time'        => '1 hour',
                'servings'          => 20,
                'difficulty'        => 'medium',
                'is_featured'       => true,
                'ingredients'       => "250g khoya (mawa)\n3 tbsp plain flour\n1 tsp baking powder\n2 tbsp warm milk\nOil for deep frying\n\nFor syrup:\n400g sugar\n400ml water\n6 cardamom pods, crushed\n1 tbsp rose water\n1 tsp kewra water",
                'instructions'      => "1. Make syrup: dissolve sugar in water with cardamom over medium heat. Simmer 10 mins. Add rose and kewra water. Keep warm.\n2. Crumble khoya into a bowl. Add flour, baking powder and enough warm milk to make a soft, smooth dough.\n3. Divide into 20 equal portions. Roll each into a smooth ball with no cracks.\n4. Heat oil to 150°C (lower than you think). Fry on medium-low heat, stirring constantly, for 8-10 mins until deep brown.\n5. Drain briefly and drop immediately into warm syrup. Soak at least 2 hours before serving.",
                'chef_notes'        => 'Frying temperature is critical. Too hot and they will be raw inside. Keep the oil at 150°C and be patient — they need a full 8 minutes.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Lahori Doodh Pati',
                'slug'              => 'lahori-doodh-pati',
                'cat'               => 'beverages',
                'short_description' => 'The authentic no-water chai of Lahore — just milk, tea, and perfect technique.',
                'featured_image'    => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=800&q=80',
                'prep_time'         => '2 mins',
                'cook_time'         => '8 mins',
                'total_time'        => '10 mins',
                'servings'          => 2,
                'difficulty'        => 'easy',
                'is_featured'       => false,
                'ingredients'       => "500ml full-fat milk\n2 tsp loose-leaf black tea (Kenyan or Assam)\n1.5 tsp sugar (or to taste)\nA pinch of cardamom powder (optional)",
                'instructions'      => "1. Pour milk into a heavy saucepan over medium heat.\n2. When milk begins to simmer (watch carefully!), add the loose-leaf tea and stir.\n3. Stir constantly as the milk rises. Let it almost boil over, then lower the heat.\n4. Repeat this 3-4 times over 5-6 minutes — this is what creates the froth and depth of flavour.\n5. Add sugar and cardamom if using. Stir well.\n6. Strain through a fine sieve into warmed cups and serve immediately.",
                'chef_notes'        => 'Never let the milk actually boil over — just bring it to the edge each time. This repeated rising is the secret to proper doodh pati.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Vanilla Sponge Celebration Cake',
                'slug'              => 'vanilla-sponge-celebration-cake',
                'cat'               => 'cakes-pastries',
                'short_description' => 'Light, moist vanilla sponge with fresh cream and lychee — our signature wedding tier flavour.',
                'featured_image'    => 'https://images.unsplash.com/photo-1535254973040-607b474cb50d?w=800&q=80',
                'prep_time'         => '30 mins',
                'cook_time'         => '35 mins',
                'total_time'        => '1 hr 5 mins',
                'servings'          => 12,
                'difficulty'        => 'medium',
                'is_featured'       => true,
                'ingredients'       => "For sponge:\n250g plain flour\n250g caster sugar\n250g softened butter\n4 large eggs (room temp)\n2 tsp baking powder\n1 tsp vanilla extract\n4 tbsp milk\n\nFor filling:\n400ml double cream, whipped\n1 can lychees, drained and halved\n\nFor topping:\n300ml double cream\n2 tbsp icing sugar",
                'instructions'      => "1. Preheat oven to 170°C. Grease and line two 20cm round tins.\n2. Beat butter and sugar until pale and fluffy (5 minutes).\n3. Add eggs one at a time, beating well after each. Add vanilla.\n4. Fold in flour and baking powder alternating with milk.\n5. Divide between tins. Bake 30-35 mins until a skewer comes out clean. Cool completely.\n6. Spread whipped cream on the bottom layer. Arrange lychees on top.\n7. Place second layer on top. Frost the outside with sweetened whipped cream.\n8. Refrigerate 1 hour before serving.",
                'chef_notes'        => 'Room temperature butter and eggs are non-negotiable for a light sponge. Cold butter will not cream properly and cold eggs will curdle the batter.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Kaju Katli (Cashew Fudge)',
                'slug'              => 'kaju-katli-cashew-fudge',
                'cat'               => 'pakistani-sweets',
                'short_description' => 'The queen of Pakistani mithai — diamond-shaped cashew fudge with a silver leaf finish.',
                'featured_image'    => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=800&q=80',
                'prep_time'         => '20 mins',
                'cook_time'         => '20 mins',
                'total_time'        => '40 mins + 1 hr chilling',
                'servings'          => 30,
                'difficulty'        => 'medium',
                'is_featured'       => false,
                'ingredients'       => "250g raw cashew nuts (unsalted)\n125g sugar\n60ml water\n1 tsp cardamom powder\n1 tsp ghee\nEdible silver leaf (varq) to finish",
                'instructions'      => "1. Grind cashews to a fine powder in a dry blender. Do not over-blend or it becomes oily.\n2. Make sugar syrup: boil sugar and water to single-thread consistency (107°C).\n3. Add cashew powder to syrup off the heat. Mix quickly and thoroughly.\n4. Return to very low heat. Add cardamom and ghee. Stir 3-4 minutes until it leaves the sides of the pan.\n5. Turn out onto greased parchment. When cool enough to handle, knead briefly until smooth.\n6. Roll to 4-5mm thickness. Apply silver leaf if using.\n7. Cut into diamonds. Refrigerate 1 hour before serving.",
                'chef_notes'        => 'The cashew powder must be completely dry. Any moisture will make the katli grainy. If the mixture becomes too dry, add a teaspoon of warm milk.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Aloo Samosa (Baked Version)',
                'slug'              => 'baked-aloo-samosa',
                'cat'               => 'savoury-bakes',
                'short_description' => 'Crispy, spiced potato samosas baked (not fried) to reduce guilt but not flavour.',
                'featured_image'    => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800&q=80',
                'prep_time'         => '45 mins',
                'cook_time'         => '25 mins',
                'total_time'        => '1 hr 10 mins',
                'servings'          => 16,
                'difficulty'        => 'medium',
                'is_featured'       => false,
                'ingredients'       => "For pastry:\n300g plain flour\n1 tsp ajwain seeds\n1 tsp salt\n4 tbsp vegetable oil\n120ml warm water\n\nFor filling:\n4 medium potatoes, boiled and mashed\n1 cup frozen peas\n1 tsp cumin seeds\n1 tsp coriander powder\n0.5 tsp red chilli powder\n1 tsp garam masala\n2 tbsp fresh coriander\nSalt to taste\n1 tbsp oil",
                'instructions'      => "1. Rub oil into flour with ajwain and salt until breadcrumb texture. Add water gradually to form a stiff dough. Rest 30 mins.\n2. Fry cumin seeds in oil. Add peas, cook 2 mins. Add mashed potato and all spices. Mix well. Cool.\n3. Divide dough into 8 balls. Roll each into an oval, cut in half.\n4. Form each half into a cone, fill with 2 tbsp filling, seal with water.\n5. Brush with oil. Bake at 200°C for 20-25 mins, turning once, until golden and crisp.",
                'chef_notes'        => 'Brush generously with oil before baking and again halfway through. The oil is what creates the characteristic crispy texture without deep-frying.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Sourdough Country Loaf',
                'slug'              => 'sourdough-country-loaf',
                'cat'               => 'breads-doughs',
                'short_description' => 'Open-crumbed, blistered-crust sourdough using our three-year-old Lahori starter.',
                'featured_image'    => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&q=80',
                'prep_time'         => '30 mins',
                'cook_time'         => '45 mins',
                'total_time'        => '24 hours',
                'servings'          => 8,
                'difficulty'        => 'hard',
                'is_featured'       => true,
                'ingredients'       => "450g bread flour\n50g wholemeal flour\n375ml water (80% hydration)\n100g active sourdough starter (100% hydration)\n10g salt",
                'instructions'      => "1. Mix flours and 350ml water. Rest 1 hour (autolyse).\n2. Add starter and remaining water. Mix well. Rest 30 mins.\n3. Add salt. Stretch and fold every 30 mins, 4 times total. Bulk ferment 4-6 hours at 24°C.\n4. Shape into a tight boule. Place seam-up in a floured banneton.\n5. Refrigerate overnight (8-12 hours).\n6. Preheat Dutch oven at 250°C for 45 mins.\n7. Score the loaf and bake covered 20 mins. Remove lid, reduce to 220°C, bake 25 more mins.\n8. Cool on a rack at least 1 hour before cutting.",
                'chef_notes'        => 'In Lahore\'s warm climate, fermentation moves faster. Watch the dough, not the clock — it should be airy and jiggle when shaken before you shape it.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Chocolate Fondant (Lava Cake)',
                'slug'              => 'chocolate-fondant-lava-cake',
                'cat'               => 'cakes-pastries',
                'short_description' => 'Rich dark chocolate cakes with a molten centre — our most popular dessert on the menu.',
                'featured_image'    => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&q=80',
                'prep_time'         => '15 mins',
                'cook_time'         => '12 mins',
                'total_time'        => '27 mins',
                'servings'          => 6,
                'difficulty'        => 'medium',
                'is_featured'       => true,
                'ingredients'       => "200g dark chocolate (70%)\n150g unsalted butter\n4 eggs\n4 egg yolks\n150g icing sugar\n60g plain flour\nPinch of salt\nCocoa powder for dusting",
                'instructions'      => "1. Preheat oven to 200°C. Grease 6 ramekins, dust with cocoa powder.\n2. Melt chocolate and butter together (bain-marie or microwave in 30-sec bursts). Cool slightly.\n3. Whisk eggs, yolks and icing sugar until pale and ribbony (3-4 minutes).\n4. Fold chocolate mixture into egg mixture. Fold in flour and salt.\n5. Divide between ramekins. Can be refrigerated up to 24 hours at this stage.\n6. Bake 10-12 mins — the edges should be set but the centre should wobble.\n7. Rest 1 minute. Run a knife around the edge and invert onto plates. Serve immediately.",
                'chef_notes'        => 'Timing is everything. 10 minutes gives a very liquid centre, 12 minutes gives a fudgy centre. Do a test one first to calibrate your oven.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Sheer Khurma',
                'slug'              => 'sheer-khurma-eid-special',
                'cat'               => 'pakistani-sweets',
                'short_description' => 'The beloved Eid morning dessert — vermicelli simmered in sweetened milk with dates and dried fruits.',
                'featured_image'    => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=800&q=80',
                'prep_time'         => '10 mins',
                'cook_time'         => '25 mins',
                'total_time'        => '35 mins',
                'servings'          => 8,
                'difficulty'        => 'easy',
                'is_featured'       => false,
                'ingredients'       => "1 litre full-fat milk\n100g seviyan (roasted vermicelli)\n3 tbsp ghee\n4 tbsp sugar\n8 dates, pitted and sliced\n2 tbsp raisins\n2 tbsp sliced almonds\n2 tbsp pistachios\n1 tsp cardamom powder\n0.5 tsp kewra water",
                'instructions'      => "1. Heat ghee in a heavy pan. Fry vermicelli until golden brown.\n2. Add dates and raisins, fry 1 minute.\n3. Pour in milk and bring to a gentle simmer, stirring frequently.\n4. Add sugar, cardamom. Simmer 15 minutes until slightly thickened.\n5. Add kewra water. Simmer 5 more minutes.\n6. Garnish with almonds and pistachios. Serve warm or chilled.",
                'chef_notes'        => 'Sheer khurma thickens considerably as it cools. If serving chilled, thin it with a splash of cold milk just before serving.',
                'status'            => 'published',
            ],
            [
                'title'             => 'Cheese & Herb Pull-Apart Bread',
                'slug'              => 'cheese-herb-pull-apart-bread',
                'cat'               => 'savoury-bakes',
                'short_description' => 'Golden, fluffy pull-apart rolls stuffed with mozzarella, garlic butter, and fresh herbs.',
                'featured_image'    => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?w=800&q=80',
                'prep_time'         => '1 hour 30 mins',
                'cook_time'         => '30 mins',
                'total_time'        => '2 hours',
                'servings'          => 12,
                'difficulty'        => 'medium',
                'is_featured'       => false,
                'ingredients'       => "500g bread flour\n7g instant yeast\n10g salt\n30g sugar\n60g softened butter\n2 eggs\n200ml warm milk\n\nFor filling:\n100g butter, melted\n4 cloves garlic, minced\n2 tbsp fresh parsley, chopped\n200g mozzarella, grated\n50g cheddar, grated",
                'instructions'      => "1. Mix flour, yeast, salt, sugar. Add butter, eggs and warm milk. Knead 10 minutes until smooth.\n2. Prove 1 hour until doubled.\n3. Mix melted butter, garlic and parsley for the filling.\n4. Roll dough into a 40x30cm rectangle. Brush with garlic butter, scatter cheese all over.\n5. Roll into a tight log. Slice into 12 equal rounds.\n6. Arrange cut-side up in a greased 23cm round tin, slightly touching.\n7. Prove 45 mins until puffy. Brush tops with remaining garlic butter.\n8. Bake at 180°C for 25-30 minutes until golden. Serve warm.",
                'chef_notes'        => 'Do not overbake — pull them out when just golden. The residual heat will finish cooking the centres and keep the cheese melted.',
                'status'            => 'published',
            ],
        ];

        foreach ($recipes as $r) {
            $catSlug = $r['cat'];
            unset($r['cat']);

            Recipe::firstOrCreate(
                ['slug' => $r['slug']],
                array_merge($r, [
                    'recipe_category_id' => $catMap[$catSlug] ?? null,
                    'is_active'          => true,
                    'published_at'       => now()->subDays(rand(1, 60)),
                    'meta_title'         => $r['title'],
                    'meta_description'   => $r['short_description'],
                ])
            );
        }
    }
}
