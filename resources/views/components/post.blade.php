<a href="/post/{{$singularPost->id}}" class="list-group-item list-group-item-action">
    <img class="avatar-tiny" src="{{$singularPost->user->avatar}}" />
    <strong>{{$singularPost->title}}</strong>
    <span class="text-muted small">
        @if(!isset($hideAuthor))
        by {{$singularPost->user->username}}
        @endif
        on {{$singularPost->created_at->format('j/n/Y')}}
    </span>
  </a>
