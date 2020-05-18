<div id="select-vacancy-container" style="display: none">
    <div class="row">
        <label class="form-label" for="title">Titel:</label>
        <input class="input-round-border vacancy-form" id="vacancyTitle" type="text" name="title"
               placeholder="Voeg titel toe"
               value="{{ old('title') ?? $vacancy->title ?? '' }}" maxlength="45">
    </div>
    @error('title')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="row">
        <label class="form-label" for="number">Aantal:</label>
        <input class="input-round-border vacancy-form" id="vacancyNumber" type="number" name="number"
               placeholder="Aantal" min="1" max="10" onKeyPress="if(this.value.length===2) return false;"
               autocomplete="off"
               value="{{ old('number') ?? $vacancy->people_amount_required ?? ''}}">
    </div>
    @error('number')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="row">
        <label class="form-label label-textarea" for="details">Beschrijving:</label>
        <textarea class="input-round-border vacancy-form" id="vacancyDetails" type="textarea" name="details"
                  placeholder="Typ hier de beschrijving..." onkeypress="if(this.value.length===600) return false;"
                  autocomplete="off">{{ old('details') ?? $vacancy->description ?? ''}}</textarea>
    </div>
    @error('details')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    @if ($vacancy != null)
        <div class="row">
            <label class="form-label" for="is_open">Vacature open:</label>
            <input class="input-round-border vacancy-form  form-checkbox" id="is_open_checkbox" type="checkbox"
                   name="is_open"
                {{ $vacancy != null && $vacancy->is_open == 1 ? 'checked' : '' }}>
        </div>
    @endif

    <div class="vacancy-btn-container">
        @if ($vacancy == null)
            <button type="button" class="delete-btn" onclick="deleteVacancy()">Annuleren</button>
        @endif
        <button type="button" class="regular-btn" onclick="saveVacancy()">bevestigen</button>
    </div>

</div>
