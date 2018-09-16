<form method="POST" action="/new-borrowing" id="new-borrowing-form">
    @csrf
    <div class="form-group" id="form-field-startDate">
        <label for="startDate">Date d'emprunt</label>
        <span class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </span>
            <input type="text" id="startDate" name="startDate" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" value={{Carbon\Carbon::now()->format('d/m/Y')}} required>
        </span>
    </div>
    <div class="form-group" id="form-field-expectedReturnDate">
        <label for="expectedReturnDate">Date de retour prévu</label>
        <span class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </span>
            <input type="text" id="expectedReturnDate" name="expectedReturnDate" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" required>
        </span>
    </div>
    <div class="form-group" id="form-field-guarantee">
        <label for="guarantee">Caution</label>
        <span class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
            </span>
            <input type="text" id="guarantee" name="guarantee" class="form-control" pattern="[0-9]+([.,][0-9][0-9]?)?" required>
        </span>
    </div>
    <div class="form-group" id="form-field-notes">
        <label for="notes">Notes</label>
        <textarea class="form-control" id="notes" name="notes" placeholder="Ce champ est utilisé pour préciser des circonstances d'emprunt particulières (WEI, soirée...).&#10;Ces notes doivent concerner l'emprunt plutôt que les jeux empruntés." rows="2"></textarea>
    </div>
    <div class="form-check" id="form-field-agreementCheck1">
        <input type="checkbox" class="form-check-input" id="agreementCheck1" name="agreementCheck1" required>
        <label class="form-check-label" for="agreementCheck1">Je m'engage à dédommager à hauteur de 10 euros le club jeux en cas de détérioration d'un jeu emprunté ou de perte de pièces.</label>
    </div>
    <div class="form-check" id="form-field-agreementCheck2">
        <input type="checkbox" class="form-check-input" id="agreementCheck2" name="agreementCheck2" required>
        <label class="form-check-label" for="agreementCheck2">Je m'engage à rembourser intégralement tout jeu emprunté s'il est perdu.</label>
    </div>
</form>