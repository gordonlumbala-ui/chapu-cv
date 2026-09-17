<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-md p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Profile strength</h3>
                    <span class="text-sm font-semibold text-indigo-600">{{ $completion }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $completion }}%"></div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center space-x-4">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                            class="h-16 w-16 rounded-full object-cover">
                        <div>
                            <input type="file" name="photo" accept="image/*" class="block text-sm text-gray-600">
                            @error('photo')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Professional title</label>
                            <input type="text" name="professional_title"
                                value="{{ old('professional_title', $user->professional_title) }}"
                                placeholder="e.g. Frontend Developer"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('professional_title')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Professional summary</label>
                            <textarea name="summary" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300">{{ old('summary', $user->summary) }}</textarea>
                            @error('summary')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('address')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('city')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="country" value="{{ old('country', $user->country) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('country')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of birth</label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('date_of_birth')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Prefer not to say</option>
                                @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('gender', $user->gender) === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gender')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Website</label>
                            <input type="url" name="website" value="{{ old('website', $user->website) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('website')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">LinkedIn</label>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('linkedin_url')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">GitHub</label>
                            <input type="url" name="github_url" value="{{ old('github_url', $user->github_url) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('github_url')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>