<?

function ConvertingSizeValue(int $size)
{
    if ($size < 1024) {
        return $size . ' B';
    } else if ($size < 1048576) {
        return round($size / 1024, 2) . ' KB';
    } else if ($size < 1073741824) {
        return round($size / 1048576, 2) . ' MB';
    } else if ($size < 1099511627776) {
        return round($size / 1073741824, 2) . ' GB';
    } else {
        return round($size / 1099511627776, 2) . ' TB';
    }
}
