// elements selection
let $ = document

const emailInput = $.querySelector('#email-input')
const emailSubmitBtn = $.querySelector('.email-submit-btn')
const emailValidText = $.querySelector('.email-validation-text')
const emailValidArrow = $.querySelector('.email-validation-span')
const emailValidIcon = $.querySelector('.email-valid-icon')

const verifyInput = $.querySelector('#verify-input')
const verifySubmitBtn = $.querySelector('.verify-submit-btn')
const verifyValidText = $.querySelector('.verify-validation-text')
const verifyValidArrow = $.querySelector('.verify-validation-span')
const verifyValidIcon = $.querySelector('.verify-valid-icon')

const editDestInput = $.querySelector('#editDest-input')

// ------------------------------- start user panel scripts -----------------------------

const burgerMenuBtn = $.querySelector('.burger-menu__btn')
const userPanelHeader = $.querySelector('.header')
const burgerMenuDetails = $.querySelector('.right-main-dropdown')
const closeBurgerMenu = $.querySelector('.close-menu__btn')
const bgBlurZindex = $.querySelector('.bg-blur')

var clipboard = new ClipboardJS('.stats-table__copy-btn');

clipboard.on('success', function (e) {
    e.clearSelection();
});

clipboard.on('error', function (e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
});

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

if (burgerMenuBtn) {
    burgerMenuBtn.addEventListener('click', event => {
        userPanelHeader.classList.add('position-absolute')
        burgerMenuDetails.classList.remove('d-none')
        bgBlurZindex.classList.add('z-index-19')
        closeBurgerMenu.classList.remove('d-none')
    })
}

if (closeBurgerMenu) {
    closeBurgerMenu.addEventListener('click', event => {
        userPanelHeader.classList.remove('position-absolute')
        burgerMenuDetails.classList.add('d-none')
        bgBlurZindex.classList.remove('z-index-19')
        closeBurgerMenu.classList.add('d-none')
    })
}

// ------------------------------- start validation scripts -----------------------------

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

function emailCheckOutFalse() {
    emailInput.classList.add('email-red-validation')
    emailValidText.classList.remove('d-none')
    emailValidArrow.classList.remove('d-none')
    emailValidIcon.classList.remove('d-none')
}
function emailCheckOutTrue() {
    // emailInput.classList.remove('email-red-validation')
    emailValidText.classList.add('d-none')
    emailValidArrow.classList.add('d-none')
    // emailValidIcon.classList.add('d-none')
}

function verifyCheckOutFalse() {
    verifyInput.classList.add('verify-red-validation')
    verifyValidText.classList.remove('d-none')
    verifyValidArrow.classList.remove('d-none')
    verifyValidIcon.classList.remove('d-none')
}
function verifyCheckOutTrue() {
    // verifyInput.classList.remove('verify-red-validation')
    verifyValidText.classList.add('d-none')
    verifyValidArrow.classList.add('d-none')
    // verifyValidIcon.classList.add('d-none')
}

if (emailSubmitBtn) {
    emailSubmitBtn.addEventListener('click', (event) => {
        if (emailInput.value.length < 1) {
            event.preventDefault();
            emailCheckOutFalse()
            emailInput.focus()
        } else {
            const emailRegex = /^\w+([\.-]?\w)*@\w+([\.-]?\w)*(\.\w{2,3})+$/;
            let emailTrust = emailRegex.test(emailInput.value)

            if (!emailTrust) {
                event.preventDefault();
                emailCheckOutFalse()
                emailInput.focus()
            }
        }

        emailInput.addEventListener('blur', e => {
            emailValidText.classList.add('d-none')
            emailValidArrow.classList.add('d-none')
        })

        emailInput.addEventListener('keyup', e => {
            if (emailInput.value.length >= 1) {
                emailCheckOutTrue()
                emailInput.classList.add('input-left')
                emailInput.classList.add('input-left-valid')
            } else {
                emailCheckOutFalse()
                emailInput.classList.remove('input-left')
                emailInput.classList.remove('input-left-valid')
            }
        })
    })
}

if (verifySubmitBtn) {
    verifySubmitBtn.addEventListener('click', (event) => {
        if (verifyInput.value.length != 6) {
            event.preventDefault();
            verifyCheckOutFalse()
            verifyInput.focus()
        }

        verifyInput.addEventListener('blur', e => {
            verifyValidText.classList.add('d-none')
            verifyValidArrow.classList.add('d-none')
        })

        verifyInput.addEventListener('keyup', e => {
            if (verifyInput.value.length >= 1) {
                verifyCheckOutTrue()
                verifyInput.classList.add('input-left')
                verifyInput.classList.add('input-left-valid')
            } else {
                verifyCheckOutFalse()
                verifyInput.classList.remove('input-left')
                verifyInput.classList.remove('input-left-valid')
            }
        })
    })
}

if (editDestInput) {
    editDestInput.addEventListener('keyup', event => {
        if (editDestInput.value.length >= 1) {
            editDestInput.classList.add('input-left')
        } else {
            editDestInput.classList.remove('input-left')
        }
    })
}

if (emailInput) {
    emailInput.addEventListener('keypress', event => {
        let word = event.keyCode
        console.log(word)
        if ((word < 65 || word > 90) && (word < 97 || word > 122) && (word < 48 || word > 57) && word != 64 && word != 46) {
            event.preventDefault()
        }
    })
    emailInput.addEventListener('keyup', e => {
        if (emailInput.value.length >= 1) {
            emailInput.classList.add('input-left')
        } else {
            emailInput.classList.remove('input-left')
        }
    })
}

if (verifyInput) {
    verifyInput.addEventListener('keypress', event => {
        let word = event.keyCode
        console.log(word)
        if ((word < 48 || word > 57)) {
            event.preventDefault()
        }
    })
    verifyInput.addEventListener('keyup', e => {
        if (verifyInput.value.length >= 1) {
            verifyInput.classList.add('input-left')
        } else {
            verifyInput.classList.remove('input-left')
        }
    })
}