<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\SitemapService;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
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
    protected $description = 'Generate and update the static XML sitemap for SEO';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating XML Sitemap...');

        $result = SitemapService::generateFile();

        $this->info("Sitemap successfully generated at: {$result['file_path']}");
        $this->info("Total URLs: {$result['total_urls']}");
        $this->info("File Size: {$result['file_size']}");
        $this->info("Generated At: {$result['last_generated_at']}");

        return Command::SUCCESS;
    }
}
