@php
    use Filament\Support\Icons\Heroicon;
    use Filament\Support\View\Components\BadgeComponent;
    use Illuminate\View\ComponentAttributeBag;

    $notifications = $this->getNotifications();
    $unreadNotificationsCount = $this->getUnreadNotificationsCount();
    $hasNotifications = $notifications->count();
    $isPaginated = $notifications instanceof \Illuminate\Contracts\Pagination\Paginator && $notifications->hasPages();
    $pollingInterval = $this->getPollingInterval();
@endphp

<div class="fi-no-database">
    <x-filament::modal
        :alignment="null"
        close-button
        :description="null"
        :heading="null"
        :icon="null"
        :icon-alias="null"
        :icon-color="null"
        id="database-notifications"
        slide-over
        sticky-header
        teleport="body"
        width="md"
        class="fi-no-database"
        :attributes="
            new \Illuminate\View\ComponentAttributeBag([
                'wire:poll.' . $pollingInterval => $pollingInterval ? '' : false,
            ])
        "
    >
        @if ($trigger = $this->getTrigger())
            <x-slot name="trigger">
                {{ $trigger->with(['unreadNotificationsCount' => $unreadNotificationsCount]) }}
            </x-slot>
        @endif

        <x-slot name="header">
            <div class="flex-1">
                <h2 class="fi-modal-heading">
                    {{ __('filament-notifications::database.modal.heading') }}

                    @if ($unreadNotificationsCount)
                        <span
                            {{
                                (new ComponentAttributeBag)->color(BadgeComponent::class, 'primary')->class([
                                    'fi-badge fi-size-xs',
                                ])
                            }}
                        >
                            {{ $unreadNotificationsCount }}
                        </span>
                    @endif
                </h2>

                {{-- <div class="fi-ac">
                        @if ($unreadNotificationsCount && $this->markAllNotificationsAsReadAction?->isVisible())
                            {{ $this->markAllNotificationsAsReadAction }}
                        @endif

                        @if ($this->clearNotificationsAction?->isVisible())
                            {{ $this->clearNotificationsAction }}
                        @endif
                    </div> --}}

                <div class="-mx-3">
                    <x-filament::tabs contained class="fi-no-database-tabs border-b-0 mb-0 pb-0">
                        <x-filament::tabs.item
                            :active="$this->tab === 'unread'"
                            :badge="$unreadNotificationsCount ?: null"
                            wire:click="setTab('unread')"
                        >
                            {{ __('filament-notifications-tabs::notifications.tabs.unread') }}
                        </x-filament::tabs.item>

                        <x-filament::tabs.item
                            :active="$this->tab === 'all'"
                            wire:click="setTab('all')"
                        >
                            {{ __('filament-notifications-tabs::notifications.tabs.all') }}
                        </x-filament::tabs.item>

                        @if ($this->markAllNotificationsAsReadAction?->isVisible())
                            <span class="flex justify-center ms-auto leading-9">{{ $this->markAllNotificationsAsReadAction }}</span>
                        @endif
                    </x-filament::tabs>
                </div>
            </div>
        </x-slot>

        @if ($hasNotifications)
            @foreach ($notifications as $notification)
                <div
                    @class([
                        'fi-no-database-notification-ctn',
                        'fi-no-notification-read-ctn' => ! $notification->unread(),
                        'fi-no-notification-unread-ctn' => $notification->unread(),
                    ])
                >
                    {{ $this->getNotification($notification)->inline() }}

                    <div class="fi-no-database-notification-actions">
                        <x-filament::icon-button
                            :icon="Heroicon::OutlinedTrash"
                            color="danger"
                            size="sm"
                            :label="__('filament-notifications-tabs::notifications.actions.delete.label')"
                            :tooltip="__('filament-notifications-tabs::notifications.actions.delete.label')"
                            wire:click="deleteNotification('{{ $notification->getKey() }}')"
                        />

                        <x-filament::icon-button
                            :icon="$notification->unread() ? Heroicon::OutlinedCheckCircle : Heroicon::OutlinedEnvelope"
                            color="gray"
                            size="sm"
                            :label="
                                $notification->unread()
                                ? __('filament-notifications-tabs::notifications.actions.mark_as_read.label')
                                : __('filament-notifications-tabs::notifications.actions.mark_as_unread.label')
                            "
                            :tooltip="
                                $notification->unread()
                                ? __('filament-notifications-tabs::notifications.actions.mark_as_read.label')
                                : __('filament-notifications-tabs::notifications.actions.mark_as_unread.label')
                            "
                            wire:click="toggleNotificationReadStatus('{{ $notification->getKey() }}')"
                        />
                    </div>
                </div>
            @endforeach
        @else
            <x-filament::empty-state
                icon="heroicon-o-bell-slash"
                icon-color="gray"
                icon-size="md"
                :contained="false"
            >
                <x-slot name="heading">
                    {{ __($this->tab === 'all' ? 'filament-notifications-tabs::notifications.empty_all' : 'filament-notifications-tabs::notifications.empty_unread') }}
                </x-slot>
                <x-slot name="description">{{ __('filament-notifications-tabs::notifications.description') }}</x-slot>
            </x-filament::empty-state>
        @endif

        @if ($broadcastChannel = $this->getBroadcastChannel())
            @script
                <script>
                    window.addEventListener('EchoLoaded', () => {
                        window.Echo.private(@js($broadcastChannel)).listen(
                            '.database-notifications.sent',
                            () => {
                                setTimeout(
                                    () => $wire.call('$refresh'),
                                    500,
                                )
                            },
                        )
                    })

                    if (window.Echo) {
                        window.dispatchEvent(new CustomEvent('EchoLoaded'))
                    }
                </script>
            @endscript
        @endif

        @if ($isPaginated)
            <x-slot name="footer">
                <x-filament::pagination :paginator="$notifications" />
            </x-slot>
        @endif
    </x-filament::modal>

    <style>
        .fi-no-database .fi-no-notification-close-btn {
            display: none;
        }

        .fi-no-database .fi-no-database-tabs {
            margin-top: 0.75rem;
        }

        .fi-no-database .fi-no-database-notification-ctn {
            position: relative;
        }

        .fi-no-database .fi-no-database-notification-actions {
            position: absolute;
            padding: 0.5rem;
            inset-block-start: 0.625rem;
            inset-inline-end: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 0.5rem;
            background-color: rgb(255 255 255 / 0.95);
            box-shadow:
                0 1px 2px rgb(0 0 0 / 0.1),
                0 0 0 1px rgb(0 0 0 / 0.09);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease;
        }

        .dark .fi-no-database .fi-no-database-notification-actions {
            background-color: rgb(39 39 42 / 0.95);
            box-shadow:
                0 1px 2px rgb(0 0 0 / 0.4),
                0 0 0 1px rgb(255 255 255 / 0.15);
        }

        .fi-no-database .fi-no-database-notification-ctn:hover .fi-no-database-notification-actions,
        .fi-no-database .fi-no-database-notification-actions:focus-within {
            opacity: 1;
            pointer-events: auto;
        }

        @media (hover: none) {
            .fi-no-database .fi-no-database-notification-actions {
                opacity: 1;
                pointer-events: auto;
            }
        }

        .fi-no-database .fi-no-database-notification-actions .fi-icon-btn {
            border-radius: 0.375rem;
            transition: background-color 0.15s ease;
        }

        .fi-no-database .fi-no-database-notification-actions .fi-icon-btn:hover {
            background-color: rgb(244 244 245 / 0.9);
        }

        .dark .fi-no-database .fi-no-database-notification-actions .fi-icon-btn:hover {
            background-color: rgb(63 63 70 / 0.9);
        }
    </style>
</div>
