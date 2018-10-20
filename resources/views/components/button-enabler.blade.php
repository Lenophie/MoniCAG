@if(Auth::check())
    @switch($enablerCondition)
        @case(''.\App\UserRole::ADMINISTRATOR)
            @if (Auth::user()->role_id !== \App\UserRole::ADMINISTRATOR)
                disabled=disabled
            @endif
        @break

        @case(''.\App\UserRole::LENDER)
            @if (Auth::user()->role_id !== \App\UserRole::ADMINISTRATOR && Auth::user()->role_id !== \App\UserRole::LENDER)
                disabled=disabled
            @endif
        @break

        @case(''.\App\UserRole::NONE)

        @break

        @default
            disabled=disabled
    @endswitch
@else
    @if($enablerCondition != ''.\App\UserRole::NONE)
        disabled=disabled
    @endif
@endif