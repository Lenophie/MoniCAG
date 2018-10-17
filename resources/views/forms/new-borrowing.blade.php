<form method="POST" action="/new-borrowing" id="new-borrowing-form" autocomplete="off">
    @csrf
    <h5 class="title is-5">{{__('Borrower')}}</h5>
    <div class="field" id="form-field-borrowerEmail">
        <label class="label" for="borrowerEmail">{{__('E-mail address')}}</label>
        <div class="control has-icons-left">
            <input class="input" type="text" id="borrowerEmail" name="borrowerEmail" required>
            <span class="icon is-small is-left">
                <i class="fas fa-at"></i>
            </span>
        </div>
    </div>
    <div class="field" id="form-field-borrowerPassword">
        <label class="label" for="borrowerPassword">{{__('Password')}}</label>
        <div class="control has-icons-left">
            <input class="input" type="password" id="borrowerPassword" name="borrowerPassword" required>
            <span class="icon is-small is-left">
                <i class="fas fa-key"></i>
            </span>
        </div>
    </div>
    <hr>
    <h5 class="title is-5">{{__('Terms')}}</h5>
    <div class="field" id="form-field-expectedReturnDate">
        <label class="label" for="expectedReturnDate">{{__('Expected return date')}}</label>
        <div class="control has-icons-left">
            <input class="input" type="date" id="expectedReturnDate" name="expectedReturnDate" required>
            <span class="icon is-small is-left">
                <span class="fa-layers fa-fw menu-icon">
                    <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-calendar-alt"></i>
                    <i class="fas fa-arrow-left" data-fa-transform="shrink-9 down-5 right-8"></i>
                </span>
            </span>
        </div>
    </div>
    <div class="field" id="form-field-guarantee">
        <label class="label" for="guarantee">{{__('Guarantee')}}</label>
        <div class="control has-icons-left">
            <input class="input" type="text" id="guarantee" name="guarantee" pattern="[0-9]+([.,][0-9][0-9]?)?" value="10.00" required>
            <span class="icon is-small is-left">
                <i class="fas fa-euro-sign"></i>
            </span>
        </div>
    </div>
    <div class="field" id="form-field-notes">
        <label class="label" for="notes">{{__('Notes')}}</label>
        <div class="control">
            <textarea class="textarea" id="notes" name="notes" placeholder="{{__('messages.new_borrowing.notes_placeholder')}}" rows="3"></textarea>
        </div>
    </div>
    <div class="form-check" id="form-field-agreementCheck1">
        <input type="checkbox" id="agreementCheck1" name="agreementCheck1" required>
        <label for="agreementCheck1">{{__('messages.new_borrowing.agreement_compensation')}}.</label>
    </div>
    <div class="form-check" id="form-field-agreementCheck2">
        <input type="checkbox" id="agreementCheck2" name="agreementCheck2" required>
        <label for="agreementCheck2">{{__('messages.new_borrowing.agreement_reimbursement')}}.</label>
    </div>
</form>