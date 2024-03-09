

<!-- f($Storage, $report_storage_id): -->
<form>
    <select style="width: 200px;" name="report_storage_id" onchange="this.form.submit()">
        @foreach ($Storage::all() as $storage)
            <option value="{{ $storage->id ?? '' }}">{{ $storage->name }}</option>
        @endforeach

        @php ($first_storage = $Storage::first())
        <option selected="selected" hidden="hidden" value="{{ $report_storage_id ?? $first_storage->id ?? '' }}">
            {{ $Storage::find($report_storage_id)->name ?? $first_storage->name ?? '' }}
        </option>
    </select>
</form>
