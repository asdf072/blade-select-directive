# blade-select-directive

Two directives to help with select elements in blade.

## @selected($val1, $val2)

```
<select>
    @foreach($items as $item)
        <option value="{{ $item->id }}" @selected($item->id, $test_val) >{{ $item->name }}</option>
    @endforeach
</select>
```

## @options($arr, [$comparison_value], [$display_field])

`$arr` can be single-dimensional array received from `$collection->pluck('name','id')`, etc OR
a collection/array of objects such as Eloquent models. This assumes the display property is
`name`, but can be changed in third parameter. The property to be compared is always assumed
to be `id`.

```
<select>
    @options($items, $selected_val, $shown_property)
</select>
```

## Installation
Custom directives are currently (5.4) stored in the App\Providers\AppServiceProvider::boot() method.
You can copy/paste them there.
