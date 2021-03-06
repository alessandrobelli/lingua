<div class="inline-block">
    <div class="bg-gray-200 w-64 p-2 rounded inline-block align-top">
        <h1 class="text-2xl font-bold opacity-75 text-base text-gray-800">{{__('List of Languages')}}</h1>
        <p class="text-base mb-2 opacity-75 text-base text-gray-900">{{__('2. Add Locale')}}</p>
        @foreach($locales as $locale)
            <div class="inline-flex bg-gray-200 border-l-4 border-gray-800 text-black px-4 py-3">
                <p class="inline-block mr-2">{{$locale}}</p>
                <button class="bg-red-700 hover:bg-red-900 inline-block p-1 justify-end"
                        wire:click="$emit('confirmDelete','locale','{{$locale}}','{{implode(",",$locales)}}','The translation file will be also deleted.')"
                >
                    <svg class="fill-current text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M20 4h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711v2zm-7 15.5c0-1.267.37-2.447 1-3.448v-6.052c0-.552.447-1 1-1s1 .448 1 1v4.032c.879-.565 1.901-.922 3-1.006v-7.026h-18v18h13.82c-1.124-1.169-1.82-2.753-1.82-4.5zm-7 .5c0 .552-.447 1-1 1s-1-.448-1-1v-10c0-.552.447-1 1-1s1 .448 1 1v10zm5 0c0 .552-.447 1-1 1s-1-.448-1-1v-10c0-.552.447-1 1-1s1 .448 1 1v10zm13-.5c0 2.485-2.017 4.5-4.5 4.5s-4.5-2.015-4.5-4.5 2.017-4.5 4.5-4.5 4.5 2.015 4.5 4.5zm-3.086-2.122l-1.414 1.414-1.414-1.414-.707.708 1.414 1.414-1.414 1.414.707.708 1.414-1.414 1.414 1.414.708-.708-1.414-1.414 1.414-1.414-.708-.708z"/>
                    </svg>
                </button>
            </div>
        @endforeach


        <div class="w-auto block  my-4">

            <label class="block text-gray-700 text-sm font-bold mb-2" for="locale">
                Language
            </label>
            <div class="relative">
                <select name="locale" wire:model="localeToAdd"
                        class="bg-white block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-gray-500 @error('localeToAdd') border-red-800 @enderror">
                    @foreach(config('lingua.locales-list') as $value)
                        <option value="{{$value['locale']}}">{{$value['isolanguagename']}} - {{$value['nativename']}} - {{$value['locale']}}</option>
                    @endforeach
                </select>
                <div class="inset-y-0 right-0
                 pointer-events-none absolute  flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>


        </div>
        <div class="w-full block my-4">
            <a role="button" class="bg-blue-900 border-blue-800 py-2 px-4 font-bold hover:bg-blue-700 text-white {{($translationsCount > 0) ? '' : 'opacity-50 cursor-not-allowed hover:bg-blue-900'}}" wire:click="addLocale()">
                {!! __('Add&nbsp;Locale') !!}</a>
        </div>

        @error('localeToAdd')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            </span>
        </div>
        @enderror
    </div>
    <div class="bg-gray-200 w-64 p-2 rounded inline-block">
        <h1 class="text-2xl font-bold text-gray-800 opacity-75">Files</h1>
        <p class="text-base opacity-75 text-base text-gray-900">{{__('3. Build json files: this will enable the translation on the website with the current translations.')}}</p>

        <div class="block my-4">
            <a role="button" class="bg-blue-900 border-blue-800 py-2 px-4 font-bold hover:bg-blue-700 text-white select-none" wire:click="buildJson()">{{__('Build Json Files')}}</a>
        </div>
        <livewire:export-to-csv>

            <div wire:loading wire:target="buildJson,addLocale" class="w-full h-full fixed block top-0 left-0 bg-indigo-200 opacity-75 z-50 text-center align-center">
                <div class="absolute inset-0 flex items-center justify-center ">
                    <span class="lds-dual-ring"></span>
                </div>

            </div>
    </div>
    <div class="bg-gray-200 w-64 p-2 rounded inline-block align-top">
        <h1 class="text-2xl font-bold text-gray-800 opacity-75">List of translation files.</h1>


        @if(count(File::files(resource_path() . "/lang/")))
            <div class="bg-gray-800 p-2 text-gray-100 font-serif text-xs overflow-x-scroll text-center">
                {{strlen(resource_path()) > 19 ? "...".substr(resource_path(),3,strlen(resource_path())): resource_path()}}
            </div>
            <div class="bg-white p-2 overflow-x-scroll whitespace-no-wrap divide-y">
                @foreach(File::files(resource_path() . "/lang/") as $file)
                    <div class="block py-2">
                        {{$file->getBasename()}} -
                        {{alessandrobelli\Lingua\LinguaUtilities::array_multidimensional_search(config('lingua.locales-list'),'locale',$file->getFilenameWithoutExtension())[0]['isolanguagename']}}
                    </div>
                @endforeach
            </div>
            <div class="block my-4">
                <a role="button" class="bg-blue-900 border-blue-800 py-2 px-4 font-bold hover:bg-blue-700 text-white select-none" wire:click="downloadjsons()">{{__('Download Json Files')}}</a>
            </div>
        @endif
    </div>
</div>
