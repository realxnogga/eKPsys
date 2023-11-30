// JavaScript for clearing all input boxes
        document.getElementById('clear-button').addEventListener('click', function() {
            const inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(input => {
                input.value = '';
            });
            // Reset the linkedNames array to empty
            linkedNames = [];
            // Update the displayed names
            updateDisplayedNames();
        });

        // Function to update the displayed names based on the linkedNames array
        function updateDisplayedNames() {
            const nameInputs = document.querySelectorAll('input[name="linked_name[]"]');
            for (let i = 0; i < linkedNames.length; i++) {
                nameInputs[i].value = linkedNames[i];
            }
        }

        // JavaScript for opening and loading forms into the iframe
        function openAndLoadForm(formSrc) {
            const iframe = document.getElementById('kp-form-iframe');
            iframe.src = formSrc;

            const modal = document.getElementById('kp-form-modal');
            modal.style.display = 'block';
        }

        document.getElementById('open-kp-form1').addEventListener('click', function() {
            openAndLoadForm('formsT/kp_form1.php');
        });

        document.getElementById('open-kp-form2').addEventListener('click', function() {
            openAndLoadForm('forms/kp_form2.php');
        });

        document.getElementById('open-kp-form3').addEventListener('click', function() {
            openAndLoadForm('forms/kp_form3.php');
        });

        document.getElementById('open-kp-form4').addEventListener('click', function() {
            openAndLoadForm('forms/kp_form4.php');
        });

        document.getElementById('open-kp-form5').addEventListener('click', function() {
            openAndLoadForm('forms/kp_form5.php');
        });

        document.getElementById('open-kp-form6').addEventListener('click', function() {
            openAndLoadForm('forms/kp_form6.php');
        });
// Function to adjust the input fields to fill gaps
function adjustInputFields() {
    let lastIndex = 0;
    const nameInputs = document.querySelectorAll('input[name="linked_name[]"]');
    nameInputs.forEach((input, index) => {
        if (input.value !== '') {
            lastIndex = index + 1;
        } else {
            input.value = ''; // Ensure empty values are truly empty
        }
        input.placeholder = `Name ${lastIndex}`;
    });
}

// Closing parenthesis added here
window.addEventListener('click', function(event) {
    const modal = document.getElementById('kp-form-modal');
    const iframe = document.getElementById('kp-form-iframe');

    if (modal && event.target === modal) {
        iframe.src = ''; // Clear the iframe source
        modal.style.display = 'none';
    }
}); 

// JavaScript for closing the modal when pressing Esc key
window.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeFormModal();
    }
});

// Function to close the form modal
function closeFormModal() {
    const iframe = document.getElementById('kp-form-iframe');
    iframe.src = ''; // Clear the iframe source

    const modal = document.getElementById('kp-form-modal');
    modal.style.display = 'none';
}

document.getElementById('englishforms').addEventListener('click', function() {
    // Change the English button color to dark brown
    this.classList.remove('btn-success');
    this.classList.add('btn-dark');

    // Change the Tagalog button color to success brown
    document.getElementById('tagalogforms').classList.remove('btn-dark');
    document.getElementById('tagalogforms').classList.add('btn-success');

    // Change the KP Form 1-6 buttons to dark brown
    for (let i = 1; i <= 6; i++) {
        document.getElementById(`open-kp-form${i}`).classList.add('btn-dark');
        document.getElementById(`open-kp-form${i}`).classList.remove('btn-success');
    }
});

document.getElementById('tagalogforms').addEventListener('click', function() {
    // Change the Tagalog button color to dark brown
    this.classList.remove('btn-success');
    this.classList.add('btn-dark');

    // Change the English button color to success brown
    document.getElementById('englishforms').classList.remove('btn-dark');
    document.getElementById('englishforms').classList.add('btn-success');

    // Change the KP Form 1-6 buttons to success brown
    for (let i = 1; i <= 6; i++) {
        document.getElementById(`open-kp-form${i}`).classList.remove('btn-dark');
        document.getElementById(`open-kp-form${i}`).classList.add('btn-success');
    }
});

