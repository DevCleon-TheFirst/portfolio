<div class="space-y-8">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-[24px] premium-card p-8">
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold mb-2">
                    <span class="text-white">🛡️ IP Blacklist</span>
                </h2>
                <p class="text-gray-400">Manage blocked IP addresses and protect your site from spam</p>
            </div>
            <button wire:click="$toggle('showAddForm')" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-rose-900 rounded-lg font-bold text-white hover:opacity-90 transition">
                {{ $showAddForm ? '✕ Cancel' : '+ Add IP' }}
            </button>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="premium-card p-4 border-l-4 border-green-500">
            <p class="text-green-400 font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="premium-card p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Total Blacklisted</span>
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
        </div>

        <div class="premium-card p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Active Blocks</span>
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <p class="text-3xl font-bold text-white">{{ $stats['active'] }}</p>
        </div>

        <div class="premium-card p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Expired</span>
                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-3xl font-bold text-white">{{ $stats['expired'] }}</p>
        </div>

        <div class="premium-card p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Blocked Today</span>
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <p class="text-3xl font-bold text-white">{{ $stats['today'] }}</p>
        </div>
    </div>

    <!-- Add IP Form -->
    @if($showAddForm)
        <div class="premium-card p-8">
            <h3 class="text-xl font-bold mb-6">Add IP to Blacklist</h3>
            <form wire:submit.prevent="addIp" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">IP Address *</label>
                        <input type="text" wire:model="ip_address" 
                               class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="192.168.1.1">
                        @error('ip_address') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Reason *</label>
                        <select wire:model="reason" 
                                class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="manual">Manual Block</option>
                            <option value="spam_detected">Spam Detected</option>
                            <option value="suspicious">Suspicious Activity</option>
                        </select>
                        @error('reason') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Expires After (days)</label>
                        <input type="number" wire:model="expires_days" 
                               class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Leave empty for permanent">
                        @error('expires_days') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Notes</label>
                        <input type="text" wire:model="notes" 
                               class="w-full bg-[#1A1B21] border border-[#23242A] rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Optional notes">
                        @error('notes') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" wire:click="$toggle('showAddForm')"
                            class="px-6 py-3 bg-[#1A1B21] border border-[#23242A] rounded-lg font-medium text-gray-400 hover:text-white transition">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-rose-900 rounded-lg font-bold text-white hover:opacity-90 transition">
                        Add to Blacklist
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Blacklist Table -->
    <div class="premium-card p-6">
        <h3 class="text-xl font-bold mb-6">Blacklisted IP Addresses</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#23242A]">
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">IP Address</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Reason</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Blocked At</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Expires</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Attempts</th>
                        <th class="text-right py-4 px-4 text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blacklists as $blacklist)
                        <tr class="border-b border-[#23242A] hover:bg-[#1A1B21] transition">
                            <td class="py-4 px-4">
                                <span class="font-mono text-white">{{ $blacklist->ip_address }}</span>
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $badges = [
                                        'auto_blocked' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                        'manual' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                        'spam_detected' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
                                        'rate_limit' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                        'suspicious' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium border {{ $badges[$blacklist->reason] ?? 'bg-gray-500/10 text-gray-400 border-gray-500/20' }}">
                                    {{ ucfirst(str_replace('_', ' ', $blacklist->reason)) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-400 text-sm">
                                {{ $blacklist->blocked_at->format('M d, Y H:i') }}
                            </td>
                            <td class="py-4 px-4 text-gray-400 text-sm">
                                @if($blacklist->expires_at)
                                    @if($blacklist->expires_at->isPast())
                                        <span class="text-red-400">Expired</span>
                                    @else
                                        {{ $blacklist->expires_at->format('M d, Y') }}
                                    @endif
                                @else
                                    <span class="text-gray-500">Never</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="text-white font-medium">{{ $blacklist->attempt_count }}</span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <button wire:click="removeIp({{ $blacklist->id }})" 
                                        wire:confirm="Are you sure you want to unblock this IP?"
                                        class="px-4 py-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition text-sm font-medium">
                                    Unblock
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                No blacklisted IPs found. Your site is clean! 🎉
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $blacklists->links() }}
        </div>
    </div>
</div>
