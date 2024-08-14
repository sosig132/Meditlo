<div class="navbar bg-base-100">
    <div class="navbar-start">
        <div class="dropdown">
          <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
          </div>
          @auth
          <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a>Home</a></li>
                <li>
                <a>Meditatii</a>
                </li>
            </ul>
            @endauth
        </div>
        <a class="btn btn-ghost text-xl">Pick up</a>
      </div>
    <div class="navbar-center hidden lg:flex">
        @auth
        <ul class="menu menu-horizontal px-1">
            <li><a href="{{ route('home') }}" class="btn btn-ghost text-xl">Home</a></li>

            <li><a class="btn btn-ghost text-xl">Meditatii</a></li>
          </ul>
        @endauth
    </div>
    <div class="navbar-end">

        <div class="dropdown dropdown-end">
            @auth


                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img
                            src="data:image/jpeg;base64,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" />
                    </div>
                </div>
                <ul tabindex="0" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-52">
                    {{-- <li>
                    <a href="{{ route('profile') }}">Profile</a>
                </li> --}}
                @admin
                    <li>
                        <a href="{{ route('admin-dashboard') }}">Admin Dashboard</a>
                    </li>
                @endadmin
                    <li>
                        <a href="#">Profile</a>
                    </li>
                    <li>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                </ul>

                @else
                    <livewire:login />
                    <button class="btn btn-primary" onclick="login_modal.showModal()">Login</button>

                @endauth

        </div>
    </div>
</div>
{{-- <div class="navbar bg-base-100">
  <div class="flex-1">
    <a class="btn btn-ghost text-xl">daisyUI</a>
  </div>
  <div class="flex-none">
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <div class="indicator">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
          <span class="badge badge-sm indicator-item">8</span>
        </div>
      </div>
      <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
        <div class="card-body">
          <span class="font-bold text-lg">8 Items</span>
          <span class="text-info">Subtotal: $999</span>
          <div class="card-actions">
            <button class="btn btn-primary btn-block">View cart</button>
          </div>
        </div>
      </div>
    </div>
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img alt="Tailwind CSS Navbar component" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
        </div>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li>
          <a class="justify-between">
            Profile
            <span class="badge">New</span>
          </a>
        </li>
        <li><a>Settings</a></li>
        <li><a>Logout</a></li>
      </ul>
    </div>
  </div>
</div> --}}
