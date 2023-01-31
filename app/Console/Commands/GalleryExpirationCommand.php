<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use Illuminate\Console\Command;

class GalleryExpirationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gallery:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $galleries= Gallery::all();
        foreach($galleries as $gallery)
        {
            if($gallery->date_before != "" && $gallery->date_before < now())
            {
                $gallery->fine = "Suspended";
                $gallery->save();
            }
        }
    }
}
