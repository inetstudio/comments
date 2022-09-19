@if ($item->hasMedia('files'))
    @php
        $media = $item->getMedia('files')
    @endphp
    @foreach ($media as $mediaItem)
        @if (in_array($mediaItem->mime_type, ['image/jpeg', 'image/png']))
            <a data-fancybox="carousel-{{ $item['id'] }}" href="{{ url($mediaItem->getUrl()) }}" {!! (! $loop->first) ? 'style="display: none"' : '' !!}>
                <img src="{{ url($mediaItem->getUrl('comment_admin_'.$conversion)) }}" class=" m-b-md img-fluid" alt="comment_image">
            </a>
        @endif
    @endforeach
@endif
