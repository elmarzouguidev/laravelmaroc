<div>
    <div class="relative items-center w-full px-5 py-10 mx-auto md:px-12 lg:px-24 max-w-7xl">
        <h1
            class="text-5xl md:text-6xl lg:text-7xl px-10 text-center leading-tight text-red-600 font-bold tracking-tighter mt-20 cursor-pointer">
            <span class="hover:underline transition duration-200 ease-in-out uppercase">{{ __('Blog') }}</span>
        </h1>
        <p class="text-2xl font-light text-gray-400 text-center my-4">{{ __('Browse the latest news & blog posts') }}</p>
        <div class="container mx-auto py-4">
            <div class="flex justify-center gap-4 mt-2">
                <button
                    class="px-4 py-2 text-sm font-semibold text-red-500 border-2 border-red-500 rounded-full hover:bg-red-500 hover:text-white focus:outline-none focus:bg-red-500 focus:text-white"
                    wire:click="$emit('categorySelected', null)">
                    {{ __('All') }}
                </button>
                @foreach ($this->categories as $category)
                    <button
                        class="px-4 py-2 text-sm font-semibold text-red-500 border-2 border-red-500 rounded-full hover:bg-red-500 hover:text-white focus:outline-none focus:bg-red-500 focus:text-white"
                        wire:click="$emit('categorySelected', {{ $category->id }})">
                        {{ $category->title }}
                    </button>
                @endforeach
            </div>

            <div class="flex flex-row gap-4 sm:flex-col my-6 py-10">
                @foreach ($blogs as $blog)
                    <div class="w-full md:w-1/2 px-4 mb-8 bg-white">
                        <a class="block mb-6 overflow-hidden rounded-md" href="{{ route('front.blogPage', $blog->id) }}"
                            <img class="w-full" src="{{ asset('uploads/blogs/' . $blog->image) }}"
                            alt="{{ $blog->title }}">
                        </a>
                        <a class="inline-block mb-4 text-2xl leading-tight text-gray-800 hover:text-gray-900 font-bold hover:underline"
                            href="#">
                            {{ $blog->title }}
                        </a>
                        <p class="mb-4 text-base md:text-sm text-gray-400 font-medium">
                            {!! $blog->description !!}
                        </p>
                        <a class="inline-flex items-center text-base md:text-lg text-red-500 hover:text-red-600 font-semibold mb-4"
                            href="{{ route('front.blogPage', $blog->id) }}">
                            <span class="mr-3">{{ __('Read Post') }}</span>
                            <svg width="8" height="10" viewbox="0 0 8 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.94667 4.74665C7.91494 4.66481 7.86736 4.59005 7.80666 4.52665L4.47333 1.19331C4.41117 1.13116 4.33738 1.08185 4.25617 1.04821C4.17495 1.01457 4.08791 0.997253 4 0.997253C3.82246 0.997253 3.6522 1.06778 3.52667 1.19331C3.46451 1.25547 3.4152 1.32927 3.38156 1.41048C3.34792 1.4917 3.33061 1.57874 3.33061 1.66665C3.33061 1.84418 3.40113 2.01445 3.52667 2.13998L5.72667 4.33331H0.666667C0.489856 4.33331 0.320286 4.40355 0.195262 4.52858C0.070238 4.6536 0 4.82317 0 4.99998C0 5.17679 0.070238 5.34636 0.195262 5.47138C0.320286 5.59641 0.489856 5.66665 0.666667 5.66665H5.72667L3.52667 7.85998C3.46418 7.92196 3.41458 7.99569 3.38074 8.07693C3.34689 8.15817 3.32947 8.24531 3.32947 8.33331C3.32947 8.42132 3.34689 8.50846 3.38074 8.5897C3.41458 8.67094 3.46418 8.74467 3.52667 8.80665C3.58864 8.86913 3.66238 8.91873 3.74361 8.95257C3.82485 8.98642 3.91199 9.00385 4 9.00385C4.08801 9.00385 4.17514 8.98642 4.25638 8.95257C4.33762 8.91873 4.41136 8.86913 4.47333 8.80665L7.80666 5.47331C7.86736 5.40991 7.91494 5.33515 7.94667 5.25331C8.01334 5.09101 8.01334 4.90895 7.94667 4.74665Z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</div>
