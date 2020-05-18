<div id="select-application-container" style="display: none">
    <div class="search-bar-container">
        <div class="search-container">
            <div class="search-input">
                <label>
                    <input type="text" class="search-bar" placeholder="&#xF002; Zoek"
                           value="">
                    <button type="button" onclick="filterTable('applications', this)" id="search">></button>
                </label>
            </div>
        </div>
    </div>

    <table class="table">
        <tr>
            <th>Selecteer</th>
            <th>Naam</th>
        </tr>
        @forelse($vacancy->applications as $application)
            @if($application->is_accepted == 0)
                <tr class="searched">
                    <td class="no-link select-container">
                        <label class="switch applicationSwitch">
                            <input type="checkbox" value="{{ $application }}" id="{{ $application->id }}"
                                   name="selectedApplicationAnswer[]"
                                {{ old('selectedApplicationAnswer') != null &&
                                 in_array($application->id, array_column(old('selectedApplicationAnswer'), 'id')) ? 'checked' : '' }}>
                            <i class="gg-checked"></i>
                        </label>
                    </td>
                    <td>
                        <a href="javascript:void(0)" onclick="window.open('{{route("cms-vacancy.show", $application->id)}}');return false;">
                            {{
                                $application->firstname
                                . ' '
                                . $application->middlename
                                . ' '
                                . $application->lastname
                            }}
                        </a>
                    </td>
                </tr>
            @endif
        @empty
            <tr class="not-clickable">
                <td colspan="2" rowspan="8">Er zijn geen aanmeldingen</td>
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
                               onclick="paginateTable('applications')" rel="prev"
                               aria-label="« Vorige">‹</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" id="paginate-next" href="javascript:void(0)"
                               onclick="paginateTable('applications')" rel="next"
                               aria-label="Volgende »">›</a>
                        </li>
                    </ul>
                </nav>
            </td>
    </table>
</div>
