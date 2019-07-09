<div class="i-checks"><input type="checkbox" name="comments[]" class="{{ isset($id) ? 'group-element' : '' }}"
                             id="comment_{{ $id ?? 'all' }}" value="{{ $id ?? 'all' }}"/></div>
