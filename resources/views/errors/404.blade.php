<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | DevCleon</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo-transparent.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #881337 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-2xl w-full text-center">
        <!-- 404 Number -->
        <div class="mb-8 float-animation">
            <h1 class="text-9xl font-bold gradient-text mb-4">404</h1>
            <div class="h-1 w-32 mx-auto bg-gradient-to-r from-blue-600 to-rose-900 rounded-full"></div>
        </div>

        <!-- Message -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Page Not Found</h2>
            <p class="text-gray-400 text-lg mb-2">
                Oops! The page you're looking for doesn't exist.
            </p>
            <p class="text-gray-500">
                It might have been moved, deleted, or the URL might be incorrect.
            </p>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/" 
               class="px-8 py-4 bg-gradient-to-r from-blue-600 to-rose-900 rounded-lg font-bold text-white hover:opacity-90 transition-all transform hover:scale-105 glow">
                🏠 Go Home
            </a>
            <button onclick="history.back()" 
                    class="px-8 py-4 bg-white/5 border border-white/10 rounded-lg font-medium text-white hover:bg-white/10 transition-all">
                ← Go Back
            </button>
        </div>

        <!-- Suggestions -->
        <div class="mt-16 p-6 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-sm">
            <h3 class="text-white font-bold mb-4">Quick Links</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="/" class="text-gray-400 hover:text-blue-400 transition-colors">
                    <div class="text-2xl mb-2">🏠</div>
                    <div class="text-sm">Home</div>
                </a>
                <a href="/#projects" class="text-gray-400 hover:text-blue-400 transition-colors">
                    <div class="text-2xl mb-2">💼</div>
                    <div class="text-sm">Projects</div>
                </a>
                <a href="/#blog" class="text-gray-400 hover:text-blue-400 transition-colors">
                    <div class="text-2xl mb-2">📝</div>
                    <div class="text-sm">Blog</div>
                </a>
                <a href="/#contact" class="text-gray-400 hover:text-blue-400 transition-colors">
                    <div class="text-2xl mb-2">✉️</div>
                    <div class="text-sm">Contact</div>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} DevCleon. All rights reserved.</p>
        </div>
    </div>

    <!-- Background Effects -->
    <div class="fixed top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl -z-10"></div>
    <div class="fixed bottom-0 left-0 w-96 h-96 bg-rose-900/10 rounded-full blur-3xl -z-10"></div>
</body>
</html>
