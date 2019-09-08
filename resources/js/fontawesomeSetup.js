import { dom, library } from '@fortawesome/fontawesome-svg-core'
import {
    faArrowCircleLeft,
    faArrowUp,
    faArrowDown,
    faUser,
    faChessQueen,
    faChessKnight,
    faChessPawn,
    faSun,
    faMoon,
    faCircle,
    faKey,
    faTimes,
    faAt,
    faUserCheck,
    faUserPlus,
    faSpinner
} from '@fortawesome/free-solid-svg-icons';
import { faGithub } from '@fortawesome/free-brands-svg-icons'

// Load icons present in template, footer and header
library.add(faArrowCircleLeft, faArrowUp, faArrowDown, faUser, faChessQueen, faChessKnight, faChessPawn, faGithub,
    faSun, faMoon, faCircle, faKey, faTimes, faAt, faUserCheck, faUserPlus, faSpinner);
dom.watch();
