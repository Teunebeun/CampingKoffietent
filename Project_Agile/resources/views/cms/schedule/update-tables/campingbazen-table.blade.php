<div id="select-campingbazen-container" style="display: none;">
    <div class="search-bar-container">
        <div class="search-container">
            <div class="search-input">
                <label>
                    <input type="text" class="search-bar" placeholder="&#xF002; Zoek"
                           value="">
                    <button type="button" onclick="filterTable('campingbazen', this)" id="search">></button>
                </label>
            </div>
        </div>
    </div>

    <table class="table">
        <tr>
            <th>Selecteer</th>
            <th>Naam</th>
        </tr>
        @forelse($campingbazen as $campingbaas)
            <tr class="searched">
                <td class="no-link select-container">
                    <label class="switch campingbaasSwitch">
                        <input type="checkbox" value="{{ json_encode($campingbaas, true) }}" id="{{ $campingbaas['id'] }}"
                               name="selectedCampingbaasAnswer[]"
                        @forelse($activityplanned->campingbazen as $camp)
                            {{ $camp->id === $campingbaas['id'] ? "checked" : '' }}
                            @empty
                            @endforelse
                        >
                        <i class="gg-checked"></i>
                    </label>
                </td>
                <td>
                    <a href="#">
                        {{
                            $campingbaas['firstname']
                            . ' '
                            . $campingbaas['middlename']
                            . ' '
                            . $campingbaas['lastname']
                        }}
                    </a>
                </td>
            </tr>
        @empty
            <tr class="not-clickable" >
                <td colspan="2" rowspan="8">Er zijn geen campingbazen</td>
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
                               onclick="paginateTablePrevious('campingbazen')" rel="prev"
                               aria-label="« Vorige">‹</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" id="paginate-next" href="javascript:void(0)"
                               onclick="paginateTableNext('campingbazen')" rel="next"
                               aria-label="Volgende »">›</a>
                        </li>
                    </ul>
                </nav>
            </td>
        </tr>
    </table>
</div>
