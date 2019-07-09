<input type="checkbox" name="comments[]" id="active_{{ $id }}" value="{{ $id }}" class="switchery"
       data-target="{{ route('back.comments.moderate.activity') }}" {{ ($is_active) ? 'checked' : '' }} />
