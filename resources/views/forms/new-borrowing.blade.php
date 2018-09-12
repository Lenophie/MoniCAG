<form>
    <div class="form-group">
        <label for="startDate">Date d'emprunt</label>
        <span class="input-group">
            <input type="text" id="startDate" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" value={{Carbon\Carbon::now()->format('d/m/Y')}}>
            <span class="input-group-append">
                <button class="btn btn-new-borrowing" type="button"><i class="fas fa-calendar-alt"></i></button>
            </span>
        </span>
    </div>
    <div class="form-group">
        <label for="expectedReturnDate">Date de retour prévu</label>
        <span class="input-group">
            <input type="text" id="expectedReturnDate" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY">
            <span class="input-group-append">
                <button class="btn btn-new-borrowing" type="button"><i class="fas fa-calendar-alt"></i></button>
            </span>
        </span>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="agreementCheck1">
        <label class="form-check-label" for="agreementCheck1">Je m'engage à dédommager à hauteur de 10 euros le club jeux en cas de détérioration d'un jeu emprunté ou de perte de pièces.</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="agreementCheck2">
        <label class="form-check-label" for="agreementCheck2">Je m'engage à rembourser intégralement tout jeu emprunté s'il est perdu.</label>
    </div>
</form>