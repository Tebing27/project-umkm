<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Translation;

class CleanTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:clean {--dry-run : Simulate the cleanup without deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unused translation records from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning codebase for translation strings...');

        // 1. Scan files
        $directories = [
            resource_path('views'),
            app_path(),
            base_path('routes'),
        ];

        $files = [];
        foreach ($directories as $dir) {
            $files = array_merge($files, File::allFiles($dir));
        }

        // 2. Extract strings
        $activeStrings = [];
        $pattern = "/translate\s*\(\s*['\"]([^'\"]+)['\"]/";

        foreach ($files as $file) {
            $content = File::get($file->getRealPath());
            if (preg_match_all($pattern, $content, $matches)) {
                foreach ($matches[1] as $match) {
                    $activeStrings[] = $match;
                }
            }
        }

        $activeStrings = array_unique($activeStrings);
        $this->info('Found ' . count($activeStrings) . ' unique active translation strings in code.');

        // 3. Fetch DB records
        $dbRecords = Translation::select('id', 'original_text')->get();
        $this->info('Found ' . $dbRecords->count() . ' total records in database.');

        // 4. Identify unused
        $unusedIds = [];
        $unusedTexts = [];

        foreach ($dbRecords as $record) {
            if (!in_array($record->original_text, $activeStrings)) {
                $unusedIds[] = $record->id;
                $unusedTexts[] = $record->original_text;
            }
        }

        $count = count($unusedIds);

        if ($count === 0) {
            $this->info('No unused translations found. Database is clean.');
            return 0;
        }

        $this->table(['ID', 'Unused Text (To be deleted)'], 
            collect($unusedTexts)->map(fn($text, $i) => [$unusedIds[$i], \Illuminate\Support\Str::limit($text, 50)])
        );

        // 5. Delete
        if ($this->option('dry-run')) {
            $this->info("Dry run finished. {$count} records would be deleted.");
        } else {
            if ($this->confirm("Are you sure you want to delete these {$count} records?", true)) {
                Translation::whereIn('id', $unusedIds)->delete();
                $this->info("Deleted {$count} records.");
            } else {
                $this->info('Operation cancelled.');
                return 0; // Exit if cancelled
            }
        }

        // 6. Reorder IDs (Optional Logic)
        // Note: We only do this if records were deleted OR if explicitly requested? 
        // For now, let's ask the user if they want to reorder if it's not a dry run.
        
        if (!$this->option('dry-run') && $count > 0) {
            if ($this->confirm('Do you want to reorder the IDs to be sequential? (Use with caution)', false)) {
                $this->reorderIds();
            }
        }

        return 0;
    }

    protected function reorderIds()
    {
        $this->info('Reordering IDs...');
        
        // Fetch all current records ordered by old ID
        $translations = Translation::orderBy('id')->get();
        
        if ($translations->isEmpty()) {
             // Reset auto increment to 1
             \Illuminate\Support\Facades\DB::statement('ALTER TABLE translations AUTO_INCREMENT = 1');
             $this->info('Table is empty. Auto-increment reset to 1.');
             return;
        }
        
        try {
            \Illuminate\Support\Facades\DB::transaction(function () {
                \Illuminate\Support\Facades\DB::statement('SET @count = 0');
                \Illuminate\Support\Facades\DB::statement('UPDATE translations SET id = @count:= @count + 1 ORDER BY id');
                
                // Reset auto-increment value
                // Get max id
                $maxId = \Illuminate\Support\Facades\DB::table('translations')->max('id');
                $nextId = $maxId + 1;
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE translations AUTO_INCREMENT = $nextId");
            });
            
            $this->info('IDs have been successfully reordered.');
            
        } catch (\Exception $e) {
            $this->error('Failed to reorder IDs: ' . $e->getMessage());
        }
    }
}
