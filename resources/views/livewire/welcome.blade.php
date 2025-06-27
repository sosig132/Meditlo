
<div class="flex flex-col md:flex-row min-h-screen bg-cover bg-center relative" style="background-image: url('https://images.pexels.com/photos/813269/pexels-photo-813269.jpeg?cs=srgb&dl=pexels-minan1398-813269.jpg&fm=jpg')">
    <div class="absolute inset-0 bg-gradient-to-r from-base-200 to-transparent"></div>
    <div class="md:w-1/2 order-1 md:order-2">
        <div class="flex items-center justify-center h-screen color-white flex-col">
            <h1 class="text-6xl font-bold text-white">Welcome!</h1>
        </div>
    </div>
    <div class="md:w-1/2 flex items-center justify-center p-6 relative">
        @livewire('auth.register')
    </div>
</div>
