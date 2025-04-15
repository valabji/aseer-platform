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
            $newUrl = MainHelper::menuLinkGenerator($link);
            
            if ($oldUrl !== $newUrl) {
                $link->update(['url' => $newUrl]);
                $count++;
                $this->line("Updated link: {$link->title} - {$oldUrl} -> {$newUrl}");
            }
        }
        
        $this->info("Updated {$count} menu links successfully.");
        return 0;
    }
} 