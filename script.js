$(document).ready(function () {
    const passwordForm = $("#password-form");
    const passwordContainer = $("#password-container");
    const container = $(".container");
    const filterClient = $("#filter-client");
    const filterTreatment = $("#filter-treatment");
    const filterDateStart = $("#filter-date-start");
    const filterDateEnd = $("#filter-date-end");

    passwordForm.submit(function (event) {
        event.preventDefault();

        const password = $("#password").val();

        $.post("check_password.php", { password })
            .done(function (response) {
                const { status } = JSON.parse(response);

                if (status === "success") {
                    passwordContainer.hide();
                    container.show();
                } else {
                    alert("Nieprawidłowe hasło!");
                }
            })
            .fail(function () {
                alert("Wystąpił błąd podczas sprawdzania hasła.");
            });
    });

    loadTreatments();
    loadFilterOptions();
    updateClientList();
    
    $("#show-add-treatment-form").on("click", function () {
    $("#add-treatment-form-container").toggle();
    });


    $("#treatment-form").submit(function (event) {
        event.preventDefault();

        const treatmentName = $("#treatment-name option:selected").val();
        const treatmentDate = $("#treatment-date").val();
        const clientName = $("#client-name").val();
        const treatmentPrice = $("#treatment-price").val();
        const detailedDescription = $("#detailed-description").val();

        $.post("add_treatment.php", {
            treatmentName,
            treatmentDate,
            clientName,
            treatmentPrice,
            detailedDescription,
        })
            .done(function (response) {
                const { status } = JSON.parse(response);

                if (status === "success") {
                    alert("Zabieg dodany pomyślnie.");
                    loadTreatments();
                    loadFilterOptions();
                } else {
                    alert("Wystąpił błąd podczas dodawania zabiegu.");
                }
            })
            .fail(function () {
                alert("Wystąpił błąd podczas dodawania zabiegu.");
            });
    });

    $(document).on("click", ".delete", function () {
        const id = $(this).data("id");
        if (confirm("Czy na pewno chcesz usunąć ten zabieg?")) {
            $.post("delete_treatment.php", { id })
                .done(function (response) {
                    const { status } = JSON.parse(response);

                    if (status === "success") {
                        alert("Zabieg usunięty pomyślnie.");
                        loadTreatments();
                        loadFilterOptions();
                    } else {
                        alert("Wystąpił błąd podczas usuwania zabiegu.");
                    }
                })
                .fail(function () {
                    alert("Wystąpił błąd podczas usuwania zabiegu.");
                });
        }
    });

    $(document).on("click", ".sortable", function () {
        const sortBy = $(this).data("sort");
        loadTreatments(sortBy);
    });

    $(document).on("click", ".edit", function () {
        const row = $(this).closest("tr");
        const id = $(this).data("id");

        if ($(this).text() === "Edytuj") {
            row.find("td:not(:last)").attr("contenteditable", "true");
            $(this).text("Zapisz");
        } else {
            row.find("td:not(:last)").attr("contenteditable", "false");
            $(this).text("Edytuj");

            const treatmentName = row.find("td:nth-child(1)").text();
            const treatmentDate = row.find("td:nth-child(2)").text();
            const clientName = row.find("td:nth-child(3)").text();
            const treatmentPrice = parseInt(row.find("td:nth-child(4)").text());

            $.post("update_treatment.php", {
                id,
                treatmentName,
                treatmentDate,
                clientName,
                treatmentPrice,
            })
                .done(function (response) {
                    const { status } = JSON.parse(response);

                    if (status === "success") {
                        alert("Zabieg zaktualizowany pomyślnie.");
                        loadTreatments();
                    } else {
                        alert("Wystąpił błąd podczas aktualizacji zabiegu.");
                    }
                })
                .fail(function () {
                    alert("Wystąpił błąd podczas aktualizacji zabiegu.");
                });
        }
    });

    filterClient.change(function () {
        loadTreatments();
    });

    filterTreatment.change(function () {
        loadTreatments();
    });

    filterDateStart.change(function () {
        loadTreatments();
    });

    filterDateEnd.change(function () {
        loadTreatments();
    });

    function loadTreatments(sortBy = "treatment_date") {
        const filterClientValue = filterClient.val();
        const filterTreatmentValue = filterTreatment.val();
        const filterDateStartValue = filterDateStart.val();
        const filterDateEndValue = filterDateEnd.val();

        $.post("get_treatments.php", {
            sortBy,
            filterClient: filterClientValue,
            filterTreatment: filterTreatmentValue,
            filterDateStart: filterDateStartValue,
            filterDateEnd: filterDateEndValue,
        }, function (data) {
            $("#treatments-table tbody").html(data);
        });
    }

    function loadFilterOptions() {
        $.get("get_filter_options.php", function (data) {
            const { clients, treatments } = JSON.parse(data);

            const clientOptions = clients.map(client => `<option value="${client}">${client}</option>`).join("");
            const treatmentOptions = treatments.map(treatment => `<option value="${treatment}">${treatment}</option>`).join("");

            filterClient.html(`<option value="">Wszyscy</option>${clientOptions}`);
            filterTreatment.html(`<option value="">Wszystkie</option>${treatmentOptions}`);
        });
    }
    
    function updateClientList() {
    $.getJSON("get_name.php", function (clients) {
        $("#client-name").empty();
        clients.forEach(function (client) {
            $("#client-name").append(
                $("<option>").text(client).val(client)
            );
        });
    });
    }
});
