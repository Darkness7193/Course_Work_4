

<!-- f($Storage, $storage_id_of_report): -->
<form>
    <select style="width: 200px;" name="storage_id_of_report" onchange="this.form.submit()">
        @foreach ($Storage::all() as $storage)
            <option value="{{ $storage->id ?? '' }}">{{ $storage->name }}</option>
        @endforeach

        @php ($first_storage = $Storage::first())
        <option selected="selected" hidden="hidden" value="{{ $storage_id_of_report ?? $first_storage->id ?? '' }}">
            {{ $Storage::find($storage_id_of_report)->name ?? $first_storage->name ?? '' }}
        </option>
    </select>
</form>
