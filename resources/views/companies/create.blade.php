<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white">
                    <form method="POST" action="{{ route('companies.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="name" value="{{ __('Company Name') }}" />
                                <x-input id="name" type="text" class="mt-1 block w-full" name="name" :value="old('name')" required autofocus />
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="legal_name" value="{{ __('Legal Name') }}" />
                                <x-input id="legal_name" type="text" class="mt-1 block w-full" name="legal_name" :value="old('legal_name')" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="industry_id" value="{{ __('Industry') }}" />
                                <select name="industry_id" id="industry_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Industry</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}" {{ old('industry_id') == $industry->id ? 'selected' : '' }}>
                                            {{ $industry->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="website" value="{{ __('Website') }}" />
                                <x-input id="website" type="url" class="mt-1 block w-full" name="website" :value="old('website')" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" type="email" class="mt-1 block w-full" name="email" :value="old('email')" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="phone" value="{{ __('Phone') }}" />
                                <x-input id="phone" type="text" class="mt-1 block w-full" name="phone" :value="old('phone')" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="company_size" value="{{ __('Company Size') }}" />
                                <select name="company_size" id="company_size" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Size</option>
                                    <option value="1-10" {{ old('company_size') == '1-10' ? 'selected' : '' }}>1-10</option>
                                    <option value="11-50" {{ old('company_size') == '11-50' ? 'selected' : '' }}>11-50</option>
                                    <option value="51-200" {{ old('company_size') == '51-200' ? 'selected' : '' }}>51-200</option>
                                    <option value="201-1000" {{ old('company_size') == '201-1000' ? 'selected' : '' }}>201-1000</option>
                                    <option value="1000+" {{ old('company_size') == '1000+' ? 'selected' : '' }}>1000+</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="annual_revenue" value="{{ __('Annual Revenue') }}" />
                                <x-input id="annual_revenue" type="number" step="0.01" class="mt-1 block w-full" name="annual_revenue" :value="old('annual_revenue')" />
                            </div>

                            <div class="col-span-6">
                                <x-label for="description" value="{{ __('Description') }}" />
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="logo" value="{{ __('Company Logo') }}" />
                                <input type="file" name="logo" id="logo" class="mt-1 block w-full" accept="image/*">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-button>
                                {{ __('Create Company') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
