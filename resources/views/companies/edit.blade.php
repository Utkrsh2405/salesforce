<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white">
                    <form method="POST" action="{{ route('companies.update', $company) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Basic Information') }}</h3>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="name" value="{{ __('Company Name') }}" />
                                    <x-input id="name" type="text" class="mt-1 block w-full" name="name" :value="old('name', $company->name)" required autofocus />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="legal_name" value="{{ __('Legal Name') }}" />
                                    <x-input id="legal_name" type="text" class="mt-1 block w-full" name="legal_name" :value="old('legal_name', $company->legal_name)" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="industry_id" value="{{ __('Industry') }}" />
                                    <select name="industry_id" id="industry_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">{{ __('Select Industry') }}</option>
                                        @foreach($industries as $industry)
                                            <option value="{{ $industry->id }}" @selected(old('industry_id', $company->industry_id) == $industry->id)>
                                                {{ $industry->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="company_size" value="{{ __('Company Size') }}" />
                                    <select name="company_size" id="company_size" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">{{ __('Select Size') }}</option>
                                        @php
                                            $sizes = ['1-10' => '1-10 employees', '11-50' => '11-50 employees', '51-200' => '51-200 employees', '201-1000' => '201-1000 employees', '1000+' => '1000+ employees'];
                                        @endphp
                                        @foreach($sizes as $value => $label)
                                            <option value="{{ $value }}" @selected(old('company_size', $company->company_size) == $value)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="annual_revenue" value="{{ __('Annual Revenue') }}" />
                                    <x-input id="annual_revenue" type="number" class="mt-1 block w-full" name="annual_revenue" :value="old('annual_revenue', $company->annual_revenue)" step="0.01" />
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Contact Information') }}</h3>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="website" value="{{ __('Website') }}" />
                                    <x-input id="website" type="url" class="mt-1 block w-full" name="website" :value="old('website', $company->website)" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input id="email" type="email" class="mt-1 block w-full" name="email" :value="old('email', $company->email)" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="phone" value="{{ __('Phone') }}" />
                                    <x-input id="phone" type="tel" class="mt-1 block w-full" name="phone" :value="old('phone', $company->phone)" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="fax" value="{{ __('Fax') }}" />
                                    <x-input id="fax" type="tel" class="mt-1 block w-full" name="fax" :value="old('fax', $company->fax)" />
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Address Information') }}</h3>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="address_line_1" value="{{ __('Address Line 1') }}" />
                                    <x-input id="address_line_1" type="text" class="mt-1 block w-full" name="address_line_1" :value="old('address_line_1', $company->address_line_1)" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="address_line_2" value="{{ __('Address Line 2') }}" />
                                    <x-input id="address_line_2" type="text" class="mt-1 block w-full" name="address_line_2" :value="old('address_line_2', $company->address_line_2)" />
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-label for="city" value="{{ __('City') }}" />
                                    <x-input id="city" type="text" class="mt-1 block w-full" name="city" :value="old('city', $company->city)" />
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-label for="state" value="{{ __('State/Province') }}" />
                                    <x-input id="state" type="text" class="mt-1 block w-full" name="state" :value="old('state', $company->state)" />
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-label for="country" value="{{ __('Country') }}" />
                                    <x-input id="country" type="text" class="mt-1 block w-full" name="country" :value="old('country', $company->country)" />
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-label for="postal_code" value="{{ __('Postal Code') }}" />
                                    <x-input id="postal_code" type="text" class="mt-1 block w-full" name="postal_code" :value="old('postal_code', $company->postal_code)" />
                                </div>

                                <div class="col-span-6">
                                    <x-label for="billing_address" value="{{ __('Billing Address (JSON format)') }}" />
                                    <textarea id="billing_address" name="billing_address" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" placeholder='{"line1": "123 Main St", "city": "Anytown", "state": "CA", "zip": "12345"}'>{{ old('billing_address', json_encode($company->billing_address, JSON_PRETTY_PRINT)) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Media and Additional Info -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Media & Additional Information') }}</h3>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="logo" value="{{ __('Company Logo') }}" />
                                    <input id="logo" type="file" class="mt-1 block w-full" name="logo" accept="image/*" />
                                    @if($company->logo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Current Logo" class="h-20 w-20 object-cover rounded">
                                            <p class="text-sm text-gray-500 mt-1">{{ __('Current logo') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-span-6">
                                    <x-label for="description" value="{{ __('Description') }}" />
                                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('description', $company->description) }}</textarea>
                                </div>

                                <div class="col-span-6">
                                    <x-label for="social_media_links" value="{{ __('Social Media Links (JSON format)') }}" />
                                    <textarea id="social_media_links" name="social_media_links" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" placeholder='{"linkedin": "https://linkedin.com/company/example", "twitter": "https://twitter.com/example"}'>{{ old('social_media_links', json_encode($company->social_media_links, JSON_PRETTY_PRINT)) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment and Classification -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Assignment & Classification') }}</h3>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="assigned_user_id" value="{{ __('Assigned User') }}" />
                                    <select name="assigned_user_id" id="assigned_user_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">{{ __('Select User') }}</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('assigned_user_id', $company->assigned_user_id) == $user->id)>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="source_id" value="{{ __('Lead Source') }}" />
                                    <select name="source_id" id="source_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">{{ __('Select Source') }}</option>
                                        @foreach($leadSources as $source)
                                            <option value="{{ $source->id }}" @selected(old('source_id', $company->source_id) == $source->id)>
                                                {{ $source->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label class="flex items-center">
                                        <input type="hidden" name="is_client" value="0">
                                        <input id="is_client" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_client" value="1" @checked(old('is_client', $company->is_client))>
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Is this a client?') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Fields -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Custom Fields') }}</h3>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <x-label for="tags" value="{{ __('Tags (JSON array format)') }}" />
                                    <textarea id="tags" name="tags" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2" placeholder='["tag1", "tag2", "tag3"]'>{{ old('tags', json_encode($company->tags)) }}</textarea>
                                </div>

                                <div class="col-span-6">
                                    <x-label for="custom_fields" value="{{ __('Custom Fields (JSON format)') }}" />
                                    <textarea id="custom_fields" name="custom_fields" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" placeholder='{"field1": "value1", "field2": "value2"}'>{{ old('custom_fields', json_encode($company->custom_fields, JSON_PRETTY_PRINT)) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('companies.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md px-3 py-2 mr-2">{{ __('Cancel') }}</a>
                            <x-button class="ml-3">
                                {{ __('Update Company') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
