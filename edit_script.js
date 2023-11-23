function initPangkatDropdown() {
  var lupons = luponsArray;
    var pangkatInput = document.getElementById("Pangkat"); // Define pangkatInput here
    var dropdown = document.getElementById("pangkatDropdown");
        pangkatInput.addEventListener("input", function () {
            var inputValue = pangkatInput.value.trim();
            var lastCommaIndex = inputValue.lastIndexOf(",");
            var currentName = inputValue.substring(lastCommaIndex + 1).trim();
            var filteredLupons = lupons.filter(function (lupon) {
                return lupon.toLowerCase().includes(currentName.toLowerCase());
            });

            
            dropdown.innerHTML = "";
            filteredLupons.forEach(function (lupon) {
                var option = document.createElement("div");
                option.textContent = lupon;
                option.className = "dropdown-option";
                option.addEventListener("click", function () {
                    var prefix = inputValue.substring(0, lastCommaIndex + 1);
                    pangkatInput.value = prefix + " " + lupon + ", ";
                    dropdown.innerHTML = "";
                });
                dropdown.appendChild(option);
            });

            
            var inputRect = pangkatInput.getBoundingClientRect();
            dropdown.style.top = inputRect.bottom + "px";
            dropdown.style.left = inputRect.left + "px";
            dropdown.style.width = pangkatInput.offsetWidth + "px";
            dropdown.style.display = "block";
        });

        // Hide the dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (event.target !== pangkatInput && event.target !== dropdown) {
                dropdown.style.display = "none";
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        initPangkatDropdown();
    });
// JavaScript to handle dynamic options for Case Method based on Case Status
document.addEventListener("DOMContentLoaded", function () {
    var cStatusSelect = document.getElementById('cStatusSelect');
    var cMethodSelect = document.getElementById('CMethodSelect');

    cStatusSelect.addEventListener('change', function () {
        // Clear previous options
        cMethodSelect.innerHTML = '';

        // Define options based on the selected Case Status
        var selectedStatus = cStatusSelect.value;
        var options = [];

        if (selectedStatus === 'Settled') {
            options = ['Mediation', 'Conciliation', 'Arbitration'];
        } else if (selectedStatus === 'Unsettled') {
            options = ['Pending', 'Dismissed', 'Repudiated', 'Certified to File Action in Court', 'Dropped/Withdrawn'];
        }

        // Populate options in the Case Method select tag
        options.forEach(function (option) {
            var optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.textContent = option;
            cMethodSelect.appendChild(optionElement);
        });

        // Disable or hide Case Method input for 'Outside the Jurisdiction'
        if (selectedStatus === 'Others') {
            cMethodSelect.disabled = true; // Or hide the input field
        } else {
            cMethodSelect.disabled = false; // Enable the input field
        }
    });

    // Trigger change event initially to set appropriate options based on Case Status
    cStatusSelect.dispatchEvent(new Event('change'));
});