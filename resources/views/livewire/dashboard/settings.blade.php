<div class="space-y-8">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-[24px] premium-card p-8">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">
                <span class="text-white">⚙️ Settings</span>
            </h2>
            <p class="text-gray-400">Manage your social media links and site settings</p>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="premium-card p-4 border-l-4 border-green-500">
            <p class="text-green-400 font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <!-- Social Media Links Form -->
    <div class="premium-card p-8">
        <h3 class="text-xl font-bold mb-6">🔗 Social Media Links</h3>
        <p class="text-gray-400 mb-6">Add your social media profile URLs. Leave empty to hide from footer.</p>

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- GitHub -->
            <div>
                <label for="social_github" class="block text-sm font-medium text-gray-300 mb-2">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    GitHub
                </label>
                <input type="url" id="social_github" wire:model="social_github" 
                       class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://github.com/username">
                @error('social_github') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Facebook -->
            <div>
                <label for="social_facebook" class="block text-sm font-medium text-gray-300 mb-2">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </label>
                <input type="url" id="social_facebook" wire:model="social_facebook" 
                       class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://facebook.com/username">
                @error('social_facebook') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- WhatsApp -->
            <div>
                <label for="social_whatsapp" class="block text-sm font-medium text-gray-300 mb-2">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </label>
                <input type="text" id="social_whatsapp" wire:model="social_whatsapp" 
                       class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://wa.me/1234567890 or phone number">
                @error('social_whatsapp') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- X (Twitter) -->
            <div>
                <label for="social_x" class="block text-sm font-medium text-gray-300 mb-2">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                    X (Twitter)
                </label>
                <input type="url" id="social_x" wire:model="social_x" 
                       class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://x.com/username">
                @error('social_x') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Threads -->
            <div>
                <label for="social_threads" class="block text-sm font-medium text-gray-300 mb-2">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 6.504 3.616 8.914 3.589 12c.027 3.086.718 5.496 2.057 7.164 1.43 1.781 3.631 2.695 6.54 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.3-1.634-1.75-.192 1.352-.622 2.446-1.284 3.272-.886 1.102-2.14 1.704-3.73 1.79-1.202.065-2.361-.218-3.259-.801-1.063-.689-1.685-1.74-1.752-2.964-.065-1.19.408-2.285 1.33-3.082.88-.76 2.119-1.207 3.583-1.291a13.853 13.853 0 013.02.142l-.126 1.974a11.881 11.881 0 00-2.68-.134c-1.112.063-1.953.39-2.502.97-.465.49-.702 1.08-.665 1.657.027.433.23.842.572 1.155.463.424 1.13.635 1.98.626 1.21-.065 2.108-.505 2.735-1.34.552-.734.86-1.746.918-3.01l.007-.16c.01-.184.015-.37.015-.556 0-1.833-.347-3.249-1.031-4.207-.684-.96-1.753-1.447-3.178-1.447-1.425 0-2.494.487-3.178 1.447-.684.958-1.031 2.374-1.031 4.207 0 1.833.347 3.249 1.031 4.207.684.96 1.753 1.447 3.178 1.447.684 0 1.307-.097 1.857-.29l.56 1.924c-.684.24-1.447.36-2.287.36-1.98 0-3.583-.684-4.774-2.032-1.19-1.348-1.79-3.178-1.79-5.455 0-2.277.6-4.107 1.79-5.455 1.191-1.348 2.794-2.032 4.774-2.032 1.98 0 3.583.684 4.774 2.032 1.19 1.348 1.79 3.178 1.79 5.455 0 .24-.007.477-.02.71.408.24.76.54 1.056.896.684.82 1.031 1.833 1.031 3.01 0 1.177-.347 2.19-1.031 3.01-.684.82-1.647 1.348-2.887 1.58-.408.077-.84.116-1.295.116z"/>
                    </svg>
                    Threads
                </label>
                <input type="url" id="social_threads" wire:model="social_threads" 
                       class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://threads.net/@username">
                @error('social_threads') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- LinkedIn -->
            <div>
                <label for="social_linkedin" class="block text-sm font-medium text-gray-300 mb-2">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </label>
                <input type="url" id="social_linkedin" wire:model="social_linkedin" 
                       class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://linkedin.com/in/username">
                @error('social_linkedin') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Save Button -->
            <div class="flex justify-end pt-4">
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-rose-900 rounded-lg font-bold text-white hover:opacity-90 transition">
                    💾 Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
