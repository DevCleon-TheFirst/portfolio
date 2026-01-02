<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $projects = \App\Models\Project::where('is_featured', true)
        ->orderBy('order')
        ->take(3)
        ->get();
    
    $blogPosts = \App\Models\BlogPost::published()
        ->latest('published_at')
        ->take(3)
        ->get();
    
    $skills = \App\Models\Skill::orderBy('category')
        ->orderBy('order')
        ->get()
        ->groupBy('category');
    
    return view('welcome', compact('projects', 'blogPosts', 'skills'));
});

// Contact Form Submission
Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    
    // Save to database
    $contactMessage = \App\Models\ContactMessage::create($validated);
    
    // Send email notification
    try {
        \Illuminate\Support\Facades\Mail::to('hello@devcleon.site')
            ->send(new \App\Mail\ContactFormSubmitted($contactMessage));
    } catch (\Exception $e) {
        // Log error but don't fail the request
        \Illuminate\Support\Facades\Log::error('Failed to send contact form email: ' . $e->getMessage());
    }
    
    return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
})->middleware(['throttle:3,60', \App\Http\Middleware\CheckIpBlacklist::class])->name('contact.submit');



// Sitemap for SEO
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);

// Dashboard Routes (Admin Only)
Route::middleware(['auth', 'admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', App\Livewire\Dashboard\Overview::class)->name('index');
    
    // CMS Routes
    Route::get('/blog', App\Livewire\Dashboard\BlogManager::class)->name('blog');
    Route::get('/projects', App\Livewire\Dashboard\ProjectManager::class)->name('projects');
    Route::get('/skills', App\Livewire\Dashboard\SkillsManager::class)->name('skills');
    Route::get('/timeline', App\Livewire\Dashboard\TimelineManager::class)->name('timeline');
    
    // Dev OS Routes
    Route::get('/tasks', App\Livewire\Dashboard\TaskBoard::class)->name('tasks');
    Route::get('/focus', App\Livewire\Dashboard\FocusTimer::class)->name('focus');
    Route::get('/accountability', App\Livewire\Dashboard\AccountabilityDashboard::class)->name('accountability');
    Route::get('/messages', App\Livewire\Dashboard\MessagesInbox::class)->name('messages');
    Route::get('/contact-messages', App\Livewire\Dashboard\ContactMessages::class)->name('contact-messages');
    Route::get('/settings', App\Livewire\Dashboard\Settings::class)->name('settings');
    Route::get('/ip-blacklist', App\Livewire\Dashboard\IpBlacklist::class)->name('ip-blacklist');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
