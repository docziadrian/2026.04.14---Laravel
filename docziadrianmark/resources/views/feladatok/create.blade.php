<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Új feladat létrehozása</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <form method="POST" action="{{ route('feladatok.store') }}">
                    @csrf
                    @include('feladatok._form', ['projects' => $projects])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
