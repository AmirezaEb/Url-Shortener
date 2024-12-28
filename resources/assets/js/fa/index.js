// elements selection
let $ = document

const firstCog = $.querySelector('.cog')
const secondCog = $.querySelector('.right-cog')

// email page elements
const emailInput = $.querySelector('#email-input')
const emailSubmitBtn = $.querySelector('.email-submit-btn')
const emailValidText = $.querySelector('.email-validation-text')
const emailValidArrow = $.querySelector('.email-validation-span')
const emailValidIcon = $.querySelector('.email-valid-icon')
let emailFlag = false

// verify code page elements
const verifyInput = $.querySelector('#verify-input')
const verifySubmitBtn = $.querySelector('.verify-submit-btn')
const verifyValidText = $.querySelector('.verify-validation-text')
const verifyValidArrow = $.querySelector('.verify-validation-span')
const verifyValidIcon = $.querySelector('.verify-valid-icon')
let verifyFlag = false

// edit URL page elements
const editDestInput = $.querySelector('#editDest-input')
const editUrlSubmitBtn = $.querySelector('.editDest-submit-btn')
const editValidText = $.querySelector('.edit-validation-text')
const editValidArrow = $.querySelector('.edit-validation-span')
const editValidIcon = $.querySelector('.edit-valid-icon')
let editFlag = false


const inputField = document.querySelector('#input-field');
const inputFieldUrlSubmitBtn = document.querySelector('.sub-create');
const inputFieldValidText = document.querySelector('.verify-validation-text-Url');
const inputFieldValidArrow = document.querySelector('.verify-validation-span-Url');
const inputFieldValidIcon = document.querySelector('.verify-valid-icon-Url');
let inputFieldFlagUrl = false;



if (firstCog) {
    // cog of error 404, 405, 500 page
    let leftCog = gsap.timeline();

    leftCog.to(".cog",
        {
            transformOrigin: "50% 50%",
            rotation: "+=360",
            repeat: -1,
            ease: Linear.easeNone,
            duration: 8
        }
    );
}

if (secondCog) {
    // cog of error 500 page
    let rightCog = gsap.timeline();

    rightCog.to(".right-cog",
        {
            transformOrigin: "50% 50%",
            rotation: "-=360",
            repeat: -1,
            ease: Linear.easeNone,
            duration: 8
        }
    );
}

// ------------------------------- start user panel scripts -----------------------------

const burgerMenuBtn = $.querySelector('.burger-menu__btn')
const userPanelHeader = $.querySelector('.header')
const burgerMenuDetails = $.querySelector('.right-main-dropdown')
const closeBurgerMenu = $.querySelector('.close-menu__btn')
const bgBlurZindex = $.querySelector('.bg-blur')

