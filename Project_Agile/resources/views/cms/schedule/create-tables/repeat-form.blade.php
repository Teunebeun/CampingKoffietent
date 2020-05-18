<div id="select-repeat-container" style="display: none">
    <div class="row">
        <label class="form-label" for="is-repeated">Herhaal initiatief:</label>
        <input class="input-round-border activity-form form-checkbox" id="is-repeated" type="checkbox"
               name="is-repeated">
    </div>
    @error('is-repeated')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="row">
        <label class="form-label" for="repeatAmount">Aantal weken:</label>
        <input class="input-round-border activity-form" id="repeatAmount" type="number"
               name="repeatAmount" onkeypress="if(this.value.length===2) return false;"
               autocomplete="off" value="10" readonly>
        <button type="button" class="max-btn regular-btn" id="max-btn" onclick="maxBtnHandler()" disabled>Max</button>
    </div>
    @error('repeatAmount')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror
</div>
