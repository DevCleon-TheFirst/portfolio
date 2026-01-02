<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogPost;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically publish blog posts that are scheduled for the past';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = BlogPost::scheduled()
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($posts->isEmpty()) {
            $this->info('No scheduled posts to publish.');
            return;
        }

        $count = 0;
        foreach ($posts as $post) {
            $post->publish();
            $this->info("Published: {$post->title}");
            $count++;
        }

        $this->info("Successfully published {$count} posts.");
    }
}
