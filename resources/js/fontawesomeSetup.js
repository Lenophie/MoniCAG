import {dom, library} from '@fortawesome/fontawesome-svg-core'
import {
    faArrowCircleLeft,
    faArrowDown,
    faArrowUp,
    faAt,
    faChessKnight,
    faChessPawn,
    faChessQueen,
    faCircle,
    faDiceD20,
    faKey,
    faMoon,
    faSpinner,
    faSun,
    faTimes,
    faUser,
    faUserCheck,
    faUserPlus
} from '@fortawesome/free-solid-svg-icons';
import {faGithub} from '@fortawesome/free-brands-svg-icons'

// Load icons present in template, footer and header
library.add(faArrowCircleLeft, faArrowUp, faArrowDown, faUser, faChessQueen, faChessKnight, faChessPawn, faDiceD20,
    faGithub, faSun, faMoon, faCircle, faKey, faTimes, faAt, faUserCheck, faUserPlus, faSpinner);
dom.watch();
