<form method="POST" action="{{ route('cv.generate') }}" class="w-full flex flex-col items-center justify-center">
    @csrf
    <!-- Personal Detail Section -->
    <section class="px-8 py-6 rounded-lg shadow-md w-full border border-gray-200" id="personal_detail">
        <h2 class="text-2xl font-semibold text-blue-600 mb-6 border-b border-blue-400 pb-2">Personal Detail</h2>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-4 gap-x-6 gap-y-8">
            <!-- Full Name -->
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700">Fullname</label>
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                    autocomplete="given-name"
                    class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('full_name') border-red-500 @enderror" />
                @error('full_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}"
                    class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('email') border-red-500 @enderror" />
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input id="phone" name="phone" type="tel" autocomplete="tel"
                    class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('phone') border-red-500 @enderror" />
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="address" autocomplete="street-address"
                    class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('address') border-red-500 @enderror" />
                @error('address')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <!-- Education & Experience Sections Container -->
    <div class="flex flex-col md:flex-row justify-between w-full gap-8 mt-12">
        <!-- Education Section -->
        <section class="px-8 py-6 rounded-lg shadow-md w-full border border-gray-200" id="education_section">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-blue-600">Education</h2>
                <button type="button" id="addEducationBtn"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    + Add Education
                </button>
            </div>
            <div id="education_wrapper" class="space-y-6">
                <!-- Education Entries -->
                @php
                    $degrees = old('degree', ['']);
                    $institutions = old('institution', ['']);
                    $start_dates = old('start_date', ['']);
                    $end_dates = old('end_date', ['']);
                @endphp

                @foreach ($degrees as $index => $degree)
                    <div
                        class="education_entry grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8 border border-gray-300 p-5 rounded-md relative bg-gray-50 hover:shadow-lg transition-shadow duration-300">
                        <button type="button" aria-label="Remove education" title="Remove education"
                            class="remove-education absolute top-2 right-2 text-red-600 hover:text-red-800 font-extrabold text-2xl leading-none focus:outline-none">
                            &times;
                        </button>

                        <div>
                            <label for="degree_{{ $index }}" class="block text-sm font-medium text-gray-700">Degree</label>
                            <input type="text" name="degree[]" id="degree_{{ $index }}" autocomplete="off"
                                value="{{ $degree }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('degree.' . $index) border-red-500 @enderror" />
                            @error('degree.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="institution_{{ $index }}"
                                class="block text-sm font-medium text-gray-700">Institution</label>
                            <input type="text" name="institution[]" id="institution_{{ $index }}" autocomplete="off"
                                value="{{ $institutions[$index] ?? '' }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('institution.' . $index) border-red-500 @enderror" />
                            @error('institution.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="start_date_{{ $index }}" class="block text-sm font-medium text-gray-700">Start
                                Date</label>
                            <input type="date" name="start_date[]" id="start_date_{{ $index }}" autocomplete="off"
                                value="{{ $start_dates[$index] ?? '' }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('start_date.' . $index) border-red-500 @enderror" />
                            @error('start_date.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date_{{ $index }}" class="block text-sm font-medium text-gray-700">End
                                Date</label>
                            <input type="date" name="end_date[]" id="end_date_{{ $index }}" autocomplete="off"
                                value="{{ $end_dates[$index] ?? '' }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('end_date.' . $index) border-red-500 @enderror" />
                            @error('end_date.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Experience Section -->
        <section class="px-8 py-6 rounded-lg shadow-md w-full border border-gray-200" id="experience_section">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-blue-600">Experience</h2>
                <button type="button" id="addExperienceBtn"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    + Add Experience
                </button>
            </div>
            <div id="experience_wrapper" class="space-y-6">
                @php
                    $companies = old('company', ['']);
                    $position = old('position', ['']);
                    $start_date_exp = old('start_date_exp', ['']);
                    $end_date_exp = old('end_date_exp', ['']);
                @endphp

                @foreach ($companies as $index => $company)
                    <div
                        class="experience_entry grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8 border border-gray-300 p-5 rounded-md relative bg-gray-50 hover:shadow-lg transition-shadow duration-300">
                        <button type="button" aria-label="Remove experience" position="Remove experience"
                            class="remove-experience absolute top-2 right-2 text-red-600 hover:text-red-800 font-extrabold text-2xl leading-none focus:outline-none">
                            &times;
                        </button>

                        <div>
                            <label for="company_{{ $index }}"
                                class="block text-sm font-medium text-gray-700">Company</label>
                            <input type="text" name="company[]" id="company_{{ $index }}" autocomplete="off"
                                value="{{ $company }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('company.' . $index) border-red-500 @enderror" />
                            @error('company.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position_{{ $index }}"
                                class="block text-sm font-medium text-gray-700">position</label>
                            <input type="text" name="position[]" id="position_{{ $index }}" autocomplete="off"
                                value="{{ $position[$index] ?? '' }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('position.' . $index) border-red-500 @enderror" />
                            @error('position.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="start_date_exp_{{ $index }}" class="block text-sm font-medium text-gray-700">Start
                                Date</label>
                            <input type="date" name="start_date_exp[]" id="start_date_exp_{{ $index }}" autocomplete="off"
                                value="{{ $start_date_exp[$index] ?? '' }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('start_date_exp.' . $index) border-red-500 @enderror" />
                            @error('start_date_exp.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date_exp_{{ $index }}" class="block text-sm font-medium text-gray-700">End
                                Date</label>
                            <input type="date" name="end_date_exp[]" id="end_date_exp_{{ $index }}" autocomplete="off"
                                value="{{ $end_date_exp[$index] ?? '' }}"
                                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('end_date_exp.' . $index) border-red-500 @enderror" />
                            @error('end_date_exp.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description_{{ $index }}"
                                class="block text-sm font-medium text-gray-900">Description</label>
                            <textarea name="description[]" id="description_{{ $index }}" rows="3"
                                class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 @error('description.' . $index) outline-red-500 @enderror">{{ $descriptions[$index] ?? '' }}</textarea>
                            @error('description.' . $index)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="flex flex-col md:flex-row justify-between w-full gap-4">
        <!-- Skills Section -->
        <section class="px-10 py-5 shadow-md w-full md:w-1/2 mt-10" id="skills_section">
            <div class="flex justify-between items-center mb-5">
                <h1 class="text-xl font-bold text-blue-400">Skills</h1>
                <button type="button" id="addSkillBtn"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded">
                    + Add Skill
                </button>
            </div>
            <div id="skill_wrapper" class="mt-10 space-y-6 relative">
                @foreach(old('skills', ['']) as $index => $skill)
                    <div class="skill_entry relative border-2 border-gray-200 p-4 rounded-md">
                        <button type="button"
                            class="remove-skill absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-xl">
                            &times;
                        </button>
                        <label class="block text-sm font-medium text-gray-900">Skills</label>

                        <input type="text" name="skills[]" placeholder="Enter skill" value="{{ $skill }}"
                            class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 @error('skills.' . $index) outline-red-500 @enderror" />
                        @error('skills.' . $index)
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Certifications Section -->
        <section class="px-10 py-5 shadow-md w-full md:w-1/2 mt-10" id="certifications_section">
            <div class="flex justify-between items-center mb-5">
                <h1 class="text-xl font-bold text-blue-400">Certifications</h1>
                <button type="button" id="addCertificationBtn"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded">
                    + Add Certification
                </button>
            </div>
            <div id="certification_wrapper" class="mt-10 space-y-6">
                @foreach(old('certifications', ['']) as $index => $certification)
                    <div class="certification_entry relative border-2 border-gray-200 p-4 rounded-md">
                        <button type="button"
                            class="remove-certification absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-xl">
                            &times;
                        </button>
                        <label class="block text-sm font-medium text-gray-900">Certification Name</label>
                        <input type="text" name="certifications[]" placeholder="Enter certification name"
                            value="{{ $certification }}"
                            class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 @error('certifications.' . $index) outline-red-500 @enderror" />
                        @error('certifications.' . $index)
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        </section>
    </div>


    <!-- Submit Button -->
    <div class="mt-12 flex justify-center w-full">
        <button type="submit"
            class="w-full max-w-md bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300">
            Submit Data
        </button>
    </div>
</form>