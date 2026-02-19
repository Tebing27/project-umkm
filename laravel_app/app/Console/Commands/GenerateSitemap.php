<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml and robots.txt files for SEO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $baseUrl = config('app.url');
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        // Added image namespace for Google Image indexing
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . PHP_EOL;
        $xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . PHP_EOL;

        // 1. Static Pages
        $staticPages = [
            '',
            'umkm',
            'login',
            'register',
        ];

        foreach ($staticPages as $page) {
            $xml .= '    <url>' . PHP_EOL;
            $xml .= '        <loc>' . $baseUrl . $page . '</loc>' . PHP_EOL;
            $xml .= '        <changefreq>daily</changefreq>' . PHP_EOL;
            $xml .= '        <priority>0.8</priority>' . PHP_EOL;
            $xml .= '    </url>' . PHP_EOL;
        }

        // 2. Business Types (Entities)
        $this->info('Processing Business Types...');
        $businessTypes = Shop::getBusinessTypes();
        foreach ($businessTypes as $type) {
            // Encode the category parameter for URL
            $url = route('umkm.index', ['category' => $type]);
            
            $xml .= '    <url>' . PHP_EOL;
            $xml .= '        <loc>' . $url . '</loc>' . PHP_EOL;
            $xml .= '        <changefreq>weekly</changefreq>' . PHP_EOL;
            $xml .= '        <priority>0.8</priority>' . PHP_EOL;
            $xml .= '    </url>' . PHP_EOL;
        }

        // 3. Shops
        $this->info('Processing Shops (Limited to latest 500)...');
        // Limit to 500 to prevent timeout on shared hosting
        $shops = Shop::where('is_verified', true)
            ->latest()
            ->take(500)
            ->get();

        foreach ($shops as $shop) {
            $xml .= '    <url>' . PHP_EOL;
            // Using route name 'umkm.comment' based on routes/web.php mapping to 'show'
            $xml .= '        <loc>' . route('umkm.comment', $shop->id) . '</loc>' . PHP_EOL;
            $xml .= '        <lastmod>' . Carbon::parse($shop->updated_at)->toIso8601String() . '</lastmod>' . PHP_EOL;
            $xml .= '        <changefreq>daily</changefreq>' . PHP_EOL;
            $xml .= '        <priority>0.9</priority>' . PHP_EOL;
            $xml .= '    </url>' . PHP_EOL;
        }

        // 4. Products with Image Sitemap Extension for Google Image indexing
        $this->info('Processing Products with Images (Limited to latest 500)...');
        // Limit to 500 to prevent timeout on shared hosting
        // Eager load images relation for image sitemap
        $products = Product::where('is_active', true)
            ->whereHas('shop', function($q){
                $q->where('is_verified', true);
            })
            ->with('images')
            ->latest()
            ->take(500)
            ->get();

        foreach ($products as $product) {
            $xml .= '    <url>' . PHP_EOL;
            $xml .= '        <loc>' . route('umkm.product', $product->id) . '</loc>' . PHP_EOL;
            $xml .= '        <lastmod>' . Carbon::parse($product->updated_at)->toIso8601String() . '</lastmod>' . PHP_EOL;
            $xml .= '        <changefreq>daily</changefreq>' . PHP_EOL;
            $xml .= '        <priority>1.0</priority>' . PHP_EOL;
            
            // Add primary product image for Google Image indexing
            if ($product->image) {
                $imageUrl = storage_url($product->image);
                $xml .= '        <image:image>' . PHP_EOL;
                $xml .= '            <image:loc>' . htmlspecialchars($imageUrl, ENT_XML1, 'UTF-8') . '</image:loc>' . PHP_EOL;
                $xml .= '        </image:image>' . PHP_EOL;
            }
            
            // Add additional product images (max 1000 per URL per Google spec)
            foreach ($product->images as $image) {
                // Skip if same as primary image
                if ($image->image === $product->image) {
                    continue;
                }
                $imageUrl = storage_url($image->image);
                $xml .= '        <image:image>' . PHP_EOL;
                $xml .= '            <image:loc>' . htmlspecialchars($imageUrl, ENT_XML1, 'UTF-8') . '</image:loc>' . PHP_EOL;
                $xml .= '        </image:image>' . PHP_EOL;
            }
            
            $xml .= '    </url>' . PHP_EOL;
        }


        $xml .= '</urlset>';

        File::put(public_path('sitemap.xml'), $xml);
        $this->info('Sitemap generated successfully at public/sitemap.xml');

        // Create robots.txt
        $robotsContent = "User-agent: *\nAllow: /\nSitemap: " . $baseUrl . "sitemap.xml";
        File::put(public_path('robots.txt'), $robotsContent);
        $this->info('Robots.txt generated successfully at public/robots.txt');
    }
}
