(function ($) {
    "use strict";

    // Spinner
    const spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();

    // Initiate the wowjs
    new WOW().init();

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
            $('.hero-header .text-white').css('margin-top', '3rem !important');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });

})(jQuery);


//Searcher
$(document).ready(function () {
    $("#restaurant-search").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "{{ route('search') }}",
                data: {
                    search: request.term
                },
                dataType: "json",
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.name,
                            value: item.name
                        }
                    }));
                }
            });
        },
        minLength: 2
    });
});

/*** Register ***/
let currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
    // This function will display the specified tab of the form...
    const x = document.getElementsByClassName("step");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
    clearAllErrorMessages();
}

function nextPrev(n) {
    // This function will figure out which tab to display
    const x = document.getElementsByClassName("step");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
        // ... the form gets submitted:
        document.getElementById("registerForm").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}

function validateForm() {

    switch (currentTab) {
        case 0:
            valid = validateTab1();
            break;
        case 1:
            valid = validateTab2();
            break;
        case 2:
            valid = validateTab3();
            break;

    }

    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
    }

    return valid;
}

function validateTab1() {

    // This function deals with validation of the form fields
    let x, y, i, valid = true;
    x = document.getElementsByClassName("step");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
            // and set the current valid status to false
            valid = false;
            showErrorInputTextMessage("This field is mandatory", y[i].name)
        } else if (y[i].name == "email" && !validateEmail(y[i].value)) {
            valid = false;
            showErrorInputTextMessage("The email has to have an email format.", "email")
        } else if (y[i].name == "password" && y[i].value.length < 8) {
            valid = false;
            showErrorInputTextMessage("Password must be at least 8 characters long.", "password");
        } else {
            clearErrorInputTextMessage(y[i].name);
        }
    }

    return valid; // return the valid status
}

function validateTab2() {

    // This function deals with validation of the form fields
    let x, y, i, valid = true;
    let oneChecked = false;
    x = document.getElementsByClassName("step");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].checked == true) {
            // and set the current valid status to false
            oneChecked = true;
            break;
        }
    }

    if (!oneChecked) {
        showErrorCheckboxMessage("At least one food type must be selected", "food-type-container");
        valid = false;
    } else {
        clearErrorCheckboxMessage("food-type-container");
    }

    return valid; // return the valid status
}

function validateTab3() {

    let x, y, i, valid = true;
    let onePriceRangeChecked = false;
    let oneScheduleChecked = false;

    x = document.getElementsByClassName("step");
    y = x[currentTab].getElementsByTagName("input");

    for (i = 0; i < y.length; i++) {
        if (y[i].name == 'price_ranges[]' && y[i].checked == true && !onePriceRangeChecked) {
            onePriceRangeChecked = true;
        } else if (y[i].name == 'schedules[]' && y[i].checked == true && !oneScheduleChecked) {
            oneScheduleChecked = true;
        } else if (y[i].id == 'location') {
            if(y[i].value == ''){
                valid = false;
                showErrorInputTextMessage("The location is mandatory", "location");
            } else {
                clearErrorInputTextMessage('location');
            }
        }
    }

    if (!onePriceRangeChecked) {
        showErrorCheckboxMessage("At least one price range must be selected", "price-range-container");
        valid = false;
    } else {
        clearErrorCheckboxMessage("price-range-container");
    }

    if (!oneScheduleChecked) {
        showErrorCheckboxMessage("At least one shcedule must be selected", "schedule-container");
        valid = false;
    } else {
        clearErrorCheckboxMessage("schedule-container");
    }

    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    let i, x = document.getElementsByClassName("stepIndicator");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
        if (i > n) {
            x[i].className = x[i].className.replace(" finish", "");
        }
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
}

function validateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
    }
    return (false)
}

function showErrorInputTextMessage(message, input) {
    clearErrorInputTextMessage(input);
    inputElement = document.getElementById(input);
    span = document.createElement("span");
    span.classList.add("invalid-feedback");
    span.classList.add("register-error");
    span.setAttribute("role", "alert")
    messageElement = document.createElement("strong");
    messageElement.innerHTML = message;
    span.appendChild(messageElement);
    inputElement.parentNode.insertBefore(span, inputElement.nextSibling)
    inputElement.classList.add("is-invalid");

}

function showErrorCheckboxMessage(message, input) {
    clearErrorCheckboxMessage(input);
    inputElement = document.getElementById(input);
    div = document.createElement("div");
    div.classList.add("checkbox-error");
    div.classList.add("register-error");
    div.setAttribute("role", "alert")
    messageElement = document.createElement("strong");
    messageElement.innerHTML = message;
    div.appendChild(messageElement);
    inputElement.appendChild(div);
}

function clearErrorInputTextMessage(input) {
    inputElement = document.getElementById(input);
    if (inputElement.nextSibling.tagName === 'SPAN') {
        inputElement.classList.remove("is-invalid");
        inputElement.parentNode.removeChild(inputElement.nextSibling)
    }
}

function clearErrorCheckboxMessage(input) {
    inputElement = document.getElementById(input);
    if (inputElement.querySelector('.checkbox-error')) {
        inputElement.removeChild(inputElement.querySelector('.checkbox-error'))
    }
}

function clearAllErrorMessages() {
    let get = document.querySelectorAll('.register-error');
    get.forEach(element => {
        if (element.tagName === 'SPAN') {
            element.previousSibling.classList.remove("is-invalid");
        }
        element.remove();
    });
}
/*** End register ***/
