<div class="navbar bg-base-100">
    <div class="navbar-start">
        <div class="dropdown">
            @auth
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('home') }}" class="btn btn-ghost text-xl">Home</a></li>
                    @tutor
                        <li><a href="{{ route('tutor-dashboard') }}" class="btn btn-ghost text-xl">Dashboard</a></li>
                    @endtutor
                    @student
                        <li><a href="{{ route('student-dashboard') }}" class="btn btn-ghost text-xl">Tutors</a></li>
                    @endstudent
                </ul>
            @endauth
        </div>
        <a class="btn btn-ghost text-xl">Pick up</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        @auth
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('home') }}" class="btn btn-ghost text-xl">Home</a></li>
                @tutor
                    <li><a href="{{ route('tutor-dashboard') }}" class="btn btn-ghost text-xl">Dashboard</a></li>
                @endtutor
                @student
                    <li><a href="{{ route('student-dashboard') }}" class="btn btn-ghost text-xl">Tutors</a></li>
                @endstudent
            </ul>
        @endauth
    </div>
    <div class="navbar-end">
        @auth
            <div class="dropdown dropdown-end">
                <livewire:notifications />
            </div>
            <div class="dropdown dropdown-end">
                <livewire:messages :key="'messages-'.time()" />
            </div>
        @endauth
        {{-- Profile icon --}}
        <div class="dropdown dropdown-end">
            @auth


                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img src="{{ authUserPhoto() ? Storage::url(authUserPhoto()) : 'https://adaptcommunitynetwork.org/wp-content/uploads/2023/09/person-placeholder-450x330.jpg' }}"
                            alt="Profile Photo">
                    </div>
                </div>
                <ul tabindex="0" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-52 z-50">
                    <li>
                        <a href="{{ route('profile', Auth::id()) }}">Profile</a>
                    </li>
                    @admin
                        <li>
                            <a href="{{ route('admin-dashboard') }}">Admin Dashboard</a>
                        </li>
                    @endadmin
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            @else
                <livewire:auth.login />
                <button class="btn btn-primary" onclick="login_modal.showModal()">Login</button>
            @endauth

        </div>
    </div>
</div>
