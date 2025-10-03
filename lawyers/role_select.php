<!DOCTYPE html>
<html>
<head>
    <title>Select Role</title>
    <script>
        setTimeout(function () {
            document.getElementById("roleBox").style.display = "block";
        }, 3000);
    </script>
</head>
<body>
    <div id="roleBox" style="display:none; text-align:center;">
        <h2>If you are a user, click below</h2>
        <a href="user.index.php"><button>User</button></a>
        <h2>If you are a lawyer, click below</h2>
        <a href="lawyer.index.php"><button>Lawyer</button></a>
    </div>
</body>
</html>
