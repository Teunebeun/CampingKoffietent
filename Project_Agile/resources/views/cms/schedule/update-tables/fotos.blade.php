<div id="select-fotos-container" style="display: none">

    <div class="row" id="cheese">
        <label class="form-label" for="selectFoto">Selecteer foto's</label>
    </div>

    <table class="table">
        <tr>
            <th class="delete-container">Verwijder</th>
            <th>foto</th>
        </tr>
        @forelse($activityplanned->activityPictures as $picture)
            <tr class="searched">
                <td class="no-link delete-container">
                    <label class="switch">
                        <i class="gg-delete old-image"></i>
                    </label>
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="window.open('{{ URL::asset($picture->picture) }}')">
                        {{ preg_split('/^([0-9]+-)/', @end(explode('/', $picture->picture)), -1, PREG_SPLIT_NO_EMPTY)[0] }}
                        <input type="text" name="old-pictures[]" value="{{ $picture->picture }}" hidden>
                    </a>
                </td>
            </tr>
        @empty
        @endforelse
    </table>
</div>
