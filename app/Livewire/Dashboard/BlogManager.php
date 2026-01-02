<?php

namespace App\Livewire\Dashboard;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class BlogManager extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $editMode = false;
    public $postId;
    
    // Form fields
    public $title = '';
    public $excerpt = '';
    public $content = '';
    public $category = '';
    public $tags = '';
    public $image;
    public $is_published = false;
    public $scheduled_at;
    
    public $search = '';

    protected $rules = [
        'title' => 'required|min:3',
        'excerpt' => 'required',
        'content' => 'required',
        'category' => 'required',
    ];

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->postId = $id;
        $this->title = $post->title;
        $this->excerpt = $post->excerpt;
        $this->content = $post->content;
        $this->category = $post->category;
        $this->tags = is_array($post->tags) ? implode(', ', $post->tags) : '';
        $this->is_published = $post->is_published;
        $this->scheduled_at = $post->scheduled_at ? $post->scheduled_at->format('Y-m-d\TH:i') : null;
        
        $this->editMode = true;
        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category,
            'tags' => array_map('trim', explode(',', $this->tags)),
            'is_published' => $this->is_published,
            'scheduled_at' => $this->scheduled_at ? $this->scheduled_at : null,
            'read_time' => $this->calculateReadTime($this->content),
        ];

        if ($this->image) {
            $data['image_path'] = $this->image->store('blog', 'public');
        }

        if ($this->is_published && !$this->editMode) {
            $data['published_at'] = now();
        }
        
        // If scheduled for future, ensure is_published is false
        if (!empty($data['scheduled_at'])) {
            $data['is_published'] = false;
        }

        if ($this->editMode) {
            BlogPost::find($this->postId)->update($data);
            session()->flash('message', 'Blog post updated successfully!');
        } else {
            BlogPost::create($data);
            session()->flash('message', 'Blog post created successfully!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        BlogPost::find($id)->delete();
        session()->flash('message', 'Blog post deleted successfully!');
    }

    public function togglePublish($id)
    {
        $post = BlogPost::find($id);
        $post->update([
            'is_published' => !$post->is_published,
            'published_at' => !$post->is_published ? now() : null,
        ]);
        session()->flash('message', 'Post status updated!');
    }

    private function calculateReadTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        return max(1, ceil($wordCount / 200)); // 200 words per minute
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->title = '';
        $this->excerpt = '';
        $this->content = '';
        $this->category = '';
        $this->tags = '';
        $this->image = null;
        $this->is_published = false;
        $this->scheduled_at = null;
        $this->postId = null;
    }

    public function render()
    {
        $posts = BlogPost::query()
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.blog-manager', [
            'posts' => $posts
        ])->layout('layouts.dashboard');
    }
}
