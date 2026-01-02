<div class="w-full">
    @if (session()->has('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Name *</label>
                <input type="text" wire:model="name" 
                    class="w-full px-4 py-3 rounded-lg glass focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    style="color: var(--text-primary);"
                    placeholder="Your name">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Email *</label>
                <input type="email" wire:model="email" 
                    class="w-full px-4 py-3 rounded-lg glass focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    style="color: var(--text-primary);"
                    placeholder="your@email.com">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Subject</label>
            <input type="text" wire:model="subject" 
                class="w-full px-4 py-3 rounded-lg glass focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                style="color: var(--text-primary);"
                placeholder="What's this about?">
            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Message *</label>
            <textarea wire:model="message" rows="6" 
                class="w-full px-4 py-3 rounded-lg glass focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"
                style="color: var(--text-primary);"
                placeholder="Tell me about your project..."></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" 
            class="w-full md:w-auto px-12 py-4 bg-gradient-to-r from-blue-600 to-red-600 rounded-lg font-bold text-lg hover:opacity-90 transition animate-glow">
            Send Message
        </button>
    </form>
</div>
