$(document).ready(function () {
    loadClients();

    $("#client-form").submit(function (event) {
        event.preventDefault();

        const clientName = $("#client-name").val();
        const birthDate = $("#birth-date").val();
        const phoneNumber = $("#phone-number").val();
        const location = $("#location").val();
        const additionalInfo = $("#additional-info").val();

        $.post("add_client.php", {
            clientName,
            birthDate,
            phoneNumber,
            location,
            additionalInfo,
        })
            .done(function (response) {
                const { status } = JSON.parse(response);

                if (status === "success") {
                    alert("Klient dodany pomyślnie.");
                    loadClients();
                } else {
                    alert("Wystąpił błąd podczas dodawania klienta.");
                }
            })
            .fail(function () {
                alert("Wystąpił błąd podczas dodawania klienta.");
            });
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

            const birthDate = row.find("td:nth-child(2)").text();
            const age = parseInt(row.find("td:nth-child(3)").text());
            const phoneNumber = row.find("td:nth-child(4)").text();
            const location = row.find("td:nth-child(5)").text();
            const additionalInfo = row.find("td:nth-child(6)").text();

            $.post("update_client.php", {
                id,
                birthDate,
                age,
                phoneNumber,
                location,
                additionalInfo,
            })
                .done(function (response) {
                    const { status } = JSON.parse(response);

                    if (status === "success") {
                        alert("Dane klienta zaktualizowane pomyślnie.");
                        loadClients();
                    } else {
                        alert("Wystąpił błąd podczas aktualizacji danych klienta.");
                    }
                })
                .fail(function () {
                    alert("Wystąpił błąd podczas aktualizacji danych klienta.");
                });
        }
    });

    function loadClients() {
        $.get("get_clients.php", function (data) {
            $("#clients-table tbody").html(data);
        });
    }
});
