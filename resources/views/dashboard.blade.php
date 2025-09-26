<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @role('Admin')
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Update user Permission') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Update user permission by register email.") }}
                        </p>
                    </header>
                    <form method="post" action="{{ route('role.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"  required autofocus autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="permission" :value="__('Permission')" />
                            <hr>
                            <input type="checkbox" name="roles[]" value="Admin" id="">Admin<br>
                            <input type="checkbox" name="roles[]" value="CRM Agent" id="">CRM Agent<br>
                            <input type="checkbox" name="roles[]" value="Doctor" id="">Doctor<br>
                            <input type="checkbox" name="roles[]" value="Patient" id="">Patient<br>
                            <input type="checkbox" name="roles[]" value="Lab Manager" id="">Lab Manager<br>
                            <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                    <p>
                        @if (session()->has('success'))
                            {{ session('success') }}
                        @endif

                        @if (session()->has('error'))
                                {{ session('error') }}
                        @endif
                    </p>
                    @else
                    {{ __("You're logged in!") }}
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<!-- <script> 
    console.log('ok');
</script> -->