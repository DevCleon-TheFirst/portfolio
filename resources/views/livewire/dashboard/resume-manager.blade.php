<div class="premium-card p-6 border border-[#23242A] relative overflow-hidden group">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-bold text-white">Resume / CV</h3>
            <p class="text-sm text-gray-500">Upload your latest CV for public download.</p>
        </div>
        <div class="p-2 rounded-xl bg-[#1A1B21] border border-[#23242A] text-indigo-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
    </div>

    @if($currentResume)
        <div class="mb-6 p-4 rounded-xl bg-[#1A1B21]/50 border border-green-500/20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center text-green-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Resume Available</p>
                    <a href="{{ Storage::url($currentResume) }}" target="_blank" class="text-xs text-green-400 hover:text-green-300 underline">Preview Current File</a>
                </div>
            </div>
            <div class="text-xs text-gray-500">PDF</div>
        </div>
    @endif

    <form wire:submit="save">
        <div class="relative">
             <input type="file" wire:model="resume" id="resume-upload" class="hidden" accept="application/pdf">
             <label for="resume-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-[#23242A] rounded-xl cursor-pointer hover:border-indigo-500 hover:bg-[#1A1B21]/50 transition-all group">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <div wire:loading.remove wire:target="resume">
                         <svg class="w-8 h-8 mb-3 text-gray-500 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                         <p class="mb-2 text-sm text-gray-400"><span class="font-semibold text-indigo-400">Click to upload</span> or drag and drop</p>
                         <p class="text-xs text-gray-500">PDF (MAX. 10MB)</p>
                    </div>
                    <div wire:loading wire:target="resume" class="text-center">
                        <svg class="animate-spin h-6 w-6 text-indigo-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-xs text-indigo-400">Processing...</p>
                    </div>
                </div>
            </label>
        </div>

        @if($resume)
            <div class="mt-4 flex justify-end">
                <button type="submit" class="btn-premium px-6 py-2 text-sm w-full">Update Resume</button>
            </div>
        @endif
        
        @error('resume') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
        @if (session()->has('success'))
            <div class="mt-2 text-green-500 text-xs text-center font-bold">
                {{ session('success') }}
            </div>
        @endif
    </form>
</div>
