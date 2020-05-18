<div id="select-initiative-container" style="display: none">
    <div class="search-bar-container">
        <div class="search-container">
            <div class="search-input">
                <label>
                    <input type="text" class="search-bar" placeholder="&#xF002; Zoek"
                           value="">
                    <button type="button" onclick="filterTable('activities', this)" id="search">></button>
                </label>
            </div>
        </div>
    </div>
    <table class="table">
        <tr>
            <th>Selecteer</th>
            <th>Naam</th>
        </tr>
        @forelse($activities as $activity)
            <tr class="searched">
                <td class="no-link select-container">
                    <label class="switch initiativeSwitch">
                        <input type="radio" value="{{ $activity }}" name="selectedInitiativeAnswer"
                            {{ $activityplanned->activity->id == $activity->id ? 'checked' : '' }}>
                        <i class="gg-checked"></i>
                    </label>
                </td>
                <td><a href="javascript:void(0)" onclick="window.open('{{route("activities.edit", $activity->id)}}');return false;">{{ $activity->name }}</a></td>
            </tr>
        @empty
            <tr class="not-clickable">
                <td colspan="2" rowspan="8">Er zijn geen initiatieven</td>
            </tr>
            @for($i = 0; $i < 7; $i++)
                <tr></tr>
            @endfor
        @endforelse
        <tr class="not-clickable">
            <td colspan="2" class="pagination no-link">
                <nav>
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" id="paginate-prev" href="javascript:void(0)"
                               onclick="paginateTablePrevious('activities')"
                               rel="prev" aria-label="« Vorige">‹</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" id="paginate-next" href="javascript:void(0)"
                               onclick="paginateTableNext('activities')"
                               rel="next" aria-label="Volgende »">›</a>
                        </li>
                    </ul>
                </nav>
            </td>
        </tr>
    </table>
</div>
