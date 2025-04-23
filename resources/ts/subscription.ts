// @ts-nocheck

function onRemoveUser(userId) {
    $(`[data-user-id="${userId}"]`).remove();
}

$(document).ready(function () {
    let timeout = null;
    $("#search_users").on("input", function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            $(`[data-buttons-container="search_users"]`).empty();
            if ($(this).val().length <= 2) {
                return;
            }
            $.ajax({
                url: "/admin/search/user/" + $(this).val(),
                type: "GET",
                success: (response) => {
                    // add buttons inside buttonsContainer
                    if (!response.length) {
                        const button = document.createElement("button");
                        button.type = "button";
                        button.className = "btn btn-primary";
                        button.innerHTML = "No users found";
                        $(`[data-buttons-container="search_users"]`).append(button);
                        return;
                    }
                    response.forEach((user) => {
                        if ($(`[data-user-id="${user.id}"]`).length) {
                            return;
                        }

                        const button = document.createElement("button");
                        button.type = "button";
                        button.onclick = () => onSelectUser(button, user);
                        button.className = "btn btn-primary";
                        button.innerHTML = `${user.name} - ${user.email}`;
                        $(`[data-buttons-container="search_users"]`).append(button);
                    });
                },
            });
        }, 500);
    });

    function onSelectUser(_button, user) {
        _button.remove();

        const row = document.createElement("tr");
        row.setAttribute("role", "row");
        row.setAttribute("data-user-id", user.id);

        const nameCell = document.createElement("td");
        nameCell.innerHTML = user.name;
        row.appendChild(nameCell);

        const emailCell = document.createElement("td");
        emailCell.innerHTML = user.email;
        row.appendChild(emailCell);

        const actionsCell = document.createElement("td");
        const button = document.createElement("button");
        button.type = "button";
        button.onclick = () => onRemoveUser(user.id);
        button.className = "btn btn-danger btn-sm";
        button.innerHTML = `<i class="voyager-x"></i>`;
        actionsCell.appendChild(button);

        row.appendChild(actionsCell);

        $(".table").append(row);
    }

    $("#form").submit(function (e) {
        e.preventDefault();

        const url = updateMode
            ? "/admin/mails/list/" + listId
            : "/admin/mails/list/create";
        const type = updateMode ? "PUT" : "POST";

        // get all selected users
        const users = [];
        $(`[data-user-id]`).each((_, element) => {
            users.push(element.getAttribute("data-user-id"));
        });

        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize() + "&users=" + JSON.stringify(users),
            success: function () {
                window.location.href = "/admin/mails/list";
            },
            error: function (xhr, status, err) {
                const error = xhr.responseJSON.errors;
                let errorMessage = "";
                for (const e in error) {
                    errorMessage += '<div class="error-title">' + e + ": </div> ";
                    for (const m in error[e]) {
                        errorMessage +=
                            '<div class="error-description">' + error[e][m] + "</div> ";
                    }
                    errorMessage += "<br>";
                }
                $("#errors-container").show();
                $("#errors").html(errorMessage);
            },
        });
    });
});
