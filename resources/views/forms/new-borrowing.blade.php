<form method="POST" action="/new-borrowing" id="new-borrowing-form">
    @csrf
    @include('authentications/borrower')
    <div class="form-group" id="form-field-startDate">
        <label for="startDate">{{__('Borrowing date')}}</label>
        <span class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fa-layers fa-fw menu-icon">
                        <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-calendar-alt"></i>
                        <i class="fas fa-arrow-right" data-fa-transform="shrink-9 down-5 right-8"></i>
                    </span>
                </span>
            </span>
            <input type="text" id="startDate" name="startDate" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" value={{Carbon\Carbon::now()->format('d/m/Y')}} required>
        </span>
    </div>
    <div class="form-group" id="form-field-expectedReturnDate">
        <label for="expectedReturnDate">{{__('Expected return date')}}</label>
        <span class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fa-layers fa-fw menu-icon">
                        <i class="fas fa-circle" data-fa-transform="shrink-7 down-5 right-8" data-fa-mask="fas fa-calendar-alt"></i>
                        <i class="fas fa-arrow-left" data-fa-transform="shrink-9 down-5 right-8"></i>
                    </span>
                </span>
            </span>
            <input type="text" id="expectedReturnDate" name="expectedReturnDate" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" required>
        </span>
    </div>
    <div class="form-group" id="form-field-guarantee">
        <label for="guarantee">{{__('Guarantee')}}</label>
        <span class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
            </span>
            <input type="text" id="guarantee" name="guarantee" class="form-control" pattern="[0-9]+([.,][0-9][0-9]?)?" value="10.00" required>
        </span>
    </div>
    <div class="form-group" id="form-field-notes">
        <label for="notes">{{__('Notes')}}</label>
        <textarea class="form-control" id="notes" name="notes" placeholder="{{__('messages.new_borrowing.notes_placeholder')}}" rows="2"></textarea>
    </div>
    <div class="form-check" id="form-field-agreementCheck1">
        <input type="checkbox" class="form-check-input" id="agreementCheck1" name="agreementCheck1" required>
        <label class="form-check-label" for="agreementCheck1">{{__('messages.new_borrowing.agreement_compensation')}}.</label>
    </div>
    <div class="form-check" id="form-field-agreementCheck2">
        <input type="checkbox" class="form-check-input" id="agreementCheck2" name="agreementCheck2" required>
        <label class="form-check-label" for="agreementCheck2">{{__('messages.new_borrowing.agreement_reimbursement')}}.</label>
    </div>
</form>