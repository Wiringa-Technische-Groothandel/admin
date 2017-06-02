<form class="form form-horizontal" method="post">
    {{ csrf_field() }}
    {{ method_field('patch') }}

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">{{ trans('admin::manager.form.username') }}</label>
        <div class="col-sm-9">
            <input placeholder="{{ trans('admin::manager.form.username') }}" name="username"
                   value="{{ old('username', $customer->getUsername()) }}" class="form-control" required />
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">{{ trans('admin::manager.form.email') }}</label>
        <div class="col-sm-9">
            <input placeholder="{{ trans('admin::manager.form.email') }}" name="email" type="email"
                   value="{{ old('email', $customer->getEmail()) }}" class="form-control" required />
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-sm-3 control-label">{{ trans('admin::manager.form.password') }}</label>
        <div class="col-sm-9">
            <input placeholder="{{ trans('admin::manager.form.password') }}" name="password"
                   class="form-control" type="password" oninput="checkPasswordConfirmation(this)" />
            <span class="help-block">{{ trans('admin::manager.form.update_password_help') }}</span>
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
                    <input type="checkbox" name="manager" {{ old('manager', $customer->getManager()) ? 'checked' : '' }}> {{ trans('admin::manager.form.manager') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="active" {{ old('active', $customer->getActive()) ? 'checked' : '' }}> {{ trans('admin::manager.form.active') }}
                </label>
            </div>
        </div>
    </div>

    <br />

    <div class="form-group">
        <div class="col-sm-3">
            @if ($customer->getIsMain())
                <button type="button" class="btn btn-danger disabled" data-toggle="tooltip" data-placement="bottom"
                        title="{{ trans('admin::manager.form.main_account_warning') }}" data-toggle="modal"
                        data-target="#delete-account-modal">
                    {{ trans('admin::manager.form.delete') }}
                </button>
            @else
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-account-modal">
                    {{ trans('admin::manager.form.delete') }}
                </button>
            @endif
        </div>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-success">{{ trans('admin::manager.form.save') }}</button>

            <a href="{{ route('admin::manager.edit', ['companyId' => $company->getId()]) }}" class="btn btn-default pull-right">
                {{ trans('admin::manager.text.back') }}
            </a>
        </div>
    </div>
</form>

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