if ($.querySelector('.stats-table__copy-btn')) {
    // use clipboaard to copy from page
    var clipboard = new ClipboardJS('.stats-table__copy-btn');

    clipboard.on('success', function (e) {
        e.clearSelection();
    });

    clipboard.on('error', function (e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
}

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

if (burgerMenuBtn) {
    // open button for panel burger menu
    burgerMenuBtn.addEventListener('click', event => {
        userPanelHeader.classList.add('position-absolute')
        burgerMenuDetails.classList.remove('d-none')
        bgBlurZindex.classList.add('z-index-19')
        closeBurgerMenu.classList.remove('d-none')
    })
}

if (closeBurgerMenu) {
    // close button for panel burger menu
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
    // add validation message to verify code input
    emailInput.classList.add('email-red-validation')
    emailValidText.classList.remove('d-none')
    emailValidArrow.classList.remove('d-none')
    emailValidIcon.classList.remove('d-none')

    emailInput.focus()

    // check for d-none validation texts
    emailInput.addEventListener('blur', e => {
        emailValidText.classList.add('d-none')
        emailValidArrow.classList.add('d-none')
    })

    // check for show email page validation
    emailInput.addEventListener('keyup', e => {
        if (emailInput.value.length >= 1) {
            if (!emailFlag) {
                emailCheckOutTrue()
            }
        } else {
            emailCheckOutFalse()
        }
    })
}
function emailCheckOutTrue() {
    // check to delete validation message
    emailValidText.classList.add('d-none')
    emailValidArrow.classList.add('d-none')
}

function verifyCheckOutFalse() {
    // add validation message to verify code input
    verifyInput.classList.add('verify-red-validation')
    verifyValidText.classList.remove('d-none')
    verifyValidArrow.classList.remove('d-none')
    verifyValidIcon.classList.remove('d-none')

    verifyInput.focus()

    // check for d-none validation texts
    verifyInput.addEventListener('blur', e => {
        verifyValidText.classList.add('d-none')
        verifyValidArrow.classList.add('d-none')
    })

    // check for show verify code page validation
    verifyInput.addEventListener('keyup', e => {
        if (verifyInput.value.length >= 1) {
            if (!verifyFlag) {
                verifyCheckOutTrue()
            }
        } else {
            verifyCheckOutFalse()
        }
    })
}
function verifyCheckOutTrue() {
    // check to delete validation message
    verifyValidText.classList.add('d-none')
    verifyValidArrow.classList.add('d-none')
}

function editCheckOutFalse() {
    // add validation message to edit Url input
    editDestInput.classList.add('verify-red-validation')
    editValidText.classList.remove('d-none')
    editValidArrow.classList.remove('d-none')
    editValidIcon.classList.remove('d-none')

    editDestInput.focus()

    // check for d-none validation texts
    editDestInput.addEventListener('blur', e => {
        editValidText.classList.add('d-none')
        editValidArrow.classList.add('d-none')
    })

    // check for show edit Url page validation
    editDestInput.addEventListener('keyup', e => {
        if (editDestInput.value.length >= 1) {
            if (!editFlag) {
                editCheckOutTrue()
            }
        } else {
            editCheckOutFalse()
        }
    })
}

function editCheckOutInputTrue() {
    // check to delete validation message
    inputFieldValidText.classList.add('d-none')
    inputFieldValidArrow.classList.add('d-none')
}

function editCheckOutInputFalse() {
    // add validation message to edit Url input
    inputField.classList.add('verify-red-validation')
    inputFieldValidText.classList.remove('d-none')
    inputFieldValidArrow.classList.remove('d-none')
    inputFieldValidIcon.classList.remove('d-none')

    inputField.focus()

    // check for d-none validation texts
    inputField.addEventListener('blur', e => {
        editValidText.classList.add('d-none')
        editValidArrow.classList.add('d-none')
    })

    // check for show edit Url page validation
    inputField.addEventListener('keyup', e => {
        if (inputField.value.length >= 1) {
            if (!inputFieldFlagUrl) {
                editCheckOutInputTrue()
            }
        } else {
            editCheckOutInputFalse()
        }
    })
}

function editCheckOutTrue() {
    // check to delete validation message
    editValidText.classList.add('d-none')
    editValidArrow.classList.add('d-none')
}

if (emailSubmitBtn) {
    emailSubmitBtn.addEventListener('click', (event) => {
        emailFlag = false;

        if (emailInput.value.length < 1) {
            event.preventDefault();
            emailCheckOutFalse();
        } else {
            // chech for valid email address
            const emailRegex = /^\w+([\.-]?\w)*@\w+([\.-]?\w)*(\.\w{2,3})+$/;
            let emailTrust = emailRegex.test(emailInput.value)

            if (!emailTrust) {
                event.preventDefault();
                emailCheckOutFalse();
            }
        }
    })

    emailInput.addEventListener('keyup', event => {
        // check for send form with enter key
        if (event.keyCode === 13) {
            emailFlag = true;

            if (emailInput.value.length < 1) {
                event.preventDefault();
                emailCheckOutFalse();
            } else {
                // check for valid email address
                const emailRegex = /^\w+([\.-]?\w)*@\w+([\.-]?\w)*(\.\w{2,3})+$/;
                let emailTrust = emailRegex.test(emailInput.value)

                console.log(emailTrust)

                if (!emailTrust) {
                    event.preventDefault();
                    emailCheckOutFalse();
                } else {
                    emailCheckOutTrue();
                    emailSubmitBtn.click();
                }

            }
        } else if (emailInput.value.length >= 1) {
            emailCheckOutTrue();
        } else {
            emailCheckOutFalse();
        }
    })
}

if (verifySubmitBtn) {
    verifySubmitBtn.addEventListener('click', (event) => {
        // check to hve 6 digits in input field
        verifyFlag = false
        if (verifyInput.value.length != 6) {
            event.preventDefault();
            verifyCheckOutFalse();
        }
    })

    verifyInput.addEventListener('keyup', event => {

        // check tp send form with enter key
        if (event.keyCode === 13) {
            verifyFlag = true;

            if (verifyInput.value.length != 6) {
                event.preventDefault();
                verifyCheckOutFalse();
            } else {
                verifyCheckOutTrue();
                verifySubmitBtn.click();
            }
        } else if (verifyInput.value.length >= 1) {
            verifyCheckOutTrue()
        } else {
            verifyCheckOutFalse()
        }
    })
}

if (editUrlSubmitBtn) {
    editUrlSubmitBtn.addEventListener('click', (event) => {
        editFlag = false;

        if (editDestInput.value.length < 1) {
            event.preventDefault();
            editCheckOutFalse();
        } else {
            // check for valid email address
            const editRegex = /^(http(s):\/\/.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/;
            let editTrust = editRegex.test(editDestInput.value)

            if (!editTrust) {
                event.preventDefault();
                editCheckOutFalse();
            }
        }
    })

    editDestInput.addEventListener('keyup', event => {
        // check to send form with enter key
        if (event.keyCode === 13) {
            editFlag = true;

            if (editDestInput.value.length < 1) {
                event.preventDefault();
                editCheckOutFalse();
            } else {
                const editRegex = /^(http(s):\/\/.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/;
                let editTrust = editRegex.test(editDestInput.value)

                console.log(editTrust)

                // check to valid email address
                if (!editTrust) {
                    event.preventDefault();
                    editCheckOutFalse();
                } else {
                    editCheckOutTrue();
                    editUrlSubmitBtn.click();
                }

            }
        } else if (editDestInput.value.length >= 1) {
            editCheckOutTrue();
        } else {
            editCheckOutFalse();
        }
    })
}


if (inputFieldUrlSubmitBtn) {
    inputFieldUrlSubmitBtn.addEventListener('click', (event) => {
        inputFieldFlagUrl = false;

        if (inputField.value.length < 1) {
            event.preventDefault();
            editCheckOutInputFalse();
        } else {
            // check for valid email address
            const editRegex = /^(https?:\/\/)(localhost|[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6})(:\d+)?(\/[-a-zA-Z0-9@:%_+.~#?&//=]*)?$/;
            let editTrust = editRegex.test(inputField.value)

            if (!editTrust) {
                event.preventDefault();
                editCheckOutInputFalse();
            }
        }
    })

    inputField.addEventListener('keyup', event => {
        // check to send form with enter key
        if (event.keyCode === 13) {
            inputFieldFlagUrl = true;

            if (inputField.value.length < 1) {
                event.preventDefault();
                editCheckOutInputFalse();
            } else {
                const editRegex = /^(http(s):\/\/.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/;
                let editTrust = editRegex.test(inputField.value)

                console.log(editTrust)

                // check to valid email address
                if (!editTrust) {
                    event.preventDefault();
                    editCheckOutInputFalse();
                } else {
                    editCheckOutInputTrue();
                    editUrlSubmitBtn.click();
                }

            }
        } else if (inputField.value.length >= 1) {
            editCheckOutInputTrue();
        } else {
            editCheckOutInputFalse();
        }
    })
}

// handle persian language of input
if (editDestInput) {
    if (editDestInput.value.length >= 1) {
        editDestInput.classList.add('input-left')
    }
    editDestInput.addEventListener('keyup', event => {
        if (editDestInput.value.length >= 1) {
            editDestInput.classList.add('input-left')
        } else {
            editDestInput.classList.remove('input-left')
        }
    })


}

// handle persian language of input
if (inputField) {
    if (inputField.value.length >= 1) {
        inputField.classList.add('input-left')
    }
    inputField.addEventListener('keyup', event => {
        if (inputField.value.length >= 1) {
            inputField.classList.add('input-left')
        } else {
            inputField.classList.remove('input-left')
        }
    })
}

if (emailInput) {
    // Check for input to valid email address
    emailInput.addEventListener('keypress', event => {
        let word = event.keyCode
        console.log(word)
        if ((word < 65 || word > 90) && (word < 97 || word > 122) && (word < 48 || word > 57) && word != 64 && word != 46) {
            event.preventDefault()
        }
    })
    // handle persian language of input
    emailInput.addEventListener('keyup', e => {
        if (emailInput.value.length >= 1) {
            emailInput.classList.add('input-left')
        } else {
            emailInput.classList.remove('input-left')
        }
    })
}

if (verifyInput) {
    // Check for input number
    verifyInput.addEventListener('keypress', event => {
        let word = event.keyCode
        console.log(word)
        if ((word < 48 || word > 57)) {
            event.preventDefault()
        }
    })
    // handle persian language of input
    verifyInput.addEventListener('keyup', e => {
        if (verifyInput.value.length >= 1) {
            verifyInput.classList.add('input-left')
        } else {
            verifyInput.classList.remove('input-left')
        }
    })
}