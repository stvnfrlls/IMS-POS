function login() {
  var username = $("#username").val();
  var password = $("#password").val();

  if (!username) {
    $("#response").html('<div class="alert alert-danger">Please enter a username.</div>');
    return;
  }

  if (!password) {
    $("#response").html('<div class="alert alert-danger">Please enter a password.</div>');
    return;
  }

  $.ajax({
    type: "POST",
    url: "includes/requests/login.php",
    data: {
      username: username,
      password: password,
    },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        window.location.href = response.redirect;
      } else {
        $("#response").html(
          '<div class="alert alert-danger">' + response.message + "</div>"
        );
      }
    },
    error: function (xhr, error) {
      console.log("Error:", error);
      console.log("Response:", xhr.responseText);
    },
  });
}

function AdminAccount() {
  $.ajax({
    type: "POST",
    url: "includes/requests/login.php",
    data: {
      username: 'admin@admin.com',
      password: 'Password',
    },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        window.location.href = response.redirect;
      } else {
        $("#response").html(
          '<div class="alert alert-danger">' + response.message + "</div>"
        );
      }
    },
    error: function (xhr, error) {
      console.log("Error:", error);
      console.log("Response:", xhr.responseText);
    },
  });
}

function StaffAccount() {
  $.ajax({
    type: "POST",
    url: "includes/requests/login.php",
    data: {
      username: 'staff@staff.com',
      password: 'Password',
    },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        window.location.href = response.redirect;
      } else {
        $("#response").html(
          '<div class="alert alert-danger">' + response.message + "</div>"
        );
      }
    },
    error: function (xhr, error) {
      console.log("Error:", error);
      console.log("Response:", xhr.responseText);
    },
  });
}

function register() {
  var name = $("#inputName").val();
  var email = $("#inputEmail").val();
  var password = $("#inputPassword").val();
  var role = $("#inputRole").val();
  $.ajax({
    type: "POST",
    url: "../includes/requests/addUser.php",
    data: {
      name: name,
      email: email,
      password: password,
      role: role,
    },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        getUserList();
      } else {
        $("#response").html(
          '<div class="alert alert-danger">' + response.message + "</div>"
        );
      }
    },
    error: function (error) {
      console.log("Error:", error);
    },
  });
}

function getUserList() {
  $.ajax({
    type: "GET",
    url: "../includes/requests/getUserData.php",
    dataType: "json",

    success: function (response) {
      var userData = response.user;

      populateUserTable("userList", userData);
      populateUpdateUserTable("updateList", userData);
      populateRemoveUserTable("removeList", userData);
    },

    error: function (status, error) {
      console.error("Error:", status, error);
    },
  });
}

function populateUserTable(tableId, data) {
  var tableBody = document.getElementById(tableId);

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);

    cell1.innerHTML = data[i].name;
    cell2.innerHTML = data[i].role;
  }
}

function populateUpdateUserTable(tableId, data) {
  var tableBody = document.getElementById(tableId);

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = data[i].name;
    cell2.innerHTML = data[i].email;
    cell3.innerHTML = data[i].role;

    var selectButton = document.createElement("button");
    selectButton.innerHTML = "Select";
    selectButton.className = "btn btn-primary";

    selectButton.addEventListener(
      "click",
      (function (user) {
        return function () {
          $("#updateUserName").val(user.name);
          $("#updateEmail").val(user.email);
          $("#UpdateRole").val(user.role);
          $("#updatePassword").val(user.password);
        };
      })(data[i])
    );

    cell4.appendChild(selectButton);
  }
}

function populateRemoveUserTable(tableId, data) {
  var tableBody = document.getElementById(tableId);

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = data[i].name;
    cell2.innerHTML = data[i].email;
    cell3.innerHTML = data[i].role;

    var dangerButton = document.createElement("button");
    dangerButton.innerHTML = "Delete";
    dangerButton.className = "btn btn-danger";

    dangerButton.addEventListener(
      "click",
      (function (user_id) {
        return function () {
          $.ajax({
            type: "POST",
            url: "../includes/requests/deleteUser.php",
            data: {
              user_id: user_id,
            },
            dataType: "json",
            success: function (response) {
              if (response.success) {
                getUserList();
              } else {
                alert(response.message);
              }
            },
            error: function (error) {
              console.log("Error:", error);
            },
          });
        };
      })(data[i].id)
    );

    cell4.appendChild(dangerButton);
  }
}
