@if($role_id == ''.\App\UserRole::ADMINISTRATOR)
    <i class="fas fa-chess-queen"></i>
@elseif($role_id == ''.\App\UserRole::LENDER)
    <i class="fas fa-chess-knight"></i>
@elseif($role_id == ''.\App\UserRole::NONE)
    <i class="fas fa-chess-pawn"></i>
@elseif($role_id == ''.\App\UserRole::SUPER_ADMINISTRATOR)
    <i class="fas fa-dice-d20"></i>
@endif
