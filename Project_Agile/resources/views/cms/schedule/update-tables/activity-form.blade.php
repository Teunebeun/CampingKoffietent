<div id="select-activityform-container" style="display: none;">
    <div class="row">
        <label class="form-label" for="activityName">Naam:</label>
        <input class="input-round-border activity-form" id="activityName" maxlength="45" type="text" placeholder="Voeg naam toe"
               name="activityName" value="{{ old('activity-name') ?? $activityplanned->name }}" required>
    </div>
    @error('activityName')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror

    <div class="row">
        <label class="form-label" for="activityImage">Foto:</label>
        <input class="activity-form image-activity-form" type="file" name="activityImage" accept="image/*" onchange="readURL(this, 'js-image-onscreen')">
    </div>
    @error('activityImage')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror
    <div class="row">
        <label class="form-label"></label>
        <img id="js-image-onscreen" src="{{ URL::asset($activityplanned->display_picture) }}" width="150px" height="150px">
    </div>

    <div class="row">
        <label class="form-label label-textarea" for="details">Beschrijving:</label>
        <textarea class="input-round-border activity-form" id="activityDetails" type="textarea" name="activityDetails"
                  placeholder="Typ hier de beschrijving..." onkeypress="if(this.value.length===1000) return false;"
                  autocomplete="off">{{ old('activityDetails') ?? $activityplanned->description }}</textarea>
    </div>
    @error('activityDetails')
    <div class="error-row">
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    </div>
    @enderror
</div>
