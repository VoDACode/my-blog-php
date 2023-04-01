<div class="file">
    <div class="file-type">
        <img src="{{ URL::asset('img/file.png') }}">
    </div>
    <div class="name">
        <a href="/fs/d?id={{ $file['id'] }}">{{ $file['name'] }}</a>
    </div>
    <div class="size">
        <p>{{ ConvertingSizeValue($file['size']) }}</p>
    </div>
</div>
