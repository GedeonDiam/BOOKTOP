 // Fonction pour peupler la liste déroulante pays
 function populateDropdown(data) {
    var select = document.getElementById("pays");
    for (var i = 0; i < data.length; i++) {
        var option = document.createElement("option");
        option.text = data[i].name;
        option.value = data[i].code;
        option.dataset.countryCode = data[i].dial_code; // Ajout de l'attribut data-country-code
        select.appendChild(option);
    }
}

// Charger le fichier JSON
fetch('../JS/ListePaysCode.json')
    .then(response => response.json())
    .then(data => populateDropdown(data))
    .catch(error => console.error('Erreur lors du chargement du JSON :', error));

// Gestionnaire d'événements pour mettre à jour l'indicatif du pays lors du changement de sélection
document.getElementById("pays").addEventListener("change", function() {
    // Récupérer l'élément sélectionné dans la liste déroulante
    var selectedCountry = this.options[this.selectedIndex];

    // Récupérer l'indicatif du pays
    var countryCode = selectedCountry.dataset.countryCode;

     // Mettre à jour le champ de numéro de téléphone avec l'indicatif du pays
     document.getElementById("tel").value = countryCode + " ";
});