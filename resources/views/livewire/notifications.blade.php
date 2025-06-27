<div>
    <div x-data="{ show: @entangle('show') }" class="relative">
        <button class="btn btn-ghost notification-button p-0 pl-3 pr-3 rounded-full" @click="show = !show"
            wire:click="setAllNotificationsAsRead">
            <svg fill="#FFFFFF" height="24px" width="24px" viewBox="0 0 611.999 611.999"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M570.107,500.254c-65.037-29.371-67.511-155.441-67.559-158.622v-84.578c0-81.402-49.742-151.399-120.427-181.203
                C381.969,34,347.883,0,306.001,0c-41.883,0-75.968,34.002-76.121,75.849c-70.682,29.804-120.425,99.801-120.425,181.203v84.578
                c-0.046,3.181-2.522,129.251-67.561,158.622c-7.409,3.347-11.481,11.412-9.768,19.36c1.711,7.949,8.74,13.626,16.871,13.626
                h164.88c3.38,18.594,12.172,35.892,25.619,49.903c17.86,18.608,41.479,28.856,66.502,28.856
                c25.025,0,48.644-10.248,66.502-28.856c13.449-14.012,22.241-31.311,25.619-49.903h164.88c8.131,0,15.159-5.676,16.872-13.626
                C581.586,511.664,577.516,503.6,570.107,500.254z M484.434,439.859c6.837,20.728,16.518,41.544,30.246,58.866H97.32
                c13.726-17.32,23.407-38.135,30.244-58.866H484.434z M306.001,34.515c18.945,0,34.963,12.73,39.975,30.082
                c-12.912-2.678-26.282-4.09-39.975-4.09s-27.063,1.411-39.975,4.09C271.039,47.246,287.057,34.515,306.001,34.515z
                M143.97,341.736v-84.685c0-89.343,72.686-162.029,162.031-162.029s162.031,72.686,162.031,162.029v84.826
                c0.023,2.596,0.427,29.879,7.303,63.465H136.663C143.543,371.724,143.949,344.393,143.97,341.736z
                M306.001,577.485c-26.341,0-49.33-18.992-56.709-44.246h113.416C355.329,558.493,332.344,577.485,306.001,577.485z">
                </path>
                <path d="M306.001,119.235c-74.25,0-134.657,60.405-134.657,134.654c0,9.531,7.727,17.258,17.258,17.258
                c9.531,0,17.258-7.727,17.258-17.258c0-55.217,44.923-100.139,100.142-100.139c9.531,0,17.258-7.727,17.258-17.258
                C323.259,126.96,315.532,119.235,306.001,119.235z">
                </path>
            </svg>
        </button>
        @if ($notificationCount > 0)
            <span class="absolute top-0 right-0 text-xs text-white bg-red-500 rounded-full px-2 py-1">
                {{ $notificationCount }}
            </span>
        @endif

        <ul x-show="show" x-transition @click.away="show = false"
            class="menu dropdown-content z-[100] p-2 shadow bg-base-100 rounded-box w-64">
            @if (!empty($notifications))
                @foreach ($notifications as $notification)
                    <li class="notification flex flex-row gap-1"
                        {{ $notification['type'] === 'match_request' ? "wire:click=openRequestModal('{$notification['id']}')" : '' }}
                        role="button" tabindex="0">

                        @if ($notification['type'] == 'match_request')
                            <p class="inline" data-type="{{ $notification['type'] }}"
                                data-id="{{ $notification['id'] }}">{!! str_replace(
                                    '<a',
                                    '<a class="underline font-bold" onclick="event.stopPropagation()"',
                                    $notification['message'],
                                ) !!}</p>
                        @else
                            {{ $notification['message'] }}
                        @endif

                    </li>
                @endforeach
            @else
                <p class="p-3 inline">No new notifications</p>
            @endif
        </ul>
    </div>
    <dialog id="request_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box flex flex-col">
            <button wire:click="closeRequestModal"
                class="absolute top-0 right-0 p-2 text-gray-500 hover:text-gray-800 btn btn-ghost">
                <span class="text-2xl">&times;</span> <!-- The X character -->
            </button>

            <h3 class="text-center text-xl font-semibold mt-4">Accept the request?</h3>
            <button class="btn btn-primary mt-4" wire:click="acceptRequest">Accept</button>
            <button class="btn btn-secondary mt-2" wire:click="rejectRequest">Reject</button>
        </div>
    </dialog>
</div>


@script
    <script>
        const userId = window.Laravel?.userId;
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                Livewire.dispatch('updateNotifications', notification);
            });

        window.addEventListener('show-request-modal', () => {
            const modal = document.getElementById('request_modal');
            modal.showModal();
        })

        window.addEventListener('close-request-modal', () => {
            const modal = document.getElementById('request_modal');
            modal.close();
        })
    </script>
@endscript
