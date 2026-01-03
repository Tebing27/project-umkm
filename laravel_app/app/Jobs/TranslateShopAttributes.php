<?php

namespace App\Jobs;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateShopAttributes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shop;

    /**
     * Create a new job instance.
     */
    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fields to translate
        $fieldsToTranslate = [
            // 'product_type',
            // 'business_type',
            // 'shop_name', 
            'description',
        ];

        foreach ($fieldsToTranslate as $field) {
            $value = $this->shop->{$field};
            
            if (!empty($value)) {
                // Call translate helper which uses TranslationService
                // This handles checking DB, calling API, and saving to DB.
                // We default to 'en' as target for now.
                translate($value, 'en');
            }
        }
    }
}
