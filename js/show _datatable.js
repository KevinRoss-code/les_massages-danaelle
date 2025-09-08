function show_table() {
  $("#tableUpdateMassage").DataTable({
    ajax: {
      url: "process_show_article.php", // Spécifiez l'URL de votre script PHP ici
      dataSrc: "", // Cela indique à DataTables que les données sont directement disponibles dans l'objet JSON
    },
    columns: [
      {
        data: "id",
        className: "idHidden",
      },
      {
        data: "name",
      },
      {
        data: "massage_description",
      },
      {
        data: "duree_massage",
      },
      {
        data: "prix",
      },
      {
        data: "image_path",
      },
      {
        data: null,
        orderable: false,
        title: "Modifier le massage",
        defaultContent:
          "<button class='btn-modificateur' onclick='buttonModif($(this))'>Modifier le massage</button>",
      },
      // Ajoutez d'autres colonnes si nécessaire
    ],
  });
  $("#tableUpdateFacialMakeup").DataTable({
    ajax: {
      url: "process_show_makeup.php", // Spécifiez l'URL de votre script PHP ici
      dataSrc: "", // Cela indique à DataTables que les données sont directement disponibles dans l'objet JSON
    },
    columns: [
      {
        data: "ID",
        className: "idHidden",
      },
      {
        data: "name",
      },
      {
        data: "duree",
      },
      {
        data: "prix",
      },
      {
        data: null,
        orderable: false,
        title: "Modifier le massage",
        defaultContent:
          "<button class='btn-modificateur' onclick='buttonModif($(this))'>Modifier le maquillage</button>",
      },
      // Ajoutez d'autres colonnes si nécessaire
    ],
  });
  $("#tableUpdateHair").DataTable({
    ajax: {
      url: "process_show_hair_removal.php", // Spécifiez l'URL de votre script PHP ici
      dataSrc: "", // Cela indique à DataTables que les données sont directement disponibles dans l'objet JSON
    },
    columns: [
      {
        data: "ID",
        className: "idHidden",
      },
      {
        data: "name",
      },
      {
        data: "duree",
      },
      {
        data: "prix",
      },
      {
        data: null,
        orderable: false,
        title: "Modifier le massage",
        defaultContent:
          "<button class='btn-modificateur' onclick='buttonModif($(this))'>Modifier l'épilation</button>",
      },
      // Ajoutez d'autres colonnes si nécessaire
    ],
  });
  $("#tableUpdateFacialCare").DataTable({
    ajax: {
      url: "process_show_care.php", // Spécifiez l'URL de votre script PHP ici
      dataSrc: "", // Cela indique à DataTables que les données sont directement disponibles dans l'objet JSON
    },
    columns: [
      {
        data: "ID",
        className: "idHidden",
      },
      {
        data: "name",
      },
      {
        data: "dure",
      },
      {
        data: "prix",
      },
      {
        data: null,
        orderable: false,
        title: "Modifier le massage",
        defaultContent:
          "<button class='btn-modificateur' onclick='buttonModif($(this))'>Modifier le soin du visage</button>",
      },
      // Ajoutez d'autres colonnes si nécessaire
    ],
  });
  $("#tableUpdateNail").DataTable({
    ajax: {
      url: "process_show_nail.php", // Spécifiez l'URL de votre script PHP ici
      dataSrc: "", // Cela indique à DataTables que les données sont directement disponibles dans l'objet JSON
    },
    columns: [
      {
        data: "ID",
        className: "idHidden",
      },
      {
        data: "name",
      },
      {
        data: "duree",
      },
      {
        data: "prix",
      },
      {
        data: null,
        orderable: false,
        title: "Modifier le massage",
        defaultContent:
          "<button class='btn-modificateur' onclick='buttonModif($(this))'>Modifier l'ongle</button>",
      },
      // Ajoutez d'autres colonnes si nécessaire
    ],
  });
}
show_table();

document.getElementById("selectForm").addEventListener("change", function() {
    // Masquer tous les formulaires
    document.querySelectorAll(".formulaire").forEach(form => form.classList.remove("active"));

    // Afficher celui sélectionné
    const selectedForm = this.value;
    const formToShow = document.getElementById("form" + capitalize(selectedForm));
    if (formToShow) formToShow.classList.add("active");
});

// Fonction pour mettre une majuscule à la 1re lettre
function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
function buttonModif(el) {
  console.log(el);
  createModalUpdate("warning", "Modifier l'élément", "", "");
}
