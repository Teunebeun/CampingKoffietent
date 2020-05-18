<div id="select-donation-container" style="display: none">
    {{-- needed to reference to the correct row in the left container when updating --}}
    <input type="hidden" name="donationID" id="donationID">

    <div class="row">
        <label class="form-label" for="donation-title">Titel:</label>
        <input class="input-round-border vacancy-form" id="donationTitle" type="text" name="donation-title"
               placeholder="Voeg titel toe"
               value="{{ old('donation-title') }}" maxlength="45">
    </div>
    @error('donation-title')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="row">
        <label class="form-label" for="donation-is_money">Geld donatie:</label>
        <input class="input-round-border activity-form form-checkbox" id="donation-is_money" type="checkbox"
               name="donation-is_money">
    </div>

    <div class="row">
        <label class="form-label" for="donation-item">Voorwerp:</label>
        <input class="input-round-border vacancy-form" id="donationItem" type="text" name="donation-item"
               placeholder="Voeg voorwerp toe"
               value="{{ old('donation-item') }}" maxlength="45">
    </div>
    @error('donation-item')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="row">
        <label class="form-label" for="donation-amount">Aantal nodig:</label>
        <input class="input-round-border vacancy-form" id="donationAmount" type="number" name="donation-amount"
               placeholder="Aantal" onkeypress="if(this.value.length===8) return false;"
               autocomplete="off"
               value="{{ old('donation-amount') }}">
    </div>
    @error('donation-amount')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="row">
        <label class="form-label" for="donation-received">Aantal gedoneerd:</label>
        <input class="input-round-border vacancy-form" id="donationReceived" type="number" name="donation-received"
               placeholder="Aantal" readonly>
    </div>

    <div class="row">
        <label class="form-label label-textarea" for="donation-details">Beschrijving:</label>
        <textarea class="input-round-border vacancy-form" id="donationDetails" type="textarea" name="donation-details"
                  placeholder="Typ hier de beschrijving..." onkeypress="if(this.value.length===255) return false;"
                  autocomplete="off">{{ old('donation-details') }}</textarea>
    </div>
    @error('donation-details')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="vacancy-btn-container">
        <button type="button" class="delete-btn" onclick="emptyDonationForm()">Annuleren</button>
        <button type="button" id="donationSaveBtn" class="regular-btn" onclick="saveDonation()">Bevestigen</button>
    </div>
</div>
