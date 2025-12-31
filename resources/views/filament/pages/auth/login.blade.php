<div class="flex min-h-screen items-center bg-white dark:bg-gray-950">
    <div class="hidden h-screen w-1/2 lg:block">
        <img src="{{ $this->getImage() }}" alt="Login Image" class="h-full w-full object-cover">
    </div>
    <div class="flex h-screen w-full flex-col justify-center px-8 py-12 lg:w-1/2 lg:px-20">
        <div class="mx-auto w-full max-w-md">
            <div class="mb-10 text-center lg:text-left">
                <div class="lg:hidden flex justify-center mb-6">
                    <img src="{{ asset('images/HRIS-PRO.svg') }}" class="h-10" alt="Logo">
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ $this->getHeading() }}
                </h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 font-medium italic">
                    {{ $this->getSubheading() }}
                </p>
            </div>
            <div class="fi-auth-form-container">
                {{ $this->content }}
            </div>
        </div>
    </div>
</div>
