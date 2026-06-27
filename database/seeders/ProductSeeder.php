<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Pre-load category IDs by slug
        $cats = Category::pluck('id', 'slug');

        $products = [

            /* ═══════════════════════════════════════════
               SWEETS
            ═══════════════════════════════════════════ */
            ['category' => 'sweets', 'name' => 'Gulab Jamun Cheesecake',      'price' => 2450, 'sale_price' => null, 'badge' => 'BESTSELLER', 'featured' => true,  'bestseller' => true,  'sort' => 1,
             'short' => 'A dreamy fusion of classic gulab jamun with velvety New York cheesecake.',
             'desc'  => 'Soft, syrup-soaked gulab jamun nestled in a rose-cardamom cheesecake filling on a buttery biscuit base. Garnished with chopped pistachios and edible rose petals.'],
            ['category' => 'sweets', 'name' => 'Saffron Cardamom Cake',        'price' => 3200, 'sale_price' => null, 'badge' => null,          'featured' => true,  'bestseller' => false, 'sort' => 2,
             'short' => 'Fragrant saffron and cardamom baked into a moist, golden celebration cake.',
             'desc'  => 'A three-layer cake infused with premium saffron threads and freshly ground cardamom. Frosted with saffron cream cheese and decorated with silver leaf and slivered almonds.'],
            ['category' => 'sweets', 'name' => 'Pistachio Rose Pastry',        'price' =>  450, 'sale_price' => null, 'badge' => 'NEW',         'featured' => true,  'bestseller' => false, 'sort' => 3,
             'short' => 'Flaky filo layers filled with crushed pistachios and rose-water syrup.',
             'desc'  => 'Hand-rolled filo pastry stuffed with Iranian pistachios, fragrant rose-water syrup, and a hint of orange blossom. Each piece is individually baked to golden perfection.'],
            ['category' => 'sweets', 'name' => 'Nutella Fudge Cake',           'price' => 2800, 'sale_price' => 2400, 'badge' => 'SALE',        'featured' => true,  'bestseller' => true,  'sort' => 4,
             'short' => 'Ultra-rich chocolate sponge layered with whipped Nutella fudge frosting.',
             'desc'  => 'Five layers of dark chocolate sponge sandwiched with a whipped Nutella and cream fudge. Finished with a chocolate mirror glaze and hazelnut crunch.'],
            ['category' => 'sweets', 'name' => 'Halwa Puri Dessert Box',       'price' =>  850, 'sale_price' => null, 'badge' => 'SEASONAL',    'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Traditional Pakistani halwa with crispy sooji puri, packed as a dessert gift box.',
             'desc'  => 'Slow-cooked semolina halwa enriched with ghee, sugar, and dry fruits, served with six freshly fried sooji puris. A nostalgic treat perfect for gifting.'],
            ['category' => 'sweets', 'name' => 'Kheer Brûlée',                 'price' =>  380, 'sale_price' => null, 'badge' => 'NEW',         'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Classic Pakistani rice kheer with a caramelised crème brûlée crust.',
             'desc'  => 'Creamy, slow-cooked basmati rice kheer infused with cardamom, saffron, and toasted almonds. A thin layer of caramelised sugar is torched on top for a satisfying crack.'],
            ['category' => 'sweets', 'name' => 'Barfi Box (Assorted)',          'price' =>  950, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 7,
             'short' => 'Premium assorted barfi — kaju, pista, chocolate, and coconut in one gift box.',
             'desc'  => 'A curated gift box of 16 pieces featuring kaju (cashew) barfi, pista barfi, chocolate barfi, and toasted coconut barfi. Wrapped in traditional packaging.'],
            ['category' => 'sweets', 'name' => 'Shahi Tukray',                 'price' =>  320, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 8,
             'short' => 'Mughal-era royal bread pudding soaked in saffron cream and topped with dry fruits.',
             'desc'  => 'Fried bread pieces soaked in reduced milk (rabri) flavoured with saffron and cardamom, then garnished with pistachios, almonds, and silver leaf. Served chilled.'],

            /* ═══════════════════════════════════════════
               PIZZA
            ═══════════════════════════════════════════ */
            ['category' => 'pizza', 'name' => 'Margherita Pizza',              'price' => 1250, 'sale_price' => null, 'badge' => null,          'featured' => true,  'bestseller' => false, 'sort' => 1,
             'short' => 'San Marzano tomato sauce, fresh mozzarella, and hand-torn basil leaves.',
             'desc'  => 'Our classic Neapolitan-inspired Margherita features a slow-fermented 72-hour dough, San Marzano tomato sauce, imported fior di latte mozzarella, and fresh basil. Baked in a deck oven at 400°C for a perfectly charred crust.'],
            ['category' => 'pizza', 'name' => 'Pepperoni Pizza',               'price' => 1350, 'sale_price' => null, 'badge' => 'HOT',         'featured' => true,  'bestseller' => true,  'sort' => 2,
             'short' => 'Spicy beef pepperoni, mozzarella, and tomato sauce on a crispy thin crust.',
             'desc'  => 'Loaded with premium beef pepperoni that cups and crisps during baking, releasing pools of flavour over a rich tomato base and generous mozzarella.'],
            ['category' => 'pizza', 'name' => 'BBQ Chicken Pizza',             'price' => 1450, 'sale_price' => null, 'badge' => null,          'featured' => true,  'bestseller' => true,  'sort' => 3,
             'short' => 'Grilled chicken, smoky BBQ sauce, red onion, and cilantro.',
             'desc'  => 'Tender grilled chicken marinated in a house-made smoky BBQ sauce, layered over mozzarella with thinly sliced red onion and fresh cilantro. A crowd favourite.'],
            ['category' => 'pizza', 'name' => 'Desi Tikka Pizza',              'price' => 1550, 'sale_price' => null, 'badge' => 'BESTSELLER',  'featured' => false, 'bestseller' => true,  'sort' => 4,
             'short' => 'Chargrilled chicken tikka, green chilli, onion, and mint chutney drizzle.',
             'desc'  => 'A Pakistani-Italian fusion featuring juicy chargrilled chicken tikka chunks, green chillies, caramelised onion, mozzarella, and a post-bake drizzle of house mint chutney. Addictively spicy.'],
            ['category' => 'pizza', 'name' => 'Veggie Supreme Pizza',          'price' => 1150, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Bell peppers, mushrooms, olives, corn, and red onion on a tomato base.',
             'desc'  => 'Piled high with colourful bell peppers, baby mushrooms, black olives, sweet corn, and red onion over a rich tomato sauce and melted mozzarella.'],
            ['category' => 'pizza', 'name' => 'Beef Kheema Pizza',             'price' => 1600, 'sale_price' => null, 'badge' => 'NEW',         'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Spiced minced beef kheema, caramelised onions, and mozzarella.',
             'desc'  => 'Inspired by Pakistani keema naan, this pizza features slow-cooked spiced minced beef with green peas, caramelised onions, and fresh coriander on our signature tomato base.'],
            ['category' => 'pizza', 'name' => 'Cream Cheese & Jalapeño Pizza', 'price' => 1350, 'sale_price' => null, 'badge' => 'HOT',         'featured' => false, 'bestseller' => false, 'sort' => 7,
             'short' => 'Cream cheese base, pickled jalapeños, mozzarella, and chilli honey drizzle.',
             'desc'  => 'A white-sauce pizza with a smooth cream cheese base, generous jalapeño slices, and a post-bake chilli honey drizzle. Sweet, creamy, and fiery all at once.'],
            ['category' => 'pizza', 'name' => 'Pizza Family Deal (2 Large)',   'price' => 2800, 'sale_price' => 2499, 'badge' => 'DEAL',        'featured' => false, 'bestseller' => false, 'sort' => 8,
             'short' => 'Choose any 2 large 12" pizzas from our full menu.',
             'desc'  => 'Pick any two large pizzas from our full menu — mix and match your favourites. Includes 2 dipping sauces and a 1.5L drink. Perfect for family nights.'],

            /* ═══════════════════════════════════════════
               SNACKS
            ═══════════════════════════════════════════ */
            ['category' => 'snacks', 'name' => 'Garlic Breadsticks',           'price' =>  350, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 1,
             'short' => 'Crispy baked breadsticks brushed with garlic butter and herbs.',
             'desc'  => 'Eight hand-rolled breadsticks baked golden and brushed generously with roasted garlic butter, dried oregano, and Parmesan. Served with marinara dipping sauce.'],
            ['category' => 'snacks', 'name' => 'Chicken Puff',                 'price' =>  180, 'sale_price' => null, 'badge' => 'HOT',         'featured' => true,  'bestseller' => true,  'sort' => 2,
             'short' => 'Flaky puff pastry filled with spiced chicken and onion.',
             'desc'  => 'Buttery, multi-layered puff pastry encasing a well-seasoned chicken filling with onion, green chilli, and fresh coriander. Baked fresh every two hours.'],
            ['category' => 'snacks', 'name' => 'Veggie Spring Rolls (6 pcs)',  'price' =>  320, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Crispy rolls filled with seasoned mixed vegetables and glass noodles.',
             'desc'  => 'Six crispy spring rolls stuffed with shredded cabbage, carrots, bell peppers, glass noodles, and Asian-spiced seasoning. Served with sweet chilli sauce.'],
            ['category' => 'snacks', 'name' => 'Samosa (2 pcs)',               'price' =>  120, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 4,
             'short' => 'Classic triangular pastries with a spiced potato and pea filling.',
             'desc'  => 'Crispy hand-folded samosas filled with boiled potatoes, green peas, and fragrant whole spices. Deep-fried to golden perfection and served with mint chutney.'],
            ['category' => 'snacks', 'name' => 'Cheese Sticks (6 pcs)',        'price' =>  420, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Golden fried mozzarella sticks with marinara dipping sauce.',
             'desc'  => 'Jumbo mozzarella sticks coated in seasoned breadcrumbs, fried until the cheese is perfectly molten. Served with a classic marinara sauce.'],
            ['category' => 'snacks', 'name' => 'Loaded Nachos',                'price' =>  650, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Tortilla chips loaded with cheddar, jalapeños, sour cream, and salsa.',
             'desc'  => 'Crispy tortilla chips smothered in melted cheddar sauce, pickled jalapeños, black beans, sour cream, fresh pico de gallo, and sliced avocado. A complete meal in itself.'],

            /* ═══════════════════════════════════════════
               DAIRY
            ═══════════════════════════════════════════ */
            ['category' => 'dairy', 'name' => 'Dahi Bhalla Platter',           'price' =>  350, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 1,
             'short' => 'Soft lentil dumplings in chilled, sweetened yoghurt with tangy chutneys.',
             'desc'  => 'Soft, melt-in-the-mouth urad dal bhallas soaked in chilled beaten yoghurt, drizzled with date tamarind chutney, mint chutney, and sprinkled with chaat masala.'],
            ['category' => 'dairy', 'name' => 'Lassi (Sweet)',                 'price' =>  220, 'sale_price' => null, 'badge' => null,          'featured' => true,  'bestseller' => true,  'sort' => 2,
             'short' => 'Thick, creamy blended yoghurt lassi with a hint of rose water.',
             'desc'  => 'Made fresh from full-fat yoghurt blended until smooth and frothy, sweetened to taste, and finished with a drop of rose water. Served in a traditional clay pot.'],
            ['category' => 'dairy', 'name' => 'Lassi (Salted)',                'price' =>  220, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Savory blended yoghurt lassi with roasted cumin and fresh mint.',
             'desc'  => 'A cooling salted lassi blended with roasted cumin, fresh mint leaves, and a pinch of black salt. Perfect alongside spicy food.'],
            ['category' => 'dairy', 'name' => 'Raita Bowl',                    'price' =>  150, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Chilled yoghurt with cucumber, tomato, onion, and roasted cumin.',
             'desc'  => 'A classic cooling raita with finely diced cucumber, tomato, and onion, seasoned with roasted cumin powder and fresh coriander.'],
            ['category' => 'dairy', 'name' => 'Mango Yoghurt Parfait',         'price' =>  380, 'sale_price' => null, 'badge' => 'SEASONAL',    'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Greek yoghurt layered with fresh Chaunsa mango and honey granola.',
             'desc'  => 'Layers of thick Greek yoghurt, fresh diced Chaunsa mango, wildflower honey, and crunchy house-made granola. A light and satisfying dessert or breakfast.'],

            /* ═══════════════════════════════════════════
               COFFEE & TEA
            ═══════════════════════════════════════════ */
            ['category' => 'coffee-tea', 'name' => 'Doodh Pati Chai',          'price' =>  150, 'sale_price' => null, 'badge' => null,          'featured' => true,  'bestseller' => true,  'sort' => 1,
             'short' => 'Strong, milky Pakistani tea brewed with cardamom and ginger.',
             'desc'  => 'The quintessential Pakistani chai — brewed entirely in whole milk with premium loose-leaf black tea, fresh ginger, green cardamom pods, and a touch of sugar.'],
            ['category' => 'coffee-tea', 'name' => 'Karak Chai',               'price' =>  170, 'sale_price' => null, 'badge' => 'HOT',         'featured' => false, 'bestseller' => true,  'sort' => 2,
             'short' => 'Gulf-style intensely brewed tea with evaporated milk and saffron.',
             'desc'  => 'A rich, deeply brewed karak chai using evaporated milk, a pinch of saffron, and fine black tea. Strong, aromatic, and unapologetically bold.'],
            ['category' => 'coffee-tea', 'name' => 'Cappuccino',               'price' =>  350, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Double espresso with velvety steamed milk and a thick foam crown.',
             'desc'  => 'Made with our house-blend espresso and whole milk steamed to silky perfection. Topped with a generous layer of dry foam and a dusting of cocoa powder.'],
            ['category' => 'coffee-tea', 'name' => 'Caramel Latte',            'price' =>  420, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Espresso, steamed milk, and house-made caramel sauce.',
             'desc'  => 'A velvety latte crafted with double espresso, steamed whole milk, and our house-made caramel sauce. Drizzled with extra caramel on the foam.'],
            ['category' => 'coffee-tea', 'name' => 'Kashmiri Pink Chai',       'price' =>  280, 'sale_price' => null, 'badge' => 'BESTSELLER',  'featured' => true,  'bestseller' => true,  'sort' => 5,
             'short' => 'Traditional Kashmiri noon chai — creamy, pink, and topped with crushed pistachios.',
             'desc'  => 'Brewed from special Kashmiri green tea leaves, cooked in milk until it turns a delicate pink. Finished with a swirl of cream, crushed pistachios, and dried rose petals.'],
            ['category' => 'coffee-tea', 'name' => 'Iced Matcha Latte',        'price' =>  480, 'sale_price' => null, 'badge' => 'NEW',         'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Ceremonial-grade matcha whisked with oat milk over ice.',
             'desc'  => 'Ceremonial-grade Japanese matcha whisked smooth, poured over ice with lightly sweetened oat milk. A vibrant, earthy, and refreshing alternative to coffee.'],
            ['category' => 'coffee-tea', 'name' => 'Masala Chai',              'price' =>  180, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 7,
             'short' => 'Spiced Indian chai with cinnamon, clove, black pepper, and ginger.',
             'desc'  => 'A warming blend of Assam tea brewed in milk with a house spice mix of cinnamon, clove, black pepper, ginger, and star anise. Comforting in every sip.'],

            /* ═══════════════════════════════════════════
               JUICES
            ═══════════════════════════════════════════ */
            ['category' => 'juices', 'name' => 'Fresh Sugarcane Juice',        'price' =>  180, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 1,
             'short' => 'Freshly pressed sugarcane with lemon and ginger. Served over ice.',
             'desc'  => 'Cold-pressed fresh sugarcane with a squeeze of lemon and a slice of ginger. A classic Pakistani street favourite — served chilled and refreshingly sweet.'],
            ['category' => 'juices', 'name' => 'Mango Lassi Smoothie',         'price' =>  320, 'sale_price' => null, 'badge' => 'SEASONAL',    'featured' => true,  'bestseller' => true,  'sort' => 2,
             'short' => 'Blended Chaunsa mango with full-fat yoghurt and a pinch of cardamom.',
             'desc'  => 'Peak-season Chaunsa mangoes blended with chilled full-fat yoghurt, a pinch of cardamom, and just enough sugar to balance the natural sweetness. Thick, indulgent, and tropical.'],
            ['category' => 'juices', 'name' => 'Watermelon Mint Juice',        'price' =>  220, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Fresh watermelon blended with mint and a hint of black salt.',
             'desc'  => 'Chilled fresh watermelon blended smooth with a handful of mint leaves and a pinch of black salt. Light, hydrating, and naturally sweet.'],
            ['category' => 'juices', 'name' => 'Orange & Carrot Detox',        'price' =>  280, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Cold-pressed orange and carrot with ginger and turmeric.',
             'desc'  => 'A vibrant cold-pressed blend of fresh oranges, carrots, ginger, and a small hit of turmeric. Full of vitamins and invigorating flavour.'],
            ['category' => 'juices', 'name' => 'Lemonade (Classic)',           'price' =>  200, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Hand-squeezed lemon with sugar syrup and sparkling water.',
             'desc'  => 'Freshly squeezed lemons combined with house-made simple syrup and chilled sparkling water. Served over ice with a sprig of mint. Simple and perfect.'],
            ['category' => 'juices', 'name' => 'Pomegranate Juice',            'price' =>  350, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Pure cold-pressed pomegranate — no sugar, no water added.',
             'desc'  => 'One hundred percent cold-pressed pomegranate juice — bold, tangy, and naturally rich in antioxidants. Nothing added, nothing removed.'],

            /* ═══════════════════════════════════════════
               SHAKES
            ═══════════════════════════════════════════ */
            ['category' => 'shakes', 'name' => 'Oreo Thick Shake',             'price' =>  420, 'sale_price' => null, 'badge' => 'BESTSELLER',  'featured' => true,  'bestseller' => true,  'sort' => 1,
             'short' => 'Crushed Oreos blended with vanilla ice cream and whole milk.',
             'desc'  => 'A supremely thick shake made from whole Oreo cookies, premium vanilla ice cream, and chilled whole milk. Topped with whipped cream and a whole Oreo.'],
            ['category' => 'shakes', 'name' => 'Strawberry Milkshake',         'price' =>  380, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 2,
             'short' => 'Fresh strawberries blended with vanilla ice cream and milk.',
             'desc'  => 'Fresh seasonal strawberries blended with scoops of vanilla ice cream and cold whole milk. Poured into a chilled glass and topped with whipped cream.'],
            ['category' => 'shakes', 'name' => 'Nutella Banana Shake',         'price' =>  450, 'sale_price' => null, 'badge' => 'HOT',         'featured' => false, 'bestseller' => true,  'sort' => 3,
             'short' => 'Ripe bananas and Nutella blended with vanilla ice cream.',
             'desc'  => 'Two ripe bananas blended with a generous spoonful of Nutella, two scoops of vanilla ice cream, and cold milk. Indulgent, chocolatey, and thick.'],
            ['category' => 'shakes', 'name' => 'Mango Tango Shake',            'price' =>  400, 'sale_price' => null, 'badge' => 'SEASONAL',    'featured' => true,  'bestseller' => false, 'sort' => 4,
             'short' => 'Fresh Chaunsa mango blended with mango sorbet and cream.',
             'desc'  => 'Peak-season Chaunsa mangoes blended with mango sorbet and a splash of fresh cream. Intensely tropical and naturally sweet — mango heaven in a glass.'],
            ['category' => 'shakes', 'name' => 'Chocolate Fudge Shake',        'price' =>  440, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Dark chocolate blended with fudge ice cream and hot fudge drizzle.',
             'desc'  => 'Belgian dark chocolate blended with premium fudge ice cream, finished with a hot fudge drizzle inside the glass. For serious chocolate lovers.'],
            ['category' => 'shakes', 'name' => 'Paan Milkshake',               'price' =>  360, 'sale_price' => null, 'badge' => 'NEW',         'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Unique betel leaf milkshake with gulkand, coconut, and vanilla ice cream.',
             'desc'  => 'A uniquely desi milkshake inspired by the classic meetha paan — blended with fresh betel leaves, gulkand (rose petal preserve), desiccated coconut, and vanilla ice cream.'],

            /* ═══════════════════════════════════════════
               ICE CREAM
            ═══════════════════════════════════════════ */
            ['category' => 'ice-cream', 'name' => 'Kulfi Malai (per piece)',   'price' =>  150, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 1,
             'short' => 'Traditional slow-frozen kulfi with reduced milk and cardamom.',
             'desc'  => 'Slow-frozen traditional kulfi made from slowly reduced full-fat milk, sugar, cardamom, and crushed pistachios. Served on a stick in the classic cone shape.'],
            ['category' => 'ice-cream', 'name' => 'Faluda',                    'price' =>  280, 'sale_price' => null, 'badge' => 'BESTSELLER',  'featured' => true,  'bestseller' => true,  'sort' => 2,
             'short' => 'Classic Pakistani falooda with rose syrup, basil seeds, and vermicelli.',
             'desc'  => 'A beloved Pakistani dessert drink featuring chilled milk, rooh afza, basil seeds (tukhmalanga), thin vermicelli noodles, and a scoop of vanilla ice cream. Served in a tall glass.'],
            ['category' => 'ice-cream', 'name' => 'Brownie Sundae',            'price' =>  480, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Warm chocolate brownie topped with vanilla ice cream and hot fudge.',
             'desc'  => 'A warm, fudgy chocolate brownie served fresh from the oven, topped with two scoops of vanilla bean ice cream, hot fudge sauce, whipped cream, and a cherry.'],
            ['category' => 'ice-cream', 'name' => 'Mango Sorbet',              'price' =>  220, 'sale_price' => null, 'badge' => 'SEASONAL',    'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Dairy-free, pure Chaunsa mango sorbet. No artificial colour or flavour.',
             'desc'  => 'Two scoops of intensely flavoured Chaunsa mango sorbet made with no dairy, no artificial colour, and no flavourings — just pure mango goodness.'],
            ['category' => 'ice-cream', 'name' => 'Waffle Cone (2 Scoops)',    'price' =>  320, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Choose any 2 scoops in a freshly baked waffle cone.',
             'desc'  => 'Pick any two scoops from our daily selection of flavours, served in a freshly baked waffle cone. Ask for today\'s flavours at the counter.'],

            /* ═══════════════════════════════════════════
               SALAD & CHAAT
            ═══════════════════════════════════════════ */
            ['category' => 'salad-chaat', 'name' => 'Fruit Chaat',             'price' =>  280, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 1,
             'short' => 'Seasonal mixed fruits tossed with chaat masala, lemon, and mint.',
             'desc'  => 'A colourful mix of seasonal fruits — apple, banana, guava, orange, pomegranate — tossed with house chaat masala, fresh lemon juice, and dried mint. A refreshing Pakistani classic.'],
            ['category' => 'salad-chaat', 'name' => 'Papri Chaat',             'price' =>  320, 'sale_price' => null, 'badge' => 'HOT',         'featured' => true,  'bestseller' => true,  'sort' => 2,
             'short' => 'Crispy papri, boiled chickpeas, yoghurt, and tangy chutneys.',
             'desc'  => 'Crispy fried papri wafers topped with boiled chickpeas, diced potatoes, chilled beaten yoghurt, date-tamarind chutney, green chutney, and a generous sprinkle of chaat masala.'],
            ['category' => 'salad-chaat', 'name' => 'Aloo Tikki Chaat',        'price' =>  350, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Crispy potato patties on a bed of chickpeas, yoghurt, and chutneys.',
             'desc'  => 'Two crispy aloo tikki patties placed on spiced white chickpeas, drizzled with yoghurt, both chutneys, and finished with chaat masala, sev, and pomegranate seeds.'],
            ['category' => 'salad-chaat', 'name' => 'Caesar Salad',            'price' =>  520, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Romaine, parmesan, house Caesar dressing, and croutons. Grilled chicken optional.',
             'desc'  => 'Crisp romaine hearts tossed in a house-made Caesar dressing, topped with shaved Parmesan, garlic croutons, and cracked black pepper. Add grilled chicken for Rs. 150 extra.'],
            ['category' => 'salad-chaat', 'name' => 'Greek Salad',             'price' =>  480, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Tomato, cucumber, feta, olives, and red onion in herb vinaigrette.',
             'desc'  => 'A generous salad of ripe tomatoes, cucumber, red onion, Kalamata olives, and crumbled feta, dressed with a house herb vinaigrette and dried oregano.'],

            /* ═══════════════════════════════════════════
               FRIED ITEMS
            ═══════════════════════════════════════════ */
            ['category' => 'fried-items', 'name' => 'Crispy Fried Chicken (4 pcs)', 'price' => 780, 'sale_price' => null, 'badge' => 'HOT',   'featured' => true,  'bestseller' => true,  'sort' => 1,
             'short' => 'Southern-style buttermilk-marinated fried chicken. Crispy outside, juicy inside.',
             'desc'  => 'Chicken pieces marinated overnight in buttermilk and spices, coated in a seasoned flour blend, and pressure-fried until shatteringly crispy on the outside and moist within. Served with coleslaw.'],
            ['category' => 'fried-items', 'name' => 'Chicken Nuggets (10 pcs)', 'price' =>  550, 'sale_price' => null, 'badge' => null,         'featured' => false, 'bestseller' => true,  'sort' => 2,
             'short' => 'Tender all-breast chicken nuggets with a seasoned crispy coating.',
             'desc'  => 'Ten bite-sized nuggets made from 100% breast meat, coated in a seasoned breadcrumb crust, and fried golden. Served with your choice of dipping sauce.'],
            ['category' => 'fried-items', 'name' => 'French Fries (Regular)',   'price' =>  250, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 3,
             'short' => 'Golden, crispy shoestring fries seasoned with sea salt.',
             'desc'  => 'Classic shoestring fries made from fresh-cut potatoes, double-fried for maximum crispiness, and seasoned with sea salt. Served with ketchup and mayo.'],
            ['category' => 'fried-items', 'name' => 'Loaded Cheese Fries',     'price' =>  420, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Crispy fries smothered in cheddar sauce, jalapeños, and crispy bacon bits.',
             'desc'  => 'A generous portion of crispy fries drenched in house-made cheddar cheese sauce, sliced jalapeños, and beef bacon bits. The ultimate comfort food upgrade.'],
            ['category' => 'fried-items', 'name' => 'Onion Rings (8 pcs)',     'price' =>  320, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Thick-cut onion rings in a crispy beer-batter coating.',
             'desc'  => 'Eight jumbo onion rings coated in a light, crispy batter seasoned with paprika and garlic. Fried golden and served with ranch dipping sauce.'],
            ['category' => 'fried-items', 'name' => 'Fish & Chips',            'price' =>  680, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Beer-battered fish fillet with golden chips and tartar sauce.',
             'desc'  => 'A thick fillet of fresh basa fish in a light beer batter, fried crispy alongside a generous portion of thick-cut chips. Served with house tartar sauce and a lemon wedge.'],

            /* ═══════════════════════════════════════════
               FAST FOOD
            ═══════════════════════════════════════════ */
            ['category' => 'fast-food', 'name' => 'Classic Beef Burger',       'price' =>  650, 'sale_price' => null, 'badge' => null,          'featured' => true,  'bestseller' => true,  'sort' => 1,
             'short' => 'Hand-pattied beef burger with cheddar, lettuce, tomato, and house sauce.',
             'desc'  => 'A hand-formed 150g beef patty grilled to your liking, stacked with cheddar, crisp lettuce, ripe tomato, sliced onion, pickles, and our house sauce in a toasted brioche bun.'],
            ['category' => 'fast-food', 'name' => 'Chicken Fillet Burger',     'price' =>  580, 'sale_price' => null, 'badge' => 'HOT',         'featured' => false, 'bestseller' => true,  'sort' => 2,
             'short' => 'Crispy fried chicken fillet with spicy mayo and coleslaw in a brioche bun.',
             'desc'  => 'A whole chicken breast fillet coated in our signature crumb, fried crispy, and topped with spicy mayo, shredded coleslaw, and crunchy pickles in a soft brioche bun.'],
            ['category' => 'fast-food', 'name' => 'Desi Masala Burger',        'price' =>  620, 'sale_price' => null, 'badge' => 'NEW',         'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Spiced beef patty with green chutney, fried egg, and chaat masala.',
             'desc'  => 'A desi twist on the classic burger — a spiced beef patty with chopped onion and green chillies, topped with a fried egg, house green chutney, raw onion rings, and chaat masala.'],
            ['category' => 'fast-food', 'name' => 'Club Sandwich',             'price' =>  520, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Triple-decker toasted sandwich with chicken, bacon, egg, lettuce, and tomato.',
             'desc'  => 'A towering triple-decker toasted sandwich with grilled chicken, beef bacon, fried egg, cheddar, crisp lettuce, tomato, and mayo on white or brown bread. Served with fries.'],
            ['category' => 'fast-food', 'name' => 'Shawarma Wrap',             'price' =>  450, 'sale_price' => null, 'badge' => 'BESTSELLER',  'featured' => true,  'bestseller' => true,  'sort' => 5,
             'short' => 'Marinated chicken shawarma with garlic sauce, pickles, and fresh vegetables.',
             'desc'  => 'Slow-marinated chicken shaved from the rotisserie, wrapped in a warm flatbread with house garlic sauce, tahini, fresh tomatoes, pickled turnips, and crunchy lettuce.'],
            ['category' => 'fast-food', 'name' => 'Hot Dog',                   'price' =>  380, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Beef frankfurter in a toasted bun with mustard, ketchup, and fried onions.',
             'desc'  => 'A premium all-beef frankfurter grilled and served in a toasted bun with yellow mustard, ketchup, and sweet caramelised onions. American diner-style.'],

            /* ═══════════════════════════════════════════
               DEALS
            ═══════════════════════════════════════════ */
            ['category' => 'deals', 'name' => 'Family Feast Deal',             'price' => 3999, 'sale_price' => 3499, 'badge' => 'DEAL',        'featured' => true,  'bestseller' => true,  'sort' => 1,
             'short' => '2 large pizzas + 8 pcs chicken + large fries + 1.5L drink.',
             'desc'  => 'The ultimate family meal: two large pizzas of your choice, 8-piece crispy fried chicken, a large portion of fries, and a 1.5L soft drink. Feeds 4 comfortably.'],
            ['category' => 'deals', 'name' => 'Couple Combo',                  'price' => 1899, 'sale_price' => 1599, 'badge' => 'DEAL',        'featured' => false, 'bestseller' => true,  'sort' => 2,
             'short' => '2 burgers + 2 regular fries + 2 drinks.',
             'desc'  => 'Perfect for two — choose any two burgers from our menu, paired with two regular fries and two medium soft drinks. Enjoy together, save together.'],
            ['category' => 'deals', 'name' => 'Chai & Snack Deal',             'price' =>  450, 'sale_price' =>  380, 'badge' => 'DEAL',        'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => '2 cups doodh pati chai + 2 chicken puffs.',
             'desc'  => 'Start your afternoon right — two cups of our signature doodh pati chai paired with two freshly baked chicken puffs. The perfect tea-time treat.'],
            ['category' => 'deals', 'name' => 'Sweet Box Deal',                'price' => 1200, 'sale_price' =>  999, 'badge' => 'DEAL',        'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Assorted barfi box (16 pcs) + 2 gulab jamuns + 2 kheers.',
             'desc'  => 'A curated sweets deal — a 16-piece assorted barfi box, two fresh gulab jamuns, and two individual kheer bowls. Great for gifting or a sweet-table spread.'],
            ['category' => 'deals', 'name' => 'Pizza + Wings Deal',            'price' => 2499, 'sale_price' => 1999, 'badge' => 'HOT DEAL',    'featured' => true,  'bestseller' => false, 'sort' => 5,
             'short' => '1 large pizza + 8 chicken wings + garlic bread + dip.',
             'desc'  => 'One large pizza (any topping), 8 crispy fried chicken wings, a side of garlic breadsticks, and your choice of dipping sauce. A crowd-pleasing combo.'],

            /* ═══════════════════════════════════════════
               BAKERY
            ═══════════════════════════════════════════ */
            ['category' => 'bakery', 'name' => 'Classic Croissant',            'price' =>  320, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 1,
             'short' => 'Hand-laminated, buttery French croissant with 27 flaky layers.',
             'desc'  => 'Our signature croissant is hand-laminated over two days using premium European butter. The result is 27 impossibly flaky layers with a deeply golden, glossy crust and a soft, honeycomb interior.'],
            ['category' => 'bakery', 'name' => 'Pain au Chocolat',             'price' =>  350, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 2,
             'short' => 'Flaky croissant dough wrapped around two batons of dark chocolate.',
             'desc'  => 'The same laminated dough as our croissant, rolled around two thick batons of 64% dark chocolate. Baked until golden, with melted chocolate in every bite.'],
            ['category' => 'bakery', 'name' => 'Sourdough Loaf (500g)',        'price' =>  650, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Open-crumb sourdough made with a 5-year-old starter. Naturally leavened.',
             'desc'  => 'Baked fresh each morning from our 5-year-old starter. This sourdough has a crispy, blistered crust, an airy open crumb, and a complex, mildly tangy flavour. Best eaten on day 1.'],
            ['category' => 'bakery', 'name' => 'Cinnamon Rolls (2 pcs)',       'price' =>  380, 'sale_price' => null, 'badge' => 'NEW',         'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Gooey, pull-apart cinnamon rolls with cream cheese glaze.',
             'desc'  => 'Soft, pillowy cinnamon rolls generously filled with brown sugar and cinnamon, baked until gooey, and finished with a tangy cream cheese glaze while still warm.'],
            ['category' => 'bakery', 'name' => 'Garlic Bread Loaf',            'price' =>  450, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Soft pull-apart bread with roasted garlic butter and mozzarella.',
             'desc'  => 'A soft loaf of white bread sliced into pull-apart portions, each loaded with roasted garlic butter, fresh parsley, and melted mozzarella. Perfect alongside soups and pasta.'],
            ['category' => 'bakery', 'name' => 'Focaccia (Half Loaf)',         'price' =>  480, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Dimpled Italian flatbread with rosemary, sea salt, and olive oil.',
             'desc'  => 'A thick, airy Italian flatbread proved for 24 hours, dimpled by hand, drizzled with extra virgin olive oil, and topped with fresh rosemary and flaky sea salt.'],
            ['category' => 'bakery', 'name' => 'Banana Walnut Muffin',         'price' =>  220, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 7,
             'short' => 'Moist banana muffin with toasted walnuts and a crunchy sugar top.',
             'desc'  => 'Made with over-ripe bananas for intense flavour, packed with toasted walnuts, and finished with a demerara sugar crust that bakes to a satisfying crunch.'],
            ['category' => 'bakery', 'name' => 'Bread Rolls (6 pcs)',          'price' =>  280, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 8,
             'short' => 'Soft, pillowy dinner rolls — perfect for burgers or dipping in soup.',
             'desc'  => 'Six soft, milk-enriched dinner rolls baked fresh and brushed with butter straight from the oven. Lightly golden on top with a cloud-like interior.'],

            /* ═══════════════════════════════════════════
               CAKES
            ═══════════════════════════════════════════ */
            ['category' => 'cakes', 'name' => 'Classic Red Velvet Cake',       'price' => 2800, 'sale_price' => null, 'badge' => null,          'featured' => true,  'bestseller' => true,  'sort' => 1,
             'short' => 'Three-layer red velvet sponge with tangy cream cheese frosting.',
             'desc'  => 'A show-stopping three-layer red velvet cake with a deep cocoa flavour, vivid red crumb, and a generous coating of whipped cream cheese frosting. Decorated with red velvet crumbs.'],
            ['category' => 'cakes', 'name' => 'Chocolate Truffle Cake',        'price' => 3200, 'sale_price' => null, 'badge' => 'BESTSELLER',  'featured' => true,  'bestseller' => true,  'sort' => 2,
             'short' => 'Rich dark chocolate sponge layered with truffle ganache and mirror glaze.',
             'desc'  => 'Four layers of intensely chocolatey sponge sandwiched with a silky dark chocolate truffle ganache, coated in a perfect chocolate mirror glaze, and decorated with gold leaf.'],
            ['category' => 'cakes', 'name' => 'Black Forest Gateau',           'price' =>  2600, 'sale_price' => null, 'badge' => null,         'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'German chocolate cake with whipped cream and morello cherry filling.',
             'desc'  => 'A classic German Schwarzwälder Kirschtorte — layers of light chocolate sponge soaked in kirsch, filled with whipped cream and morello cherries, and decorated with chocolate shavings.'],
            ['category' => 'cakes', 'name' => 'Strawberry Shortcake',          'price' => 2400, 'sale_price' => null, 'badge' => 'SEASONAL',    'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Vanilla sponge with fresh strawberries and diplomat cream.',
             'desc'  => 'Light, airy vanilla sponge layers filled with a lightly sweetened diplomat cream and fresh seasonal strawberries. Topped with whole strawberries and a strawberry glaze.'],
            ['category' => 'cakes', 'name' => 'Lemon Drizzle Cake',            'price' => 1800, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Zesty lemon sponge soaked in lemon syrup and glazed with lemon icing.',
             'desc'  => 'A tangy, moist lemon sponge made with fresh lemon zest, soaked while warm in a lemon syrup, and finished with a sharp lemon glacé icing. Sharp, sweet, and irresistible.'],
            ['category' => 'cakes', 'name' => 'Carrot Walnut Cake',            'price' => 2000, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 6,
             'short' => 'Spiced carrot cake with toasted walnuts and orange cream cheese frosting.',
             'desc'  => 'A warmly spiced carrot cake packed with freshly grated carrot and toasted walnuts, frosted with a light orange-zested cream cheese and decorated with candied walnut halves.'],
            ['category' => 'cakes', 'name' => 'Custom Celebration Cake',       'price' => 4500, 'sale_price' => null, 'badge' => 'ORDER',       'featured' => false, 'bestseller' => false, 'sort' => 7,
             'short' => 'Bespoke cakes designed to your brief. Minimum 48 hours notice required.',
             'desc'  => 'Our bespoke cake service allows you to design your perfect celebration cake. Choose your flavour, size, filling, and decoration. Prices start from Rs. 4,500 — contact us to discuss.'],

            /* ═══════════════════════════════════════════
               PASTRIES
            ═══════════════════════════════════════════ */
            ['category' => 'pastries', 'name' => 'Éclairs (2 pcs)',            'price' =>  320, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => true,  'sort' => 1,
             'short' => 'Choux pastry filled with vanilla crème pâtissière and dipped in dark chocolate.',
             'desc'  => 'Classic French éclairs made from light choux pastry, piped with smooth vanilla crème pâtissière, and topped with a glossy dark chocolate fondant glaze.'],
            ['category' => 'pastries', 'name' => 'Fruit Tart',                 'price' =>  380, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 2,
             'short' => 'Buttery pâte sablée shell filled with crème pâtissière and fresh fruit.',
             'desc'  => 'A crispy, buttery pâte sablée tart shell filled with vanilla crème pâtissière and topped with fresh seasonal fruit — strawberries, kiwi, mandarin, and grapes — finished with an apricot glaze.'],
            ['category' => 'pastries', 'name' => 'Chocolate Mousse Cup',       'price' =>  280, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Airy dark chocolate mousse in an individual serving cup with cocoa crumble.',
             'desc'  => 'A light yet intensely chocolatey mousse made from 70% dark chocolate, folded with whipped cream, served in an individual glass cup, and topped with a cocoa crumble and chocolate curl.'],
            ['category' => 'pastries', 'name' => 'Mille-Feuille',              'price' =>  420, 'sale_price' => null, 'badge' => 'NEW',         'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Layers of puff pastry with vanilla cream and fondant glaze.',
             'desc'  => 'Three layers of feather-light caramelised puff pastry sandwiched with smooth vanilla crème pâtissière and topped with a traditional fondant glaze. A classic French masterpiece.'],
            ['category' => 'pastries', 'name' => 'Almond Danish',              'price' =>  280, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 5,
             'short' => 'Flaky Danish pastry with almond frangipane filling and toasted sliced almonds.',
             'desc'  => 'Buttery laminated Danish dough filled with almond frangipane, baked golden, and finished with a drizzle of vanilla icing and a sprinkle of toasted sliced almonds.'],

            /* ═══════════════════════════════════════════
               BEVERAGES
            ═══════════════════════════════════════════ */
            ['category' => 'beverages', 'name' => 'Soft Drink (Can)',          'price' =>  120, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 1,
             'short' => 'Chilled can — choose from Coke, Pepsi, Sprite, or 7Up.',
             'desc'  => 'Choose your favourite chilled soft drink from our selection: Coca-Cola, Pepsi, Sprite, or 7Up. Served ice-cold.'],
            ['category' => 'beverages', 'name' => 'Mineral Water (500ml)',     'price' =>   80, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 2,
             'short' => 'Chilled 500ml mineral water.',
             'desc'  => 'A 500ml bottle of chilled mineral water. Still or sparkling, your choice.'],
            ['category' => 'beverages', 'name' => 'Rooh Afza Sherbet',         'price' =>  150, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 3,
             'short' => 'Classic Hamdard Rooh Afza diluted with chilled water and a squeeze of lemon.',
             'desc'  => 'The iconic South Asian summer drink — premium Rooh Afza rose sherbet mixed with chilled water and a twist of fresh lemon. Served over ice.'],
            ['category' => 'beverages', 'name' => 'Jaljeera',                  'price' =>  160, 'sale_price' => null, 'badge' => null,          'featured' => false, 'bestseller' => false, 'sort' => 4,
             'short' => 'Tangy cumin-spiced chilled drink with mint and tamarind.',
             'desc'  => 'A refreshing North Indian summer drink made from cumin, dried mint, black salt, tamarind, and lemon. Chilled, tangy, and an excellent digestive.'],
        ];

        foreach ($products as $data) {
            $catId = $cats[$data['category']] ?? null;
            if (!$catId) continue;

            Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'category_id'       => $catId,
                    'name'              => $data['name'],
                    'slug'              => Str::slug($data['name']),
                    'short_description' => $data['short'],
                    'description'       => $data['desc'],
                    'price'             => $data['price'],
                    'sale_price'        => $data['sale_price'],
                    'badge'             => $data['badge'],
                    'is_featured'       => $data['featured'],
                    'is_bestseller'     => $data['bestseller'],
                    'is_active'         => true,
                    'is_available'      => true,
                    'sort_order'        => $data['sort'],
                ]
            );
        }
    }
}
