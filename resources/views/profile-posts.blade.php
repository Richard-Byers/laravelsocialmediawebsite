<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Profile">
    <div class="list-group">
        @foreach($posts as $singularPost)
        <x-post :singularPost=$singularPost hideAuthor/>
        @endforeach
    </div>
</x-profile>
