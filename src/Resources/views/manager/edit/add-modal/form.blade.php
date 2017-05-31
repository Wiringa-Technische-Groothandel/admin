<div class="form-group">
    <label for="username" class="col-sm-3 control-label">{{ trans('admin::manager.form.username') }}</label>
    <div class="col-sm-9">
        <input placeholder="{{ trans('admin::manager.form.username') }}" name="username"
               value="{{ old('username') }}" class="form-control" required />
    </div>
</div>

<div class="form-group">
    <label for="email" class="col-sm-3 control-label">{{ trans('admin::manager.form.email') }}</label>
    <div class="col-sm-9">
        <input placeholder="{{ trans('admin::manager.form.email') }}" name="email" type="email"
               value="{{ old('email') }}" class="form-control" required />
    </div>
</div>

<div class="form-group">
    <label for="password" class="col-sm-3 control-label">{{ trans('admin::manager.form.password') }}</label>
    <div class="col-sm-9">
        <input placeholder="{{ trans('admin::manager.form.password') }}" name="password"
               class="form-control" type="password" oninput="checkPasswordConfirmation(this)" />
        <span class="help-block">{{ trans('admin::manager.form.optional_password_help') }}</span>
    </div>
</div>

<div class="form-group hidden" id="password-confirmation">
    <label for="password_confirmation" class="col-sm-3 control-label">{{ trans('admin::manager.form.password_verification') }}</label>
    <div class="col-sm-9">
        <input placeholder="{{ trans('admin::manager.form.password_verification') }}" name="password_confirmation"
               class="form-control" type="password" />
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="manager" {{ old('manager') ? 'checked' : '' }}> {{ trans('admin::manager.form.manager') }}
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="active" {{ old('active') ? 'checked' : '' }}> {{ trans('admin::manager.form.active') }}
            </label>
        </div>
    </div>
</div>

<script>
    var $passwordConfirmation = document.getElementById('password-confirmation');

    /**
     * Check if the password confirmation needs to be shown.
     *
     * @param target
     */
    function checkPasswordConfirmation (target) {
        var password = target.value;

        if (password.length > 0) {
            $passwordConfirmation.classList.remove('hidden');
        } else {
            $passwordConfirmation.classList.add('hidden');
        }
    }
</script>