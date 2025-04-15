<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MenuLink;
use App\Helpers\MainHelper;

class UpdateMenuLinksUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:update-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all menu links to use the correct URL format';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating menu links...');
        
        $menuLinks = MenuLink::all();
        $count = 0;
        
        foreach ($menuLinks as $link) {
            $oldUrl = $link->url;
            
            // Special handling for custom links that might be hardcoded
            if ($link->type == "CUSTOM_LINK") {
                // If it's the home page using APP_URL
                if ($oldUrl == env('APP_URL')) {
                    $link->url = url('/');
                    $link->save();
                    $count++;
                    $this->line("Updated home link: {$link->title} - {$oldUrl} -> {$link->url}");
                }
                // If it's a blog link
                elseif (strpos($oldUrl, '/blog') !== false) {
                    $link->url = route('blog');
                    $link->save();
                    $count++;
                    $this->line("Updated blog link: {$link->title} - {$oldUrl} -> {$link->url}");
                }
                // If it's a contact link
                elseif (strpos($oldUrl, '/contact') !== false) {
                    $link->url = route('contact');
                    $link->save();
                    $count++;
                    $this->line("Updated contact link: {$link->title} - {$oldUrl} -> {$link->url}");
                }
                // For other custom links, use the menuLinkGenerator
                else {
                    $newUrl = MainHelper::menuLinkGenerator($link);
                    if ($oldUrl !== $newUrl) {
                        $link->update(['url' => $newUrl]);
                        $count++;
                        $this->line("Updated link: {$link->title} - {$oldUrl} -> {$newUrl}");
                    }
                }
            } 
            // For PAGE and CATEGORY links
            else {
                $newUrl = MainHelper::menuLinkGenerator($link);
                if ($oldUrl !== $newUrl) {
                    $link->update(['url' => $newUrl]);
                    $count++;
                    $this->line("Updated link: {$link->title} - {$oldUrl} -> {$newUrl}");
                }
            }
        }
        
        $this->info("Updated {$count} menu links successfully.");
        return 0;
    }
} 