<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update profession Details') }}
        </h2>

        <!-- <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('') }}
        </p> -->
    </header>

    <form method="post" action="{{ route('profession.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="specialization" :value="__('Specialization')" />
            <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full" :value="old('specialization')" autocomplete="specialization" />
            <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="p_email" :value="__('email')" />
            <x-text-input id="p_email" name="p_email" type="text" class="mt-1 block w-full" :value="old('p_email')" autocomplete="p_email" />
            <x-input-error :messages="$errors->get('p_email')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <!-- <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p> -->
            @endif
        </div>
    </form>
</section>
